<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AirlineResource\Pages;
use App\Models\Airline;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AirlineResource extends Resource
{
    protected static ?string $model = Airline::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';

    protected static ?string $navigationGroup = 'Operasional Bandara';

    protected static ?string $navigationLabel = 'Maskapai & Mitra';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $modelLabel = 'Maskapai';

    protected static ?string $pluralModelLabel = 'Maskapai & Mitra';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Informasi Maskapai')
                            ->description('Kelola profil maskapai penerbangan mitra Bandara Kalimarau.')
                            ->icon('heroicon-o-paper-airplane')
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Nama Maskapai')
                                    ->placeholder('Contoh: Batik Air, Citilink')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn (string $operation, $state, callable $set) => $operation === 'create' ? $set('slug', str($state)->slug()) : null),

                                Forms\Components\TextInput::make('slug')
                                    ->label('Slug')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(ignoreRecord: true),

                                Forms\Components\TextInput::make('routes')
                                    ->label('Rute Utama')
                                    ->placeholder('Contoh: Jakarta (CGK), Surabaya (SUB)')
                                    ->helperText('Daftar kota rute yang ditampilkan pada banner/marquee mitra di beranda.')
                                    ->maxLength(255)
                                    ->columnSpanFull(),

                                Forms\Components\FileUpload::make('logo')
                                    ->label('Logo Maskapai')
                                    ->disk('public')
                                    ->directory('airlines')
                                    ->image()
                                    ->maxSize(2048)
                                    ->helperText('Format yang didukung: PNG, SVG, WEBP, atau JPG (disarankan berlatar belakang transparan).')
                                    ->columnSpanFull(),
                            ])->columns(2),
                    ])
                    ->columnSpan(['sm' => 12, 'md' => 8]),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Pengaturan Tampilan')
                            ->icon('heroicon-o-adjustments-horizontal')
                            ->schema([
                                Forms\Components\Toggle::make('is_active')
                                    ->label('Aktif / Tampilkan')
                                    ->helperText('Aktifkan untuk menampilkan maskapai pada running marquee dan daftar opsi jadwal.')
                                    ->default(true)
                                    ->required(),

                                Forms\Components\TextInput::make('sort_order')
                                    ->label('Urutan Tampil')
                                    ->helperText('Angka lebih kecil tampil lebih dulu.')
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

                Tables\Columns\ImageColumn::make('logo')
                    ->label('Logo')
                    ->state(fn (Airline $record): ?string => $record->logo_url)
                    ->width(105)
                    ->height(36)
                    ->extraImgAttributes([
                        'style' => 'object-fit: contain !important; max-width: 105px !important; max-height: 36px !important;',
                        'class' => '!object-contain max-h-9 max-w-[105px] p-1 bg-white dark:bg-gray-800 rounded-md border border-gray-200 dark:border-gray-700 shadow-2xs',
                    ])
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Maskapai')
                    ->description(fn (Airline $record): string => $record->slug)
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->size('sm'),

                Tables\Columns\TextColumn::make('routes')
                    ->label('Rute Utama')
                    ->placeholder('-')
                    ->color('gray')
                    ->size('sm')
                    ->wrap()
                    ->searchable(),

                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Aktif')
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->sortable()
                    ->alignCenter()
                    ->size('sm'),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('sort_order')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status Aktif')
                    ->trueLabel('Hanya Aktif')
                    ->falseLabel('Hanya Nonaktif'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAirlines::route('/'),
            'create' => Pages\CreateAirline::route('/create'),
            'edit' => Pages\EditAirline::route('/{record}/edit'),
        ];
    }
}
