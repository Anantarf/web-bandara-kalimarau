<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListPosts extends ListRecords
{
    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Tambah Berita'),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Semua Berita')
                ->badge(fn () => static::getResource()::getModel()::count()),
            'published' => Tab::make('Diterbitkan')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'published')->where(fn ($q) => $q->whereNull('published_at')->orWhere('published_at', '<=', now())))
                ->badge(fn () => static::getResource()::getModel()::where('status', 'published')->where(fn ($q) => $q->whereNull('published_at')->orWhere('published_at', '<=', now()))->count())
                ->badgeColor('success'),
            'scheduled' => Tab::make('Terjadwal')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'published')->where('published_at', '>', now()))
                ->badge(fn () => static::getResource()::getModel()::where('status', 'published')->where('published_at', '>', now())->count())
                ->badgeColor('info'),
            'draft' => Tab::make('Draf')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'draft'))
                ->badge(fn () => static::getResource()::getModel()::where('status', 'draft')->count())
                ->badgeColor('warning'),
            'archived' => Tab::make('Diarsipkan')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'archived'))
                ->badgeColor('gray'),
        ];
    }
}
