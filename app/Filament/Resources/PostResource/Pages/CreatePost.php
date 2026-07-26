<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use App\Models\Category;
use Filament\Resources\Pages\CreateRecord;

class CreatePost extends CreateRecord
{
    protected static string $resource = PostResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['category_id'] ??= Category::firstOrCreate(
            ['slug' => 'berita'],
            ['name' => 'Berita', 'sort_order' => 0],
        )->id;

        return $data;
    }
}
