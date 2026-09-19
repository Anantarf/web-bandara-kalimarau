<?php

namespace App\Filament\Resources\ContactMessageResource\Pages;

use App\Filament\Resources\ContactMessageResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListContactMessages extends ListRecords
{
    protected static string $resource = ContactMessageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Tambah Pesan'),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Semua Pesan')
                ->badge(fn () => static::getResource()::getModel()::count()),
            'new' => Tab::make('Pesan Baru')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'new'))
                ->badge(fn () => static::getResource()::getModel()::where('status', 'new')->count())
                ->badgeColor('danger'),
            'read' => Tab::make('Sudah Dibaca')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'read'))
                ->badge(fn () => static::getResource()::getModel()::where('status', 'read')->count())
                ->badgeColor('warning'),
            'replied' => Tab::make('Sudah Dibalas')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'replied'))
                ->badge(fn () => static::getResource()::getModel()::where('status', 'replied')->count())
                ->badgeColor('success'),
            'archived' => Tab::make('Diarsipkan')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'archived'))
                ->badgeColor('gray'),
        ];
    }
}
