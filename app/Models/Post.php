<?php

namespace App\Models;

use App\Models\Concerns\CleansUpFeaturedImage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

/**
 * @property int $author_id
 *
 * @mixin Builder
 */
class Post extends Model
{
    public const STATUSES = [
        'draft' => 'Draf',
        'published' => 'Diterbitkan',
        'archived' => 'Diarsipkan',
    ];

    use CleansUpFeaturedImage;

    protected $fillable = [
        'legacy_id',
        'category_id',
        'author_id',
        'featured_image',
        'title',
        'slug',
        'excerpt',
        'content',
        'status',
        'is_featured',
        'is_pinned',
        'seo_title',
        'seo_description',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'is_pinned' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (Post $post): void {
            if (filled($post->slug)) {
                $post->slug = Str::slug($post->slug);
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

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function getFeaturedImageUrlAttribute(): ?string
    {
        return $this->featured_image ? asset('storage/'.$this->featured_image) : null;
    }
}
