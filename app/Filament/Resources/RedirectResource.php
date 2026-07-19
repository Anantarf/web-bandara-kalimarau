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

    protected static ?int $navigationSort = 9;

    protected static ?string $modelLabel = 'Redirect';

    protected static ?string $pluralModelLabel = 'Redirect';

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
                    ->rowIndex(),
                Tables\Columns\TextColumn::make('old_path')
                    ->label('Path Lama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('new_path')
                    ->label('Tujuan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status_code')
                    ->label('Kode')
                    ->badge(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageRedirects::route('/'),
        ];
    }
}
