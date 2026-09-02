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
        'formulir-pengajuan-informasi' => 'Formulir Pengajuan Informasi',
        'prosedur-permohonan-informasi' => 'Prosedur Permohonan Informasi',
        'prosedur-keberatan-informasi' => 'Prosedur Permohonan Keberatan Informasi',
        'prosedur-sengketa-informasi-publik' => 'Prosedur Sengketa Informasi Publik',
    ];

    protected $fillable = [
        'title',
        'description',
        'category',
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

    public function getFileUrlAttribute(): string
    {
        return Storage::disk('public')->url($this->file_path);
    }
}
