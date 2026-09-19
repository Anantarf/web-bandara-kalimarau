<?php

namespace App\Filament\Resources\FlightScheduleResource\Pages;

use App\Filament\Resources\FlightScheduleResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListFlightSchedules extends ListRecords
{
    protected static string $resource = FlightScheduleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Tambah Jadwal'),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Semua Jadwal')
                ->badge(fn () => static::getResource()::getModel()::count()),
            'keberangkatan' => Tab::make('Keberangkatan')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('type', 'keberangkatan'))
                ->badge(fn () => static::getResource()::getModel()::where('type', 'keberangkatan')->count())
                ->badgeColor('info'),
            'kedatangan' => Tab::make('Kedatangan')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('type', 'kedatangan'))
                ->badge(fn () => static::getResource()::getModel()::where('type', 'kedatangan')->count())
                ->badgeColor('success'),
            'active' => Tab::make('Sedang Aktif')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('is_active', true))
                ->badge(fn () => static::getResource()::getModel()::where('is_active', true)->count())
                ->badgeColor('primary'),
            'inactive' => Tab::make('Nonaktif')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('is_active', false))
                ->badge(fn () => static::getResource()::getModel()::where('is_active', false)->count())
                ->badgeColor('gray'),
        ];
    }
}
