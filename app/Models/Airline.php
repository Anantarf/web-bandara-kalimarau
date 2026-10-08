<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Airline extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'logo',
        'routes',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (Airline $airline): void {
            if (empty($airline->slug) && filled($airline->name)) {
                $airline->slug = Str::slug($airline->name);
            } elseif (filled($airline->slug)) {
                $airline->slug = Str::slug($airline->slug);
            }
        });

        static::updating(function (Airline $airline): void {
            $oldLogo = $airline->getOriginal('logo');
            if ($airline->isDirty('logo') && $oldLogo && ! static::isStaticPath($oldLogo)) {
                Storage::disk('public')->delete($oldLogo);
            }
        });

        static::saved(function (Airline $airline): void {
            if (($airline->wasChanged('logo') || $airline->wasRecentlyCreated) && filled($airline->logo) && ! static::isStaticPath($airline->logo)) {
                $path = Storage::disk('public')->path($airline->logo);
                if (file_exists($path)) {
                    \App\Services\ImageOptimizer::optimize($path);
                }
            }
        });

        static::deleted(function (Airline $airline): void {
            if ($airline->logo && ! static::isStaticPath($airline->logo)) {
                Storage::disk('public')->delete($airline->logo);
            }
        });
    }

    public static function isStaticPath(?string $path): bool
    {
        if (! $path) {
            return true;
        }

        return str_starts_with($path, 'images/') || str_contains($path, 'legacy');
    }

    protected function logoUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (! $this->logo) {
                    return null;
                }

                if (str_starts_with($this->logo, 'http://') || str_starts_with($this->logo, 'https://')) {
                    return $this->logo;
                }

                if (str_starts_with($this->logo, 'images/')) {
                    return asset($this->logo);
                }

                return Storage::disk('public')->url($this->logo);
            }
        );
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }
}
