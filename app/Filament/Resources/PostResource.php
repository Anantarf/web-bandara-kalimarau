<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Models\Category;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use FilamentTiptapEditor\TiptapEditor;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $navigationGroup = 'Berita & Publikasi';

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $modelLabel = 'Berita';

    protected static ?string $pluralModelLabel = 'Berita';

    protected static ?int $navigationSort = 1;

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
                                    ->placeholder('Contoh: Bandara Kalimarau Layani Penerbangan Tambahan')
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn (string $operation, $state, callable $set) => $operation === 'create' ? $set('slug', str($state)->slug()) : null)
                                    ->columnSpanFull(),
                                Forms\Components\Textarea::make('excerpt')
                                    ->label('Ringkasan Singkat')
                                    ->helperText('Opsional. Jika dikosongkan, sistem akan mengambil ringkasan dari isi berita.')
                                    ->columnSpanFull(),
                                TiptapEditor::make('content')
                                    ->label('Isi Berita')
                                    ->required()
                                    ->columnSpanFull()
                                    ->tools([
                                        'heading', '|',
                                        'bold', 'italic', 'underline', 'strike', '|',
                                        'link', 'media', '|',
                                        'bullet-list', 'ordered-list', '|',
                                        'blockquote',
                                    ])
                                    ->bubbleMenuTools(['bold', 'italic', 'underline', 'link']),
                            ])->columns(2),
                        Forms\Components\Section::make('Gambar Utama')
                            ->schema([
                                Forms\Components\FileUpload::make('featured_image')
                                    ->hiddenLabel()
                                    ->image()
                                    ->imageEditor()
                                    ->imageCropAspectRatio('16:9')
                                    ->disk('public')
                                    ->maxSize(5120)
                                    ->helperText('Maksimal 5MB. Gunakan editor foto bawaan untuk menyesuaikan rasio ke 16:9 agar tampilan berita rapi.')
                                    ->directory('featured-images')
                                    ->columnSpanFull(),
                            ]),
                        Forms\Components\Hidden::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true),
                        Forms\Components\Hidden::make('seo_title'),
                        Forms\Components\Hidden::make('seo_description'),
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
                                    ->live()
                                    ->afterStateUpdated(function (?string $state, Forms\Set $set, Forms\Get $get): void {
                                        if ($state === 'published' && blank($get('published_at'))) {
                                            $set('published_at', now());
                                        }
                                    })
                                    ->required(),
                                Forms\Components\DateTimePicker::make('published_at')
                                    ->label('Tanggal Publikasi')
                                    ->default(now())
                                    ->helperText('Biarkan tanggal saat ini untuk langsung tampil. Pilih waktu di masa depan jika berita ingin dijadwalkan.'),
                            ]),
                        Forms\Components\Hidden::make('category_id')
                            ->default(fn () => Category::query()->where('slug', 'berita')->value('id')),
                        Forms\Components\Hidden::make('author_id')
                            ->default(fn () => auth()->id()),
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
                    ->rowIndex()
                    ->alignCenter()
                    ->size('sm'),
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul Berita')
                    ->description(fn (Post $record): ?string => $record->author?->name ? "Penulis: {$record->author->name}" : null)
                    ->searchable()
                    ->weight('medium')
                    ->size('sm')
                    ->wrap()
                    ->lineClamp(2),
                Tables\Columns\TextColumn::make('author.name')
                    ->label('Penulis')
                    ->sortable()
                    ->size('sm')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->alignCenter()
                    ->size('sm')
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
                    }),
                Tables\Columns\TextColumn::make('published_at')
                    ->label('Tanggal Publikasi')
                    ->dateTime('d/m/Y')
                    ->alignCenter()
                    ->size('sm')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Unggulan')
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('is_pinned')
                    ->label('Disematkan')
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('published_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status Publikasi')
                    ->options(['draft' => 'Draf', 'published' => 'Diterbitkan', 'archived' => 'Diarsipkan']),
                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('Berita Unggulan'),
                Tables\Filters\TernaryFilter::make('is_pinned')
                    ->label('Disematkan'),
            ])
            ->actions([
                Tables\Actions\Action::make('preview')
                    ->label('Pratinjau')
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->iconButton()
                    ->url(fn (Post $record): string => route('posts.show', $record->slug))
                    ->openUrlInNewTab(),
                Tables\Actions\EditAction::make()->label('Ubah')->iconButton(),
                Tables\Actions\DeleteAction::make()->label('Hapus')->iconButton(),
            ])
            ->emptyStateHeading('Belum Ada Berita')
            ->emptyStateDescription('Buat artikel berita baru untuk ditampilkan di portal bandara.')
            ->emptyStateIcon('heroicon-o-newspaper')
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
