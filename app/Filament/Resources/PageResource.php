<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use App\Models\Page;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?int $navigationSort = 4;

    protected static ?string $modelLabel = 'Halaman';

    protected static ?string $pluralModelLabel = 'Halaman';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Judul Halaman')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (string $operation, $state, callable $set) => $operation === 'create' ? $set('slug', str($state)->slug()) : null)
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('slug')
                            ->label('Slug (URL)')
                            ->helperText('Bagian alamat website untuk halaman ini, terisi otomatis dari judul.')
                            ->required()
                            ->unique(ignoreRecord: true),
                        Forms\Components\Select::make('status')
                            ->label('Status')
                            ->options(['draft' => 'Draf', 'published' => 'Diterbitkan', 'archived' => 'Diarsipkan'])
                            ->default('draft')
                            ->required(),
                        Forms\Components\TextInput::make('template')
                            ->label('Template')
                            ->default('default')
                            ->required(),
                        Forms\Components\DateTimePicker::make('published_at')
                            ->label('Tanggal Publikasi')
                            ->helperText('Pilih waktu di masa depan untuk menjadwalkan publikasi.'),
                        Forms\Components\FileUpload::make('featured_image')
                            ->label('Gambar Utama')
                            ->image()
                            ->maxSize(5120)
                            ->helperText('Maksimal 5MB. Kompres foto dulu kalau ukurannya besar.')
                            ->directory('featured-images')
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('excerpt')
                            ->label('Ringkasan')
                            ->columnSpanFull(),
                        Forms\Components\RichEditor::make('content')
                            ->label('Isi Halaman')
                            ->columnSpanFull(),
                    ]),
                Forms\Components\Section::make('Optimasi Pencarian Google (SEO)')
                    ->description('Opsional. Menentukan judul dan deskripsi yang muncul di hasil pencarian Google.')
                    ->collapsed()
                    ->schema([
                        Forms\Components\TextInput::make('seo_title')
                            ->label('Judul untuk Google')
                            ->helperText('Kosongkan untuk memakai judul halaman.'),
                        Forms\Components\Textarea::make('seo_description')
                            ->label('Deskripsi untuk Google')
                            ->helperText('Ringkasan singkat yang tampil di bawah judul pada hasil pencarian.'),
                    ]),
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
                    ->label('Judul Halaman')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->label('Slug (URL)')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state, Page $record) => $state === 'published' && $record->published_at?->isFuture() ? 'info' : match ($state) {
                        'published' => 'success',
                        'archived' => 'gray',
                        default => 'warning',
                    })
                    ->formatStateUsing(fn (string $state, Page $record): string => match (true) {
                        $state === 'published' && $record->published_at?->isFuture() => 'Terjadwal',
                        $state === 'published' => 'Diterbitkan',
                        $state === 'archived' => 'Diarsipkan',
                        default => 'Draf',
                    }),
                Tables\Columns\TextColumn::make('template')
                    ->label('Template'),
                Tables\Columns\TextColumn::make('published_at')
                    ->label('Tanggal Publikasi')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diubah')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options(['draft' => 'Draf', 'published' => 'Diterbitkan', 'archived' => 'Diarsipkan']),
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
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }
}
