<?php

namespace App\Filament\Resources\MediaResource\Pages;

use App\Filament\Resources\MediaResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Storage;

class CreateMedia extends CreateRecord
{
    protected static string $resource = MediaResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $path = $data['path'];
        $absolutePath = Storage::disk('public')->path($path);
        $imageSize = @getimagesize($absolutePath);

        return array_merge($data, [
            'disk' => 'public',
            'filename' => basename($path),
            'mime_type' => Storage::disk('public')->mimeType($path) ?: 'application/octet-stream',
            'size' => Storage::disk('public')->size($path),
            'width' => $imageSize[0] ?? null,
            'height' => $imageSize[1] ?? null,
        ]);
    }
}
