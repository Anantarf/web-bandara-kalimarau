<?php

namespace App\Filament\Resources\ContactMessageResource\Pages;

use App\Filament\Resources\ContactMessageResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListContactMessages extends ListRecords
{
    protected static string $resource = ContactMessageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('export_csv')
                ->label('Export Rekap CSV')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->action(function () {
                    return response()->streamDownload(function () {
                        $handle = fopen('php://output', 'w');
                        // UTF-8 BOM for Microsoft Excel compatibility
                        fputs($handle, "\xEF\xBB\xBF");
                        fputcsv($handle, ['ID', 'Nama Pengirim', 'Email', 'No Telepon', 'Subjek', 'Pesan', 'Status', 'Waktu Dikirim']);

                        \App\Models\ContactMessage::latest('submitted_at')->chunk(200, function ($records) use ($handle) {
                            foreach ($records as $record) {
                                fputcsv($handle, [
                                    $record->id,
                                    $record->name,
                                    $record->email,
                                    $record->phone,
                                    $record->subject,
                                    $record->message,
                                    match ($record->status) {
                                        'new' => 'Baru',
                                        'read' => 'Dibaca',
                                        'replied' => 'Dibalas',
                                        'archived' => 'Diarsipkan',
                                        default => ucfirst($record->status),
                                    },
                                    $record->submitted_at?->format('d/m/Y H:i') ?? '-',
                                ]);
                            }
                        });

                        fclose($handle);
                    }, 'rekap-pengaduan-kalimarau-'.now()->format('Y-m-d').'.csv', [
                        'Content-Type' => 'text/csv; charset=UTF-8',
                    ]);
                }),
            Actions\CreateAction::make()->label('Tambah Pesan'),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Semua Pesan')
                ->badge(fn () => static::getResource()::getModel()::count()),
            'new' => Tab::make('Pesan Baru')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'new'))
                ->badge(fn () => static::getResource()::getModel()::where('status', 'new')->count())
                ->badgeColor('danger'),
            'read' => Tab::make('Sudah Dibaca')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'read'))
                ->badge(fn () => static::getResource()::getModel()::where('status', 'read')->count())
                ->badgeColor('warning'),
            'replied' => Tab::make('Sudah Dibalas')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'replied'))
                ->badge(fn () => static::getResource()::getModel()::where('status', 'replied')->count())
                ->badgeColor('success'),
            'archived' => Tab::make('Diarsipkan')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'archived'))
                ->badgeColor('gray'),
        ];
    }
}
