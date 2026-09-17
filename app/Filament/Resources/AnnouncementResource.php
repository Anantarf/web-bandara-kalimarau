<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AnnouncementResource\Pages;
use App\Models\Announcement;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AnnouncementResource extends Resource
{
    protected static ?string $model = Announcement::class;

    protected static ?string $navigationIcon = 'heroicon-o-megaphone';

    protected static ?string $navigationGroup = 'Layanan Operasional';

    protected static ?int $navigationSort = 5;

    protected static ?string $modelLabel = 'Pengumuman / Alert';

    protected static ?string $pluralModelLabel = 'Pengumuman & Alert';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Konten Pengumuman / Alert')
                            ->description('Tentukan isi pengumuman atau peringatan penting yang akan tampil di halaman publik.')
                            ->icon('heroicon-o-bell-alert')
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->label('Judul / Subjek Pengumuman')
                                    ->placeholder('Contoh: Informasi Penyesuaian Jadwal Penerbangan')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpanFull(),

                                Forms\Components\Textarea::make('message')
                                    ->label('Pesan Pengumuman')
                                    ->placeholder('Tuliskan rincian pesan atau instruksi untuk penumpang/pengunjung...')
                                    ->required()
                                    ->rows(4)
                                    ->columnSpanFull(),

                                Forms\Components\Select::make('type')
                                    ->label('Tipe / Tingkat Urgensi')
                                    ->options(Announcement::TYPES)
                                    ->default('info')
                                    ->required()
                                    ->native(false)
                                    ->helperText('Warna banner menyesuaikan tipe: Info (Navy/Emas), Peringatan (Kuning/Oranye), Darurat (Merah).'),
                            ]),

                        Forms\Components\Section::make('Tombol Aksi (Opsional)')
                            ->description('Tambahkan tombol tautan jika pengunjung perlu diarahkan ke halaman tertentu.')
                            ->icon('heroicon-o-arrow-top-right-on-square')
                            ->schema([
                                Forms\Components\TextInput::make('action_label')
                                    ->label('Label Tombol')
                                    ->placeholder('Contoh: Lihat Selengkapnya / Hubungi Petugas')
                                    ->maxLength(100),

                                Forms\Components\TextInput::make('action_url')
                                    ->label('URL Tautan')
                                    ->placeholder('https://... atau /layanan')
                                    ->url()
                                    ->maxLength(255),
                            ])->columns(2),
                    ])
                    ->columnSpan(['lg' => 2]),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Status & Penjadwalan')
                            ->description('Atur periode tayang dan visibilitas pengumuman.')
                            ->icon('heroicon-o-clock')
                            ->schema([
                                Forms\Components\Toggle::make('is_active')
                                    ->label('Status Aktif')
                                    ->helperText('Aktifkan agar pengumuman dapat ditayangkan di web publik.')
                                    ->default(true),

                                Forms\Components\Toggle::make('is_popup')
                                    ->label('Mode Modal / Pop-up')
                                    ->helperText('Jika diaktifkan, pengumuman juga akan muncul sebagai dialog pop-up saat pengunjung membuka web.')
                                    ->default(false),

                                Forms\Components\DateTimePicker::make('starts_at')
                                    ->label('Mulai Ditayangkan')
                                    ->placeholder('Langsung tayang jika kosong')
                                    ->seconds(false),

                                Forms\Components\DateTimePicker::make('ends_at')
                                    ->label('Berakhir Pada')
                                    ->placeholder('Tayang terus jika kosong')
                                    ->seconds(false)
                                    ->after('starts_at'),

                                Forms\Components\TextInput::make('sort_order')
                                    ->label('Urutan Prioritas')
                                    ->numeric()
                                    ->default(0)
                                    ->helperText('Angka lebih kecil tampil lebih awal.'),
                            ]),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(fn (Announcement $record): string => \Illuminate\Support\Str::limit($record->message, 60)),

                Tables\Columns\BadgeColumn::make('type')
                    ->label('Tipe')
                    ->colors([
                        'primary' => 'info',
                        'warning' => 'warning',
                        'danger' => 'danger',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'info' => 'Informasi',
                        'warning' => 'Peringatan',
                        'danger' => 'Darurat',
                        default => $state,
                    }),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_popup')
                    ->label('Pop-up')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\TextColumn::make('starts_at')
                    ->label('Mulai')
                    ->dateTime('d M Y H:i')
                    ->placeholder('Sekarang')
                    ->sortable(),

                Tables\Columns\TextColumn::make('ends_at')
                    ->label('Berakhir')
                    ->dateTime('d M Y H:i')
                    ->placeholder('Tanpa batas')
                    ->sortable(),

                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->sortable(),
            ])
            ->defaultSort('sort_order', 'asc')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status Aktif'),
                Tables\Filters\SelectFilter::make('type')
                    ->label('Tipe')
                    ->options(Announcement::TYPES),
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

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAnnouncements::route('/'),
            'create' => Pages\CreateAnnouncement::route('/create'),
            'edit' => Pages\EditAnnouncement::route('/{record}/edit'),
        ];
    }
}
