<?php

namespace App\Filament\Resources\PageResource\Pages;

use App\Filament\Resources\PageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\URL;

class EditPage extends EditRecord
{
    protected static string $resource = PageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('preview')
                ->label('Pratinjau')
                ->icon('heroicon-o-eye')
                ->url(fn (): string => URL::temporarySignedRoute('pages.preview', now()->addMinutes(30), ['page' => $this->getRecord()]))
                ->openUrlInNewTab(),
            Actions\DeleteAction::make(),
        ];
    }
}
