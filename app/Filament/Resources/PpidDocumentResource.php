<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PpidDocumentResource\Pages;
use App\Models\PpidDocument;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PpidDocumentResource extends Resource
{
    protected static ?string $model = PpidDocument::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = null;

    protected static ?int $navigationSort = 5;

    protected static ?string $modelLabel = 'Layanan Informasi PPID';

    protected static ?string $pluralModelLabel = 'Layanan Informasi PPID';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Informasi Dokumen')
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->label('Judul Dokumen')
                                    ->placeholder('Contoh: Laporan Kinerja Bandara Kalimarau 2026')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpanFull(),
                                Forms\Components\Select::make('category')
                                    ->label('Kategori Informasi')
                                    ->options(PpidDocument::CATEGORIES)
                                    ->searchable()
                                    ->required(),
                                Forms\Components\DateTimePicker::make('published_at')
                                    ->label('Tanggal Publikasi')
                                    ->default(now())
                                    ->helperText('Dokumen tampil jika status aktif dan tanggal publikasi tidak di masa depan.'),
                                Forms\Components\Textarea::make('description')
                                    ->label('Deskripsi Singkat')
                                    ->rows(4)
                                    ->columnSpanFull(),
                            ])->columns(2),
                        Forms\Components\Section::make('File Dokumen')
                            ->schema([
                                Forms\Components\FileUpload::make('file_path')
                                    ->label('Upload File')
                                    ->disk('public')
                                    ->directory('ppid-documents')
                                    ->acceptedFileTypes([
                                        'application/pdf',
                                        'application/msword',
                                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                                        'application/vnd.ms-excel',
                                        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                                    ])
                                    ->maxSize(10240)
                                    ->downloadable()
                                    ->openable()
                                    ->required()
                                    ->helperText('Maksimal 10MB. Utamakan PDF untuk dokumen publik.')
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->columnSpan(['sm' => 12, 'md' => 8]),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Pengaturan')
                            ->schema([
                                Forms\Components\Toggle::make('is_active')
                                    ->label('Aktif / Tampilkan')
                                    ->default(true)
                                    ->required(),
                                Forms\Components\TextInput::make('sort_order')
                                    ->label('Urutan Tampil')
                                    ->helperText('Angka lebih kecil tampil lebih dulu.')
                                    ->numeric()
                                    ->default(0)
                                    ->required(),
                            ]),
                    ])
                    ->columnSpan(['sm' => 12, 'md' => 4]),
            ])
            ->columns(12);
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
                    ->searchable()
                    ->wrap()
                    ->lineClamp(2),
                Tables\Columns\TextColumn::make('category')
                    ->label('Kategori')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => PpidDocument::CATEGORIES[$state] ?? str($state)->replace('-', ' ')->title()->toString())
                    ->searchable(),
                Tables\Columns\TextColumn::make('published_at')
                    ->label('Tanggal Publikasi')
                    ->dateTime('d M Y')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Tampil')
                    ->boolean(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->numeric()
                    ->sortable(),
            ])
            ->defaultSort('sort_order')
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->label('Kategori')
                    ->options(PpidDocument::CATEGORIES),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Tampil di Website'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Ubah'),
                Tables\Actions\DeleteAction::make()->label('Hapus'),
            ])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPpidDocuments::route('/'),
            'create' => Pages\CreatePpidDocument::route('/create'),
            'edit' => Pages\EditPpidDocument::route('/{record}/edit'),
        ];
    }
}
