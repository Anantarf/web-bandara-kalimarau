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

    protected static ?string $heading = 'Pesan Pengaduan Terbaru';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                ContactMessage::query()->latest('submitted_at')->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('no')
                    ->label('No.')
                    ->rowIndex()
                    ->alignCenter()
                    ->size('sm'),
                Tables\Columns\TextColumn::make('name')
                    ->label('Pengirim')
                    ->description(fn (ContactMessage $record): ?string => implode(' • ', array_filter([$record->email, $record->phone])))
                    ->weight('medium')
                    ->size('sm'),
                Tables\Columns\TextColumn::make('subject')
                    ->label('Subjek')
                    ->size('sm')
                    ->wrap()
                    ->lineClamp(1),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->alignCenter()
                    ->size('sm')
                    ->color(fn (string $state): string => match ($state) {
                        'new' => 'danger',
                        'read' => 'warning',
                        'replied' => 'success',
                        'archived' => 'gray',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'new' => 'Baru',
                        'read' => 'Dibaca',
                        'replied' => 'Dibalas',
                        'archived' => 'Diarsipkan',
                        default => ucfirst($state),
                    }),
                Tables\Columns\TextColumn::make('submitted_at')
                    ->label('Waktu')
                    ->dateTime('d/m/Y H:i')
                    ->alignCenter()
                    ->size('sm'),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('Buka')
                    ->icon('heroicon-o-eye')
                    ->iconButton()
                    ->url(fn (ContactMessage $record): string => route('filament.admin.resources.contact-messages.edit', $record)),
            ])
            ->paginated(false);
    }
}
