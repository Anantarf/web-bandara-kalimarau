<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FacilityResource\Pages;
use App\Models\Facility;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class FacilityResource extends Resource
{
    protected static ?string $model = Facility::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Layanan Operasional';

    protected static ?int $navigationSort = 2;

    protected static ?string $modelLabel = 'Fasilitas Bandara';

    protected static ?string $pluralModelLabel = 'Fasilitas Bandara';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Fasilitas Bandara')
                    ->description('Kelola data fasilitas bandara yang akan ditampilkan pada halaman web publik.')
                    ->icon('heroicon-o-building-office')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('category')
                            ->label('Kategori Fasilitas')
                            ->options(Facility::CATEGORIES)
                            ->placeholder('Pilih Kategori Fasilitas')
                            ->required()
                            ->native(false),
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Fasilitas')
                            ->placeholder('Contoh: Terminal Penumpang Utama')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\FileUpload::make('image')
                            ->label('Foto / Gambar Fasilitas')
                            ->image()
                            ->imageEditor()
                            ->disk('public')
                            ->directory('facilities')
                            ->maxSize(5120)
                            ->columnSpanFull()
                            ->helperText('Format foto JPG/PNG, maksimal 5MB. Gunakan gambar berkualitas baik.'),
                        Forms\Components\Textarea::make('details')
                            ->label('Detail & Spesifikasi (satu poin per baris)')
                            ->placeholder("Luas area: 12.000 m²\nKapasitas: 1,5 juta penumpang/tahun\nDilengkapi AC & Ruang Menyusui")
                            ->rows(4)
                            ->columnSpanFull()
                            ->dehydrateStateUsing(fn (?string $state) => collect(explode("\n", (string) $state))->map(fn ($line) => trim($line))->filter()->values()->all())
                            ->afterStateHydrated(fn (Forms\Components\Textarea $component, $state) => $component->state(is_array($state) ? implode("\n", $state) : $state)),
                        Forms\Components\TextInput::make('order')
                            ->label('Urutan Tampil')
                            ->helperText('Angka lebih kecil akan ditampilkan lebih awal di daftar.')
                            ->required()
                            ->numeric()
                            ->default(0),
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
                    ->rowIndex()
                    ->alignCenter()
                    ->size('sm'),
                Tables\Columns\ImageColumn::make('image')
                    ->label('Foto')
                    ->disk('public')
                    ->circular()
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Fasilitas')
                    ->description(fn (Facility $record): string => "Kategori: {$record->category_label}")
                    ->searchable(['name', 'category'])
                    ->weight('medium')
                    ->size('sm')
                    ->sortable(),
                Tables\Columns\TextColumn::make('category')
                    ->label('Kategori')
                    ->formatStateUsing(fn (Facility $record): string => $record->category_label)
                    ->badge()
                    ->alignCenter()
                    ->size('sm')
                    ->searchable(),
                Tables\Columns\TextColumn::make('order')
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
            ->defaultSort('order')
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make()->label('Ubah')->iconButton(),
                Tables\Actions\DeleteAction::make()->label('Hapus')->iconButton(),
            ])
            ->emptyStateHeading('Belum Ada Fasilitas')
            ->emptyStateDescription('Tambahkan data fasilitas bandara untuk ditampilkan di website.')
            ->emptyStateIcon('heroicon-o-building-office')
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFacilities::route('/'),
            'create' => Pages\CreateFacility::route('/create'),
            'edit' => Pages\EditFacility::route('/{record}/edit'),
        ];
    }
}
