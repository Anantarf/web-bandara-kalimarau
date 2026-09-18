<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AwardResource\Pages;
use App\Models\Award;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AwardResource extends Resource
{
    protected static ?string $model = Award::class;

    protected static ?string $navigationIcon = 'heroicon-o-trophy';

    protected static ?string $navigationGroup = 'Publikasi & Konten Web';

    protected static ?string $navigationLabel = 'Penghargaan & Prestasi';

    protected static ?int $navigationSort = 5;

    protected static ?string $modelLabel = 'Penghargaan & Prestasi';

    protected static ?string $pluralModelLabel = 'Penghargaan & Prestasi';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Informasi Utama Penghargaan')
                            ->description('Masukkan judul, penyelenggara, dan keterangan penghargaan.')
                            ->icon('heroicon-o-trophy')
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->label('Judul Penghargaan')
                                    ->placeholder('Contoh: Bandara Pelayanan Terbaik 2022')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpanFull(),
                                Forms\Components\TextInput::make('issuer')
                                    ->label('Penyelenggara / Instansi')
                                    ->placeholder('Contoh: Kementerian Perhubungan RI')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('year')
                                    ->label('Tahun Perolehan')
                                    ->placeholder('2022')
                                    ->numeric()
                                    ->minValue(1900)
                                    ->maxValue(2100),
                                Forms\Components\Textarea::make('description')
                                    ->label('Deskripsi / Catatan Singkat')
                                    ->placeholder('Keterangan singkat mengenai penghargaan ini...')
                                    ->rows(3)
                                    ->columnSpanFull(),
                            ])->columns(2),

                        Forms\Components\Section::make('Foto / Sertifikat Penghargaan')
                            ->description('Unggah gambar sertifikat atau dokumentasi penyerahan penghargaan.')
                            ->icon('heroicon-o-photo')
                            ->schema([
                                Forms\Components\FileUpload::make('image')
                                    ->label('Berkas Gambar')
                                    ->image()
                                    ->imageEditor()
                                    ->disk('public')
                                    ->directory('awards')
                                    ->maxSize(5120)
                                    ->required(fn (string $operation): bool => $operation === 'create')
                                    ->helperText('Format foto JPG/PNG, maksimal 5MB. Utamakan gambar berkualitas baik.')
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->columnSpan(['sm' => 12, 'md' => 8]),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Pengaturan Publikasi')
                            ->icon('heroicon-o-cog-6-tooth')
                            ->schema([
                                Forms\Components\Toggle::make('is_active')
                                    ->label('Tampilkan di Website')
                                    ->helperText('Aktifkan agar tampil di carousel halaman Profil Bandara.')
                                    ->default(true)
                                    ->required(),
                                Forms\Components\TextInput::make('sort_order')
                                    ->label('Urutan Tampil')
                                    ->helperText('Angka lebih kecil ditampilkan lebih awal (0, 1, 2...).')
                                    ->required()
                                    ->numeric()
                                    ->default(0),
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
                    ->rowIndex()
                    ->alignCenter()
                    ->size('sm'),
                Tables\Columns\ImageColumn::make('image')
                    ->label('Foto')
                    ->disk('public')
                    ->square()
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul Penghargaan')
                    ->description(fn (Award $record): ?string => $record->issuer ? "Penyelenggara: {$record->issuer}" : null)
                    ->searchable(['title', 'issuer'])
                    ->weight('medium')
                    ->size('sm')
                    ->sortable()
                    ->wrap(),
                Tables\Columns\TextColumn::make('year')
                    ->label('Tahun')
                    ->badge()
                    ->color('info')
                    ->alignCenter()
                    ->size('sm')
                    ->sortable(),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Tampil')
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->numeric()
                    ->sortable()
                    ->alignCenter()
                    ->size('sm')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('sort_order')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Tampilkan di Website'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Ubah')->iconButton(),
                Tables\Actions\DeleteAction::make()->label('Hapus')->iconButton(),
            ])
            ->emptyStateHeading('Belum Ada Data Penghargaan')
            ->emptyStateDescription('Tambahkan data penghargaan dan prestasi baru untuk ditampilkan di portal publik.')
            ->emptyStateIcon('heroicon-o-trophy')
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAwards::route('/'),
            'create' => Pages\CreateAward::route('/create'),
            'edit' => Pages\EditAward::route('/{record}/edit'),
        ];
    }
}
