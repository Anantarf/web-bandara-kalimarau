<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AuditLogResource\Pages;
use App\Models\AuditLog;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class AuditLogResource extends Resource
{
    protected static ?string $model = AuditLog::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationGroup = null;

    protected static ?int $navigationSort = 6;

    protected static ?string $navigationLabel = 'Riwayat Aktivitas';

    protected static ?string $modelLabel = 'Riwayat Aktivitas';

    protected static ?string $pluralModelLabel = 'Riwayat Aktivitas';

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\TextEntry::make('created_at')
                    ->label('Waktu')
                    ->dateTime(),
                Infolists\Components\TextEntry::make('user.name')
                    ->label('Pengguna')
                    ->placeholder('Sistem'),
                Infolists\Components\TextEntry::make('event')
                    ->label('Aksi')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'created' => 'Dibuat',
                        'updated' => 'Diubah',
                        'deleted' => 'Dihapus',
                        default => Str::headline($state),
                    }),
                Infolists\Components\TextEntry::make('auditable_type')
                    ->label('Data')
                    ->formatStateUsing(fn (string $state): string => Str::headline(class_basename($state))),
                Infolists\Components\TextEntry::make('auditable_id')
                    ->label('ID'),
                Infolists\Components\KeyValueEntry::make('old_values')
                    ->label('Data Sebelum Diubah')
                    ->placeholder('-')
                    ->columnSpanFull(),
                Infolists\Components\KeyValueEntry::make('new_values')
                    ->label('Data Sesudah Diubah')
                    ->placeholder('-')
                    ->columnSpanFull(),
                Infolists\Components\TextEntry::make('url')
                    ->label('Alamat Halaman')
                    ->placeholder('-')
                    ->columnSpanFull(),
                Infolists\Components\TextEntry::make('ip_address')
                    ->label('Alamat IP')
                    ->placeholder('-'),
                Infolists\Components\TextEntry::make('user_agent')
                    ->label('Perangkat/Browser')
                    ->placeholder('-')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->striped()
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Waktu')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Pengguna')
                    ->placeholder('Sistem')
                    ->searchable(),
                Tables\Columns\TextColumn::make('event')
                    ->label('Aksi')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'created' => 'success',
                        'updated' => 'warning',
                        'deleted' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'created' => 'Dibuat',
                        'updated' => 'Diubah',
                        'deleted' => 'Dihapus',
                        default => Str::headline($state),
                    }),
                Tables\Columns\TextColumn::make('auditable_type')
                    ->label('Data')
                    ->formatStateUsing(fn (string $state): string => Str::headline(class_basename($state))),
                Tables\Columns\TextColumn::make('auditable_id')
                    ->label('ID')
                    ->sortable(),
                Tables\Columns\TextColumn::make('ip_address')
                    ->label('Alamat IP')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('event')
                    ->label('Aksi')
                    ->options([
                        'created' => 'Dibuat',
                        'updated' => 'Diubah',
                        'deleted' => 'Dihapus',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->label('Lihat Detail'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAuditLogs::route('/'),
            'view' => Pages\ViewAuditLog::route('/{record}'),
        ];
    }
}
