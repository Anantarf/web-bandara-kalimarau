<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PublicServiceLinkResource\Pages;
use App\Models\PublicServiceLink;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PublicServiceLinkResource extends Resource
{
    protected static ?string $model = PublicServiceLink::class;

    protected static ?string $navigationIcon = 'heroicon-o-link';
    protected static ?string $navigationGroup = 'Layanan & Data';

    protected static ?int $navigationSort = 7;

    protected static ?string $modelLabel = 'Layanan Publik';

    protected static ?string $pluralModelLabel = 'Layanan Publik';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Judul')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (string $operation, $state, callable $set) => $operation === 'create' ? $set('slug', str($state)->slug()) : null),
                Forms\Components\TextInput::make('slug')
                    ->label('Slug (URL)')
                    ->required()
                    ->unique(ignoreRecord: true),
                Forms\Components\Textarea::make('description')
                    ->label('Deskripsi')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('url')
                    ->label('URL Tujuan')
                    ->url()
                    ->required(),
                Forms\Components\TextInput::make('category')
                    ->label('Kategori')
                    ->required()
                    ->maxLength(40),
                Forms\Components\TextInput::make('icon')
                    ->label('Ikon')
                    ->helperText('Nama ikon Heroicon, contoh: heroicon-o-link'),
                Forms\Components\TextInput::make('sort_order')
                    ->label('Urutan Tampil')
                    ->numeric()
                    ->default(0)
                    ->required(),
                Forms\Components\Toggle::make('is_external')
                    ->label('Tautan Eksternal')
                    ->default(true),
                Forms\Components\Toggle::make('is_active')
                    ->label('Aktif / Tampilkan')
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
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category')
                    ->label('Kategori')
                    ->badge(),
                Tables\Columns\TextColumn::make('url')
                    ->label('URL')
                    ->limit(40),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->numeric()
                    ->sortable(),
            ])
            ->defaultSort('sort_order')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Tampil di Website'),
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
            'index' => Pages\ListPublicServiceLinks::route('/'),
            'create' => Pages\CreatePublicServiceLink::route('/create'),
            'edit' => Pages\EditPublicServiceLink::route('/{record}/edit'),
        ];
    }
}
