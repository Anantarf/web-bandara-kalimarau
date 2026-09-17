<?php

namespace App\Filament\Resources\SurveyReportResource\Pages;

use App\Filament\Resources\SurveyReportResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSurveyReport extends CreateRecord
{
    protected static string $resource = SurveyReportResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
