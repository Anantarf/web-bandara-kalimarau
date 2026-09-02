<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AirportStatResource\Pages;
use App\Models\AirportStat;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class AirportStatResource extends Resource
{
    protected static ?string $model = AirportStat::class;

    protected static ?string $modelLabel = 'Statistik Bandara';

    protected static ?string $pluralModelLabel = 'Statistik Bandara';

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

    protected static ?string $navigationGroup = 'Halaman & Media';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Data Statistik Periode')
                    ->description('Angka yang Anda masukkan di bawah akan langsung tampil beranimasi di halaman utama/beranda.')
                    ->schema([
                        TextInput::make('period_name')
                            ->label('Nama Periode')
                            ->placeholder('Contoh: Juli 2026')
                            ->helperText('Teks ini akan muncul sebagai keterangan bulan di atas deretan angka.')
                            ->required()
                            ->maxLength(255),
                        DatePicker::make('period_date')
                            ->label('Tanggal Acuan Periode')
                            ->helperText('Sistem mengurutkan data terbaru berdasarkan tanggal ini. Pilih tanggal berapapun di bulan tersebut.')
                            ->required(),

                        Grid::make(3)
                            ->schema([
                                TextInput::make('passenger_count')
                                    ->label('Total Penumpang')
                                    ->helperText('Hanya angka tanpa titik. Cth: 51200')
                                    ->required()
                                    ->numeric()
                                    ->default(0),
                                TextInput::make('flight_count')
                                    ->label('Pergerakan Pesawat')
                                    ->helperText('Hanya angka tanpa titik. Cth: 345')
                                    ->required()
                                    ->numeric()
                                    ->default(0),
                                TextInput::make('cargo_count')
                                    ->label('Total Kargo (Kg)')
                                    ->helperText('Hanya angka tanpa titik. Cth: 85500')
                                    ->required()
                                    ->numeric()
                                    ->default(0),
                            ]),

                        Toggle::make('is_active')
                            ->label('Tampilkan di Beranda')
                            ->helperText('Nyalakan (hijau) agar data statistik bulan ini yang muncul di halaman depan *website*.')
                            ->default(true)
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->striped()
            ->columns([
                TextColumn::make('no')
                    ->label('No.')
                    ->rowIndex()
                    ->alignCenter()
                    ->size('sm'),
                TextColumn::make('period_name')
                    ->label('Periode Bulan')
                    ->searchable()
                    ->weight('medium')
                    ->size('sm'),
                TextColumn::make('period_date')
                    ->label('Tanggal Acuan')
                    ->date('d/m/Y')
                    ->alignCenter()
                    ->size('sm')
                    ->sortable(),
                TextColumn::make('passenger_count')
                    ->label('Penumpang')
                    ->numeric(locale: 'id')
                    ->alignCenter()
                    ->size('sm')
                    ->sortable(),
                TextColumn::make('flight_count')
                    ->label('Pesawat')
                    ->numeric(locale: 'id')
                    ->alignCenter()
                    ->size('sm')
                    ->sortable(),
                TextColumn::make('cargo_count')
                    ->label('Kargo (Kg)')
                    ->numeric(locale: 'id')
                    ->alignCenter()
                    ->size('sm')
                    ->sortable(),
                ToggleColumn::make('is_active')
                    ->label('Tampil')
                    ->alignCenter(),
                TextColumn::make('updated_at')
                    ->label('Terakhir Diubah')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->actions([
                EditAction::make()->label('Edit Data')->iconButton(),
                DeleteAction::make()->label('Hapus')->iconButton(),
            ])
            ->emptyStateHeading('Belum Ada Data Statistik')
            ->emptyStateDescription('Tambahkan angka pergerakan penumpang, pesawat, dan kargo bulanan.')
            ->emptyStateIcon('heroicon-o-chart-bar')
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageAirportStats::route('/'),
        ];
    }
}
