<?php

namespace App\Filament\Resources\PpidDocumentResource\Pages;

use App\Filament\Resources\PpidDocumentResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListPpidDocuments extends ListRecords
{
    protected static string $resource = PpidDocumentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Tambah Dokumen PPID'),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Semua Dokumen')
                ->badge(fn () => static::getResource()::getModel()::count()),
            'berkala' => Tab::make('Informasi Berkala')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('category', 'informasi-berkala'))
                ->badge(fn () => static::getResource()::getModel()::where('category', 'informasi-berkala')->count())
                ->badgeColor('info'),
            'setiap_saat' => Tab::make('Setiap Saat')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('category', 'informasi-setiap-saat'))
                ->badge(fn () => static::getResource()::getModel()::where('category', 'informasi-setiap-saat')->count())
                ->badgeColor('success'),
            'serta_merta' => Tab::make('Serta Merta')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('category', 'informasi-serta-merta'))
                ->badge(fn () => static::getResource()::getModel()::where('category', 'informasi-serta-merta')->count())
                ->badgeColor('warning'),
            'regulasi' => Tab::make('Regulasi')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('category', 'regulasi'))
                ->badge(fn () => static::getResource()::getModel()::where('category', 'regulasi')->count())
                ->badgeColor('primary'),
        ];
    }
}
