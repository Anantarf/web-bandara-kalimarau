<?php

namespace App\Filament\Resources\MediaResource\Pages;

use App\Filament\Resources\MediaResource;
use App\Support\MediaStorage;
use Filament\Resources\Pages\CreateRecord;

class CreateMedia extends CreateRecord
{
    protected static string $resource = MediaResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $path = $data['path'];
        $absolutePath = MediaStorage::disk()->path($path);
        $imageSize = @getimagesize($absolutePath);

        return array_merge($data, [
            'disk' => MediaStorage::diskName(),
            'filename' => basename($path),
            'mime_type' => MediaStorage::disk()->mimeType($path) ?: 'application/octet-stream',
            'size' => MediaStorage::disk()->size($path),
            'width' => $imageSize[0] ?? null,
            'height' => $imageSize[1] ?? null,
        ]);
    }
}
