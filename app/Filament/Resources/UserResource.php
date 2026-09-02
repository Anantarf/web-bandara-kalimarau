<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $modelLabel = 'Pengguna';

    protected static ?string $pluralModelLabel = 'Pengguna';

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = '⚙️ Pengaturan & Keamanan';

    protected static ?int $navigationSort = 1;

    protected static array $roleLabels = [
        'super_admin' => 'Pengelola Utama',
        'admin' => 'Admin Konten & Layanan',
    ];

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Informasi Pengguna')
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Nama Lengkap')
                                    ->required(),
                                Forms\Components\TextInput::make('username')
                                    ->label('Username Login')
                                    ->helperText('Dipakai untuk masuk ke laman admin. Gunakan huruf kecil tanpa spasi, contoh: admin.konten')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('password')
                                    ->label('Kata Sandi Baru')
                                    ->password()
                                    ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                                    ->dehydrated(fn ($state) => filled($state))
                                    ->required(fn (string $operation): bool => $operation === 'create')
                                    ->helperText(fn (string $operation): string => $operation === 'create'
                                        ? 'Wajib diisi untuk pengguna baru.'
                                        : 'Kosongkan jika tidak ingin mengubah kata sandi.'),
                            ])->columns(1),
                    ])
                    ->columnSpan(['md' => 8]),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Akses & Status')
                            ->schema([
                                Forms\Components\Select::make('roles')
                                    ->label('Hak Akses')
                                    ->relationship('roles', 'name', fn ($query) => $query->whereIn('name', array_keys(self::$roleLabels)))
                                    ->getOptionLabelFromRecordUsing(fn (Role $record): string => self::$roleLabels[$record->name] ?? str($record->name)->replace('_', ' ')->title()->toString())
                                    ->preload()
                                    ->helperText('Pengelola Utama dapat mengatur semua data. Admin Konten & Layanan hanya mengelola konten website dan data layanan.')
                                    ->required(),
                                Forms\Components\Toggle::make('is_active')
                                    ->label('Status Aktif')
                                    ->helperText('Nonaktifkan jika pengguna sementara tidak boleh masuk ke laman admin.')
                                    ->default(true)
                                    ->required(),
                            ]),
                    ])
                    ->columnSpan(['md' => 4]),
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
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('username')
                    ->label('Username')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('roles.name')
                    ->label('Hak Akses')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'super_admin' => 'danger',
                        'admin' => 'success',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => self::$roleLabels[$state] ?? str($state)->replace('_', ' ')->title()->toString()),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
                Tables\Columns\TextColumn::make('last_login_at')
                    ->label('Terakhir Masuk')
                    ->dateTime('d M Y H:i')
                    ->placeholder('Belum pernah')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status Akun')
                    ->placeholder('Semua pengguna')
                    ->trueLabel('Aktif')
                    ->falseLabel('Nonaktif'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Ubah'),
                Tables\Actions\DeleteAction::make()
                    ->label('Hapus')
                    ->visible(fn (User $record): bool => auth()->id() !== $record->id),
            ])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageUsers::route('/'),
        ];
    }
}
