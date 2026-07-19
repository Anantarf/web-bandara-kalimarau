<?php

namespace App\Filament\Resources\PublicServiceLinkResource\Pages;

use App\Filament\Resources\PublicServiceLinkResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPublicServiceLinks extends ListRecords
{
    protected static string $resource = PublicServiceLinkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
