<?php

namespace App\Filament\Widgets;

use App\Models\ContactMessage;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestMessagesWidget extends BaseWidget
{
    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 'full';

    protected static ?string $heading = 'Pesan & Pengaduan Terbaru Masuk';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                ContactMessage::query()->latest()
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Pengirim')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email'),
                Tables\Columns\TextColumn::make('subject')
                    ->label('Subjek')
                    ->limit(30),
                Tables\Columns\IconColumn::make('is_read')
                    ->label('Dibaca')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Waktu Masuk')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('Buka Pesan')
                    ->icon('heroicon-o-eye')
                    ->url(fn (ContactMessage $record): string => route('filament.admin.resources.contact-messages.edit', $record)),
            ])
            ->paginated(false);
    }
}
