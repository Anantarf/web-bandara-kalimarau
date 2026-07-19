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

    protected static ?int $navigationSort = 6;

    protected static ?string $navigationLabel = 'Audit Log';

    protected static ?string $modelLabel = 'Audit Log';

    protected static ?string $pluralModelLabel = 'Audit Log';

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
                    }),
                Infolists\Components\TextEntry::make('auditable_type')
                    ->label('Data')
                    ->formatStateUsing(fn (string $state): string => Str::headline(class_basename($state))),
                Infolists\Components\TextEntry::make('auditable_id')
                    ->label('ID'),
                Infolists\Components\KeyValueEntry::make('old_values')
                    ->label('Nilai Sebelum')
                    ->placeholder('-')
                    ->columnSpanFull(),
                Infolists\Components\KeyValueEntry::make('new_values')
                    ->label('Nilai Sesudah')
                    ->placeholder('-')
                    ->columnSpanFull(),
                Infolists\Components\TextEntry::make('url')
                    ->label('URL')
                    ->placeholder('-')
                    ->columnSpanFull(),
                Infolists\Components\TextEntry::make('ip_address')
                    ->label('IP')
                    ->placeholder('-'),
                Infolists\Components\TextEntry::make('user_agent')
                    ->label('User Agent')
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
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'created' => 'Dibuat',
                        'updated' => 'Diubah',
                        'deleted' => 'Dihapus',
                    }),
                Tables\Columns\TextColumn::make('auditable_type')
                    ->label('Data')
                    ->formatStateUsing(fn (string $state): string => Str::headline(class_basename($state))),
                Tables\Columns\TextColumn::make('auditable_id')
                    ->label('ID')
                    ->sortable(),
                Tables\Columns\TextColumn::make('ip_address')
                    ->label('IP')
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
                Tables\Actions\ViewAction::make(),
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
