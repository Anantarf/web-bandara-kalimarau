<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FlightScheduleResource\Pages;
use App\Models\FlightSchedule;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class FlightScheduleResource extends Resource
{
    protected static ?string $model = FlightSchedule::class;

    protected static ?string $navigationIcon = 'heroicon-o-paper-airplane';
    protected static ?string $navigationGroup = 'Layanan & Data';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'flight_number';

    protected static ?string $modelLabel = 'Jadwal Penerbangan';

    protected static ?string $pluralModelLabel = 'Jadwal Penerbangan';

    public const DAYS = [
        'senin' => 'Senin',
        'selasa' => 'Selasa',
        'rabu' => 'Rabu',
        'kamis' => 'Kamis',
        'jumat' => 'Jumat',
        'sabtu' => 'Sabtu',
        'minggu' => 'Minggu',
    ];

    public const AIRLINES = [
        'Batik Air' => 'Batik Air',
        'Super Air Jet' => 'Super Air Jet',
        'AirAsia' => 'AirAsia',
        'Sriwijaya Air' => 'Sriwijaya Air',
        'Citilink' => 'Citilink',
        'Wings Air' => 'Wings Air',
        'Smart Aviation' => 'Smart Aviation',
    ];

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Informasi Penerbangan')
                            ->schema([
                                Forms\Components\Select::make('airline')
                                    ->label('Maskapai')
                                    ->options(self::AIRLINES)
                                    ->searchable()
                                    ->required(),
                                Forms\Components\TextInput::make('flight_number')
                                    ->label('Nomor Penerbangan'),
                                Forms\Components\TextInput::make('route_from')
                                    ->label('Asal')
                                    ->required()
                                    ->disabled(fn (Forms\Get $get): bool => $get('type') === 'keberangkatan')
                                    ->dehydrated(),
                                Forms\Components\TextInput::make('route_to')
                                    ->label('Tujuan')
                                    ->required()
                                    ->disabled(fn (Forms\Get $get): bool => $get('type') === 'kedatangan')
                                    ->dehydrated(),
                                Forms\Components\TimePicker::make('departure_time')
                                    ->label('Jam Berangkat')
                                    ->seconds(false),
                                Forms\Components\TimePicker::make('arrival_time')
                                    ->label('Jam Tiba')
                                    ->seconds(false),
                            ])->columns(2),

                        Forms\Components\Section::make('Hari Operasi & Catatan')
                            ->schema([
                                Forms\Components\CheckboxList::make('days')
                                    ->label('Hari Operasi')
                                    ->options(self::DAYS)
                                    ->columns(4)
                                    ->columnSpanFull(),
                                Forms\Components\Textarea::make('notes')
                                    ->label('Catatan Tambahan')
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->columnSpan(['sm' => 12, 'md' => 8]),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Pengaturan')
                            ->schema([
                                Forms\Components\Select::make('type')
                                    ->label('Jenis')
                                    ->options(['keberangkatan' => 'Keberangkatan', 'kedatangan' => 'Kedatangan'])
                                    ->required()
                                    ->live()
                                    ->afterStateUpdated(function (string $state, Forms\Set $set) {
                                        if ($state === 'kedatangan') {
                                            $set('route_to', 'Bandara Kalimarau - Berau');
                                        } elseif ($state === 'keberangkatan') {
                                            $set('route_from', 'Bandara Kalimarau - Berau');
                                        }
                                    }),
                                Forms\Components\Toggle::make('is_active')
                                    ->label('Aktif / Tampilkan')
                                    ->helperText('Nonaktifkan untuk menyembunyikan jadwal ini tanpa menghapusnya.')
                                    ->default(true)
                                    ->required(),
                                Forms\Components\TextInput::make('sort_order')
                                    ->label('Urutan Tampil')
                                    ->helperText('Angka lebih kecil tampil lebih dulu di daftar.')
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
                    ->rowIndex(),
                Tables\Columns\TextColumn::make('type')
                    ->label('Jenis')
                    ->badge(),
                Tables\Columns\TextColumn::make('airline')
                    ->label('Maskapai')
                    ->searchable(),
                Tables\Columns\TextColumn::make('flight_number')
                    ->label('Nomor Penerbangan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('route_from')
                    ->label('Asal')
                    ->searchable(),
                Tables\Columns\TextColumn::make('route_to')
                    ->label('Tujuan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('departure_time')
                    ->label('Jam Berangkat')
                    ->time(),
                Tables\Columns\TextColumn::make('arrival_time')
                    ->label('Jam Tiba')
                    ->time(),
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
                Tables\Filters\SelectFilter::make('type')
                    ->label('Jenis')
                    ->options(['keberangkatan' => 'Keberangkatan', 'kedatangan' => 'Kedatangan']),
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
            'index' => Pages\ListFlightSchedules::route('/'),
            'create' => Pages\CreateFlightSchedule::route('/create'),
            'edit' => Pages\EditFlightSchedule::route('/{record}/edit'),
        ];
    }
}
