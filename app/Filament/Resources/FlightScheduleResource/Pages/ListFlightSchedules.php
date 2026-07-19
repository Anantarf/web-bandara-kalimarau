<?php

namespace App\Filament\Resources\FlightScheduleResource\Pages;

use App\Filament\Resources\FlightScheduleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFlightSchedules extends ListRecords
{
    protected static string $resource = FlightScheduleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
