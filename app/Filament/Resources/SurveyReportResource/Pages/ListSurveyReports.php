<?php

namespace App\Filament\Resources\SurveyReportResource\Pages;

use App\Filament\Resources\SurveyReportResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSurveyReports extends ListRecords
{
    protected static string $resource = SurveyReportResource::class;

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
                        fputcsv($handle, ['ID', 'Judul Laporan', 'Tahun', 'Periode', 'Nilai / IKM', 'Jumlah Responden', 'Status Publikasi', 'Ringkasan']);

                        \App\Models\SurveyReport::ordered()->chunk(200, function ($records) use ($handle) {
                            foreach ($records as $record) {
                                fputcsv($handle, [
                                    $record->id,
                                    $record->title,
                                    $record->year,
                                    $record->period ?? '-',
                                    $record->score ?? '-',
                                    $record->respondents_count ?? '-',
                                    $record->is_published ? 'Diterbitkan' : 'Draf',
                                    $record->summary ?? '-',
                                ]);
                            }
                        });

                        fclose($handle);
                    }, 'rekap-survei-kepuasan-kalimarau-'.now()->format('Y-m-d').'.csv', [
                        'Content-Type' => 'text/csv; charset=UTF-8',
                    ]);
                }),
            Actions\CreateAction::make()->label('Tambah Laporan Survei'),
        ];
    }
}
