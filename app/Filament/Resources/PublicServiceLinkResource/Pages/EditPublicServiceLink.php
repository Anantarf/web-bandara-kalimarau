<?php

namespace App\Filament\Resources\PublicServiceLinkResource\Pages;

use App\Filament\Resources\PublicServiceLinkResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPublicServiceLink extends EditRecord
{
    protected static string $resource = PublicServiceLinkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
