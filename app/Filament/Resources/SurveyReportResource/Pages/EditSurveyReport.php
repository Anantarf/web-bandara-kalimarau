<?php

namespace App\Filament\Resources\SurveyReportResource\Pages;

use App\Filament\Resources\SurveyReportResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSurveyReport extends EditRecord
{
    protected static string $resource = SurveyReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()->label('Hapus Laporan'),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
