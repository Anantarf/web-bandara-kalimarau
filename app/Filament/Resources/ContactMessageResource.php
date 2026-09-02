<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactMessageResource\Pages;
use App\Models\ContactMessage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ContactMessageResource extends Resource
{
    protected static ?string $model = ContactMessage::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    protected static ?string $navigationGroup = 'Layanan Operasional';

    protected static ?int $navigationSort = 1;

    protected static ?string $modelLabel = 'Pesan Pengaduan / Kontak';

    protected static ?string $pluralModelLabel = 'Pesan Pengaduan / Kontak';

    public static function getNavigationBadge(): ?string
    {
        $count = static::getModel()::query()->where('status', 'new')->count();

        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->columns(2)
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nama Pengirim')
                    ->required()
                    ->disabled(),
                Forms\Components\TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->disabled(),
                Forms\Components\TextInput::make('phone')
                    ->label('No. Telepon')
                    ->tel()
                    ->disabled(),
                Forms\Components\TextInput::make('subject')
                    ->label('Subjek')
                    ->disabled(),
                Forms\Components\Textarea::make('message')
                    ->label('Isi Pesan')
                    ->required()
                    ->disabled()
                    ->columnSpanFull(),
                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->helperText('Ubah status setelah pesan ini ditindaklanjuti.')
                    ->options(['new' => 'Baru', 'read' => 'Dibaca', 'replied' => 'Dibalas', 'archived' => 'Diarsipkan'])
                    ->default('new')
                    ->required(),
                Forms\Components\DateTimePicker::make('submitted_at')
                    ->label('Waktu Dikirim')
                    ->disabled(),
            ]);
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
                Tables\Columns\TextColumn::make('name')
                    ->label('Pengirim')
                    ->description(fn (ContactMessage $record): ?string => implode(' • ', array_filter([$record->email, $record->phone])))
                    ->searchable(['name', 'email', 'phone'])
                    ->weight('medium')
                    ->size('sm')
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('phone')
                    ->label('No. Telepon')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('subject')
                    ->label('Subjek')
                    ->searchable()
                    ->size('sm')
                    ->wrap()
                    ->lineClamp(2),
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
                    ->label('Waktu Dikirim')
                    ->dateTime('d/m/Y H:i')
                    ->alignCenter()
                    ->size('sm')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diubah')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('submitted_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options(['new' => 'Baru', 'read' => 'Dibaca', 'replied' => 'Dibalas', 'archived' => 'Diarsipkan']),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Ubah Status')->iconButton(),
                Tables\Actions\DeleteAction::make()->label('Hapus')->iconButton(),
            ])
            ->emptyStateHeading('Belum Ada Pesan Masuk')
            ->emptyStateDescription('Pesan dari form kontak pengunjung akan tampil secara otomatis di sini.')
            ->emptyStateIcon('heroicon-o-envelope')
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContactMessages::route('/'),
            'edit' => Pages\EditContactMessage::route('/{record}/edit'),
        ];
    }
}
