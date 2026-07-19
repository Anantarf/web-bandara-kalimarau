<?php

namespace App\Filament\Resources\AirportStatResource\Pages;

use App\Filament\Resources\AirportStatResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageAirportStats extends ManageRecords
{
    protected static string $resource = AirportStatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
