<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $navigationGroup = 'Konten Website';

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $modelLabel = 'Berita';

    protected static ?string $pluralModelLabel = 'Berita';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Konten Utama')
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->label('Judul')
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn (string $operation, $state, callable $set) => $operation === 'create' ? $set('slug', str($state)->slug()) : null)
                                    ->columnSpanFull(),
                                Forms\Components\Textarea::make('excerpt')
                                    ->label('Ringkasan Singkat')
                                    ->columnSpanFull(),
                                Forms\Components\RichEditor::make('content')
                                    ->label('Isi Berita')
                                    ->required()
                                    ->columnSpanFull(),
                            ])->columns(2),
                        Forms\Components\Section::make('Gambar Utama')
                            ->schema([
                                Forms\Components\FileUpload::make('featured_image')
                                    ->hiddenLabel()
                                    ->image()
                                    ->maxSize(5120)
                                    ->helperText('Maksimal 5MB. Kompres foto dulu kalau ukurannya besar.')
                                    ->directory('featured-images')
                                    ->columnSpanFull(),
                            ]),
                        Forms\Components\Section::make('Pengaturan Lanjutan & SEO')
                            ->description('Opsional. Pengaturan URL dan tampilan di Google.')
                            ->collapsed()
                            ->schema([
                                Forms\Components\TextInput::make('slug')
                                    ->label('Slug (URL)')
                                    ->helperText('Bagian alamat website untuk berita ini. Dihasilkan otomatis, jangan diubah kecuali perlu.')
                                    ->required()
                                    ->unique(ignoreRecord: true),
                                Forms\Components\TextInput::make('seo_title')
                                    ->label('Judul untuk Google')
                                    ->helperText('Kosongkan untuk memakai judul berita.'),
                                Forms\Components\Textarea::make('seo_description')
                                    ->label('Deskripsi untuk Google')
                                    ->helperText('Ringkasan singkat yang tampil di bawah judul pada hasil pencarian.'),
                            ]),
                    ])
                    ->columnSpan(['sm' => 12, 'md' => 8]),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Status & Publikasi')
                            ->schema([
                                Forms\Components\Select::make('status')
                                    ->label('Status')
                                    ->options(['draft' => 'Draf', 'published' => 'Diterbitkan', 'archived' => 'Diarsipkan'])
                                    ->default('draft')
                                    ->required(),
                                Forms\Components\DateTimePicker::make('published_at')
                                    ->label('Tanggal Publikasi')
                                    ->helperText('Pilih waktu di masa depan untuk menjadwalkan publikasi.'),
                            ]),
                        Forms\Components\Section::make('Meta & Hubungan')
                            ->schema([
                                Forms\Components\Select::make('category_id')
                                    ->label('Kategori')
                                    ->relationship('category', 'name')
                                    ->searchable(),
                                Forms\Components\Select::make('author_id')
                                    ->label('Penulis')
                                    ->relationship('author', 'name')
                                    ->searchable()
                                    ->default(fn () => auth()->id()),
                            ]),
                        Forms\Components\Section::make('Atribut Tambahan')
                            ->schema([
                                Forms\Components\Toggle::make('is_featured')
                                    ->label('Berita Unggulan'),
                                Forms\Components\Toggle::make('is_pinned')
                                    ->label('Disematkan'),
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
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Kategori')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('author.name')
                    ->label('Penulis')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state, Post $record) => $state === 'published' && $record->published_at?->isFuture() ? 'info' : match ($state) {
                        'published' => 'success',
                        'archived' => 'gray',
                        default => 'warning',
                    })
                    ->formatStateUsing(fn (string $state, Post $record): string => match (true) {
                        $state === 'published' && $record->published_at?->isFuture() => 'Terjadwal',
                        $state === 'published' => 'Diterbitkan',
                        $state === 'archived' => 'Diarsipkan',
                        default => 'Draf',
                    })
                    ->toggleable(),
                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Unggulan')
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('is_pinned')
                    ->label('Disematkan')
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('published_at')
                    ->label('Tanggal Publikasi')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(),
            ])
            ->defaultSort('published_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options(['draft' => 'Draf', 'published' => 'Diterbitkan', 'archived' => 'Diarsipkan']),
                Tables\Filters\SelectFilter::make('category_id')
                    ->label('Kategori')
                    ->relationship('category', 'name'),
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
