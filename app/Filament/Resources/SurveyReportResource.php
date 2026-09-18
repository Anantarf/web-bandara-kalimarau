<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SurveyReportResource\Pages;
use App\Models\SurveyReport;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SurveyReportResource extends Resource
{
    protected static ?string $model = SurveyReport::class;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar-square';

    protected static ?string $navigationGroup = 'Dokumen Publik';

    protected static ?string $navigationLabel = 'Laporan Survei (SKM)';

    protected static ?int $navigationSort = 2;

    protected static ?string $modelLabel = 'Laporan Survei (SKM)';

    protected static ?string $pluralModelLabel = 'Laporan Survei (SKM)';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Informasi Laporan Survei')
                            ->description('Masukkan judul periode dan keterangan laporan hasil survei kepuasan.')
                            ->icon('heroicon-o-document-chart-bar')
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->label('Judul / Periode Laporan')
                                    ->placeholder('Contoh: Bulan September 2024 atau Triwulan I 2025')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpanFull(),
                                Forms\Components\DatePicker::make('period_date')
                                    ->label('Tanggal / Periode Survei')
                                    ->placeholder('Pilih tanggal periode')
                                    ->default(now()),
                                Forms\Components\Textarea::make('description')
                                    ->label('Deskripsi / Catatan Singkat (Opsional)')
                                    ->rows(3)
                                    ->columnSpanFull(),
                            ])->columns(2),

                        Forms\Components\Section::make('Dokumen & Berkas Laporan')
                            ->description('Pilih untuk mengunggah file PDF langsung atau memasukkan tautan Google Drive / Eksternal.')
                            ->icon('heroicon-o-arrow-up-tray')
                            ->schema([
                                Forms\Components\TextInput::make('external_url')
                                    ->label('Tautan Google Drive / Dokumen Online')
                                    ->placeholder('https://drive.google.com/file/d/...')
                                    ->url()
                                    ->helperText('Jika diisi dengan link Google Drive, ID thumbnail akan dideteksi secara otomatis.')
                                    ->columnSpanFull(),
                                Forms\Components\FileUpload::make('file_path')
                                    ->label('Atau Upload File PDF Lokal')
                                    ->disk('public')
                                    ->directory('survey-reports')
                                    ->acceptedFileTypes(['application/pdf'])
                                    ->maxSize(15360)
                                    ->downloadable()
                                    ->openable()
                                    ->helperText('Opsional jika sudah mengisi tautan online. Maks 15MB.')
                                    ->columnSpanFull(),
                                Forms\Components\FileUpload::make('cover_image')
                                    ->label('Gambar Sampul / Cover Kustom (Opsional)')
                                    ->disk('public')
                                    ->directory('survey-reports/covers')
                                    ->image()
                                    ->imageEditor()
                                    ->maxSize(4096)
                                    ->helperText('Opsional. Jika kosong dan link Google Drive terisi, thumbnail Google Drive akan digunakan.')
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->columnSpan(['sm' => 12, 'md' => 8]),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Pengaturan Tampil')
                            ->icon('heroicon-o-cog-6-tooth')
                            ->schema([
                                Forms\Components\Toggle::make('is_active')
                                    ->label('Tampilkan di Website')
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
                    ->rowIndex()
                    ->alignCenter()
                    ->size('sm'),
                Tables\Columns\ImageColumn::make('thumbnail_url')
                    ->label('Cover')
                    ->circular(false)
                    ->square()
                    ->size(48)
                    ->defaultImageUrl(asset('images/logo-header.png')),
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul Laporan')
                    ->searchable()
                    ->weight('bold')
                    ->size('sm')
                    ->wrap(),
                Tables\Columns\TextColumn::make('period_date')
                    ->label('Periode')
                    ->date('F Y')
                    ->alignCenter()
                    ->size('sm')
                    ->sortable(),
                Tables\Columns\TextColumn::make('source_type')
                    ->label('Sumber')
                    ->badge()
                    ->alignCenter()
                    ->state(fn (SurveyReport $record): string => filled($record->external_url) ? 'Google Drive' : (filled($record->file_path) ? 'File PDF' : 'Tautan'))
                    ->color(fn (string $state): string => match ($state) {
                        'Google Drive' => 'info',
                        'File PDF' => 'success',
                        default => 'gray',
                    }),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Tampil')
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('sort_order')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Tampil di Website'),
            ])
            ->actions([
                Tables\Actions\Action::make('preview')
                    ->label('Lihat Laporan')
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->iconButton()
                    ->url(fn (SurveyReport $record): string => $record->link_url)
                    ->openUrlInNewTab(),
                Tables\Actions\EditAction::make()->label('Ubah')->iconButton(),
                Tables\Actions\DeleteAction::make()->label('Hapus')->iconButton(),
            ])
            ->emptyStateHeading('Belum Ada Laporan Survei')
            ->emptyStateDescription('Tambahkan laporan hasil survei kepuasan masyarakat untuk ditampilkan ke publik.')
            ->emptyStateIcon('heroicon-o-chart-bar-square')
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSurveyReports::route('/'),
            'create' => Pages\CreateSurveyReport::route('/create'),
            'edit' => Pages\EditSurveyReport::route('/{record}/edit'),
        ];
    }
}
