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

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $modelLabel = 'Pengguna';

    protected static ?string $pluralModelLabel = 'Pengguna';

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Sistem & Akses';

    protected static ?int $navigationSort = 6;

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
                                Forms\Components\TextInput::make('email')
                                    ->label('Alamat Email')
                                    ->email()
                                    ->required(),
                                Forms\Components\TextInput::make('password')
                                    ->label('Kata Sandi Baru')
                                    ->password()
                                    ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                                    ->dehydrated(fn ($state) => filled($state))
                                    ->required(fn (string $operation): bool => $operation === 'create')
                                    ->helperText('Kosongkan jika tidak ingin mengubah kata sandi.'),
                            ])->columns(1),
                    ])
                    ->columnSpan(['md' => 8]),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Akses & Status')
                            ->schema([
                                Forms\Components\Select::make('roles')
                                    ->label('Hak Akses (Role)')
                                    ->relationship('roles', 'name')
                                    ->preload()
                                    ->required(),
                                Forms\Components\Toggle::make('is_active')
                                    ->label('Status Aktif')
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
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('roles.name')
                    ->label('Hak Akses')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'super_admin' => 'danger',
                        'admin' => 'success',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => $state === 'super_admin' ? 'Super Admin' : 'Admin'),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
            ])
            ->filters([
                //
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
            'index' => Pages\ManageUsers::route('/'),
        ];
    }
}
