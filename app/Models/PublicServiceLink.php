<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PublicServiceLink extends Model
{
    public const CATEGORIES = [
        'Pengaduan' => 'Pengaduan',
        'Layanan Bandara' => 'Layanan Bandara',
        'Survei' => 'Survei',
    ];

    protected static function booted(): void
    {
        static::saving(function (PublicServiceLink $link): void {
            if (filled($link->slug)) {
                $link->slug = Str::slug($link->slug);
            }
        });
    }

    protected $fillable = [
        'title',
        'slug',
        'description',
        'url',
        'category',
        'is_external',
        'is_active',
        'icon',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_external' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }
}
