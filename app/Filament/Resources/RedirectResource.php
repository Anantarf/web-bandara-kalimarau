<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RedirectResource\Pages;
use App\Models\Redirect;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class RedirectResource extends Resource
{
    protected static ?string $model = Redirect::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-top-right-on-square';

    protected static ?string $navigationGroup = 'Pengaturan Sistem';

    protected static bool $shouldRegisterNavigation = false;

    protected static ?int $navigationSort = 2;

    protected static ?string $modelLabel = 'Pengalihan URL (Redirect)';

    protected static ?string $pluralModelLabel = 'Pengalihan URL (Redirect)';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('old_path')
                    ->label('Path Lama')
                    ->helperText('Contoh: /berita-lama/judul-artikel')
                    ->required()
                    ->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('new_path')
                    ->label('Path/URL Tujuan')
                    ->required(),
                Forms\Components\Select::make('status_code')
                    ->label('Kode Status')
                    ->options([301 => '301 - Permanen', 302 => '302 - Sementara'])
                    ->default(301)
                    ->required(),
                Forms\Components\Toggle::make('is_active')
                    ->label('Aktif')
                    ->default(true)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->striped()
            ->columns([
                Tables\Columns\TextColumn::make('no')
                    ->label('No.')
                    ->rowIndex()
                    ->alignCenter()
                    ->size('sm'),
                Tables\Columns\TextColumn::make('old_path')
                    ->label('Path URL Lama')
                    ->searchable()
                    ->weight('medium')
                    ->size('sm'),
                Tables\Columns\TextColumn::make('new_path')
                    ->label('Tujuan Redirect')
                    ->searchable()
                    ->size('sm'),
                Tables\Columns\TextColumn::make('status_code')
                    ->label('Kode Status')
                    ->badge()
                    ->alignCenter()
                    ->size('sm'),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Aktif')
                    ->alignCenter(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status Aktif'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Ubah')->iconButton(),
                Tables\Actions\DeleteAction::make()->label('Hapus')->iconButton(),
            ])
            ->emptyStateHeading('Belum Ada Aturan Pengalihan (Redirect)')
            ->emptyStateDescription('Tambahkan aturan pengalihan URL lama ke URL baru.')
            ->emptyStateIcon('heroicon-o-arrow-right-start-on-rectangle')
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageRedirects::route('/'),
        ];
    }
}
