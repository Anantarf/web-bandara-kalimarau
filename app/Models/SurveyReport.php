<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class SurveyReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'period_date',
        'file_path',
        'external_url',
        'google_drive_id',
        'cover_image',
        'description',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'period_date' => 'date',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    protected static function booted(): void
    {
        static::saving(function (SurveyReport $report): void {
            if (filled($report->external_url) && blank($report->google_drive_id)) {
                if (preg_match('/\/d\/([a-zA-Z0-9_-]+)/', $report->external_url, $matches)) {
                    $report->google_drive_id = $matches[1];
                } elseif (preg_match('/id=([a-zA-Z0-9_-]+)/', $report->external_url, $matches)) {
                    $report->google_drive_id = $matches[1];
                }
            }
        });

        static::updating(function (SurveyReport $report): void {
            if ($report->isDirty('file_path') && $report->getOriginal('file_path')) {
                Storage::disk('public')->delete($report->getOriginal('file_path'));
            }
            if ($report->isDirty('cover_image') && $report->getOriginal('cover_image')) {
                Storage::disk('public')->delete($report->getOriginal('cover_image'));
            }
        });

        static::deleted(function (SurveyReport $report): void {
            if ($report->file_path) {
                Storage::disk('public')->delete($report->file_path);
            }
            if ($report->cover_image) {
                Storage::disk('public')->delete($report->cover_image);
            }
        });
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function getLinkUrlAttribute(): string
    {
        if (filled($this->external_url)) {
            return $this->external_url;
        }

        if (filled($this->file_path)) {
            return Storage::disk('public')->url($this->file_path);
        }

        return '#';
    }

    public function getThumbnailUrlAttribute(): string
    {
        if (filled($this->cover_image)) {
            return Storage::disk('public')->url($this->cover_image);
        }

        if (filled($this->google_drive_id)) {
            return "https://drive.google.com/thumbnail?id={$this->google_drive_id}&sz=w800";
        }

        return asset('images/logo-header.png');
    }
}
