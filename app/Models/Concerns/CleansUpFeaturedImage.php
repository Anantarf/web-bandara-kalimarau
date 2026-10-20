<?php

namespace App\Models\Concerns;

use App\Support\MediaStorage;
use Illuminate\Support\Facades\DB;

trait CleansUpFeaturedImage
{
    protected static function bootCleansUpFeaturedImage(): void
    {
        static::updated(function ($model): void {
            if ($model->wasChanged('featured_image') && $model->getOriginal('featured_image')) {
                $previousPath = $model->getOriginal('featured_image');

                DB::afterCommit(fn () => MediaStorage::disk()->delete($previousPath));
            }
        });

        static::deleted(function ($model): void {
            if ($model->featured_image) {
                $path = $model->featured_image;

                DB::afterCommit(fn () => MediaStorage::disk()->delete($path));
            }
        });
    }
}
