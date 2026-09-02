<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MediaResource\Pages;
use App\Models\Media;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MediaResource extends Resource
{
    protected static ?string $model = Media::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationGroup = 'Halaman & Media';

    protected static ?int $navigationSort = 3;

    protected static ?string $modelLabel = 'Galeri Media & Foto';

    protected static ?string $pluralModelLabel = 'Galeri Media & Foto';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('path')
                    ->label('Berkas')
                    ->disk('public')
                    ->directory('media')
                    ->image()
                    ->required(fn (string $operation): bool => $operation === 'create')
                    ->visible(fn (string $operation): bool => $operation === 'create'),
                Forms\Components\TextInput::make('alt_text')
                    ->label('Teks Alternatif (Alt)')
                    ->helperText('Deskripsi gambar untuk aksesibilitas dan SEO.'),
                Forms\Components\TextInput::make('caption')
                    ->label('Keterangan'),
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
                Tables\Columns\ImageColumn::make('path')
                    ->label('Pratinjau')
                    ->disk('public')
                    ->square()
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('filename')
                    ->label('Nama Berkas')
                    ->searchable()
                    ->weight('medium')
                    ->size('sm'),
                Tables\Columns\TextColumn::make('mime_type')
                    ->label('Tipe')
                    ->badge()
                    ->alignCenter()
                    ->size('sm'),
                Tables\Columns\TextColumn::make('alt_text')
                    ->label('Alt Text')
                    ->size('sm')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('size')
                    ->label('Ukuran')
                    ->formatStateUsing(fn (?int $state): string => $state ? number_format($state / 1024, 1).' KB' : '-')
                    ->alignCenter()
                    ->size('sm'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Diunggah')
                    ->dateTime('d/m/Y H:i')
                    ->alignCenter()
                    ->size('sm')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make()->label('Ubah')->iconButton(),
                Tables\Actions\DeleteAction::make()->label('Hapus')->iconButton(),
            ])
            ->emptyStateHeading('Belum Ada Berkas Media')
            ->emptyStateDescription('Unggah foto atau dokumen baru ke galeri media.')
            ->emptyStateIcon('heroicon-o-photo')
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMedia::route('/'),
            'create' => Pages\CreateMedia::route('/create'),
            'edit' => Pages\EditMedia::route('/{record}/edit'),
        ];
    }
}
