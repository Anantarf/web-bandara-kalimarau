<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Award extends Model
{
    protected $fillable = [
        'title',
        'issuer',
        'year',
        'image',
        'description',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'year' => 'integer',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::updating(function (Award $award): void {
            $oldImage = $award->getOriginal('image');
            if ($award->isDirty('image') && $oldImage && ! static::isLegacyPath($oldImage)) {
                Storage::disk('public')->delete($oldImage);
            }
        });

        static::saved(function (Award $award): void {
            if (($award->wasChanged('image') || $award->wasRecentlyCreated) && filled($award->image) && ! static::isLegacyPath($award->image)) {
                $path = Storage::disk('public')->path($award->image);
                \App\Services\ImageOptimizer::optimize($path);
            }
        });

        static::deleted(function (Award $award): void {
            if ($award->image && ! static::isLegacyPath($award->image)) {
                Storage::disk('public')->delete($award->image);
            }
        });
    }

    protected static function isLegacyPath(?string $path): bool
    {
        if (! $path) {
            return true;
        }

        return str_contains($path, 'legacy') || str_starts_with($path, 'media/');
    }

    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: function (): ?string {
                if (! $this->image) {
                    return null;
                }

                if (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://')) {
                    return $this->image;
                }

                if (str_starts_with($this->image, 'storage/')) {
                    return asset($this->image);
                }

                return Storage::disk('public')->url($this->image);
            }
        );
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order', 'asc')
            ->orderBy('year', 'desc')
            ->orderBy('id', 'desc');
    }
}
