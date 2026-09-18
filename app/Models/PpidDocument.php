<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PpidDocument extends Model
{
    use HasFactory;

    public const CATEGORIES = [
        'informasi-berkala' => 'Informasi Berkala',
        'informasi-setiap-saat' => 'Informasi Setiap Saat',
        'informasi-serta-merta' => 'Informasi Serta Merta',
        'regulasi' => 'Regulasi',
        'prosedur-permohonan-informasi' => 'Prosedur Permohonan Informasi',
        'prosedur-keberatan-informasi' => 'Prosedur Permohonan Keberatan Informasi',
    ];

    protected static function booted(): void
    {
        static::updating(function (PpidDocument $document): void {
            if ($document->isDirty('file_path') && $document->getOriginal('file_path')) {
                Storage::disk('public')->delete($document->getOriginal('file_path'));
            }
        });

        static::deleted(function (PpidDocument $document): void {
            if ($document->file_path) {
                Storage::disk('public')->delete($document->file_path);
            }
        });
    }

    protected $fillable = [
        'title',
        'description',
        'category',
        'external_url',
        'file_path',
        'is_active',
        'published_at',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->where('is_active', true)
            ->where(function (Builder $query): void {
                $query->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            });
    }

    public function getCategoryLabelAttribute(): string
    {
        return self::CATEGORIES[$this->category] ?? str($this->category)->replace('-', ' ')->title()->toString();
    }

    public function hasFile(): bool
    {
        return filled($this->external_url) || filled($this->file_path);
    }

    public function getFileUrlAttribute(): string
    {
        if (filled($this->external_url)) {
            return $this->external_url;
        }

        if (filled($this->file_path)) {
            return Storage::disk('public')->url($this->file_path);
        }

        return '#';
    }
}
