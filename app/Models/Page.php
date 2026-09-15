<?php

namespace App\Models;

use App\Models\Concerns\CleansUpFeaturedImage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Page extends Model
{
    public const STATUSES = [
        'draft' => 'Draf',
        'published' => 'Diterbitkan',
        'archived' => 'Diarsipkan',
    ];

    use CleansUpFeaturedImage;

    protected $fillable = [
        'legacy_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'status',
        'template',
        'seo_title',
        'seo_description',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (Page $page): void {
            if (filled($page->slug)) {
                $page->slug = Str::slug($page->slug);
            }
        });
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function getFeaturedImageUrlAttribute(): ?string
    {
        return $this->featured_image ? asset('storage/'.$this->featured_image) : null;
    }
}
