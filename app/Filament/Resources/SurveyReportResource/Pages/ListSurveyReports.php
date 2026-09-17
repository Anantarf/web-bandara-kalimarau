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
            Actions\CreateAction::make()->label('Tambah Laporan Survei'),
        ];
    }
}
