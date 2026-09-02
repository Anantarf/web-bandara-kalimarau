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

    protected static ?string $navigationGroup = 'Layanan & Operasional';

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
                                    ->label('Nomor Penerbangan')
                                    ->placeholder('Contoh: ID 6431'),
                                Forms\Components\TextInput::make('route_from')
                                    ->label('Asal')
                                    ->default(FlightSchedule::KALIMARAU_ROUTE)
                                    ->required()
                                    ->disabled(fn (Forms\Get $get): bool => $get('type') === 'keberangkatan')
                                    ->helperText(fn (Forms\Get $get) => $get('type') === 'keberangkatan' ? 'Terkunci: penerbangan Keberangkatan selalu berasal dari Bandara Kalimarau.' : null)
                                    ->dehydrated(),
                                Forms\Components\TextInput::make('route_to')
                                    ->label('Tujuan')
                                    ->placeholder('Contoh: Balikpapan')
                                    ->required()
                                    ->disabled(fn (Forms\Get $get): bool => $get('type') === 'kedatangan')
                                    ->helperText(fn (Forms\Get $get) => $get('type') === 'kedatangan' ? 'Terkunci: penerbangan Kedatangan selalu menuju Bandara Kalimarau.' : null)
                                    ->dehydrated(),
                                Forms\Components\TimePicker::make('departure_time')
                                    ->label('Jam Berangkat')
                                    ->visible(fn (Forms\Get $get): bool => $get('type') !== 'kedatangan')
                                    ->required(fn (Forms\Get $get): bool => $get('type') === 'keberangkatan')
                                    ->seconds(false),
                                Forms\Components\TimePicker::make('arrival_time')
                                    ->label('Jam Tiba')
                                    ->visible(fn (Forms\Get $get): bool => $get('type') !== 'keberangkatan')
                                    ->required(fn (Forms\Get $get): bool => $get('type') === 'kedatangan')
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
                                    ->default('keberangkatan')
                                    ->required()
                                    ->live()
                                    ->afterStateUpdated(function (string $state, Forms\Set $set) {
                                        if ($state === 'kedatangan') {
                                            $set('route_to', FlightSchedule::KALIMARAU_ROUTE);
                                            $set('departure_time', null);
                                        } elseif ($state === 'keberangkatan') {
                                            $set('route_from', FlightSchedule::KALIMARAU_ROUTE);
                                            $set('arrival_time', null);
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
                    ->rowIndex()
                    ->alignCenter()
                    ->size('sm'),
                Tables\Columns\TextColumn::make('airline')
                    ->label('Maskapai')
                    ->description(fn (FlightSchedule $record): string => $record->flight_number ?: '-')
                    ->searchable(['airline', 'flight_number'])
                    ->weight('medium')
                    ->size('sm')
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->label('Jenis')
                    ->badge()
                    ->alignCenter()
                    ->size('sm')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'keberangkatan' => 'Keberangkatan',
                        'kedatangan' => 'Kedatangan',
                        default => ucfirst($state),
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'keberangkatan' => 'info',
                        'kedatangan' => 'success',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('route')
                    ->label('Rute Penerbangan')
                    ->state(fn (FlightSchedule $record): string => "{$record->route_from} ➔ {$record->route_to}")
                    ->searchable(['route_from', 'route_to'])
                    ->size('sm'),
                Tables\Columns\TextColumn::make('flight_time')
                    ->label('Waktu')
                    ->state(fn (FlightSchedule $record): string => match ($record->type) {
                        'keberangkatan' => $record->departure_time ? substr($record->departure_time, 0, 5).' WITA (Berangkat)' : '-',
                        'kedatangan' => $record->arrival_time ? substr($record->arrival_time, 0, 5).' WITA (Tiba)' : '-',
                        default => '-',
                    })
                    ->alignCenter()
                    ->size('sm'),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Tampil')
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('flight_number')
                    ->label('Nomor Penerbangan')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('route_from')
                    ->label('Kota Asal')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('route_to')
                    ->label('Kota Tujuan')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('departure_time')
                    ->label('Jam Berangkat')
                    ->time()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('arrival_time')
                    ->label('Jam Tiba')
                    ->time()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                Tables\Actions\EditAction::make()->label('Ubah')->iconButton(),
                Tables\Actions\DeleteAction::make()->label('Hapus')->iconButton(),
            ])
            ->emptyStateHeading('Belum Ada Jadwal Penerbangan')
            ->emptyStateDescription('Tambahkan rute keberangkatan atau kedatangan pesawat baru.')
            ->emptyStateIcon('heroicon-o-paper-airplane')
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
