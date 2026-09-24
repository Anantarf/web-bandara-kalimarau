<?php

namespace App\Models\Concerns;

use Illuminate\Support\Facades\Storage;

trait CleansUpFeaturedImage
{
    protected static function bootCleansUpFeaturedImage(): void
    {
        static::updating(function ($model) {
            if ($model->isDirty('featured_image') && $model->getOriginal('featured_image')) {
                Storage::disk('public')->delete($model->getOriginal('featured_image'));
            }
        });

        static::saved(function ($model) {
            if (($model->wasChanged('featured_image') || $model->wasRecentlyCreated) && filled($model->featured_image)) {
                $path = Storage::disk('public')->path($model->featured_image);
                \App\Services\ImageOptimizer::optimize($path);
            }
        });

        static::deleted(function ($model) {
            if ($model->featured_image) {
                Storage::disk('public')->delete($model->featured_image);
            }
        });
    }
}
