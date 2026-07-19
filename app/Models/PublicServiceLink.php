<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class PublicServiceLink extends Model
{
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
