<?php

namespace App\Filament\Resources\PpidDocumentResource\Pages;

use App\Filament\Resources\PpidDocumentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPpidDocument extends EditRecord
{
    protected static string $resource = PpidDocumentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
