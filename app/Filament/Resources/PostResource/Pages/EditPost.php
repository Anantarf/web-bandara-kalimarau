<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\URL;

class EditPost extends EditRecord
{
    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('preview')
                ->label('Pratinjau')
                ->icon('heroicon-o-eye')
                ->url(fn (): string => URL::temporarySignedRoute('posts.preview', now()->addMinutes(30), ['post' => $this->getRecord()]))
                ->openUrlInNewTab(),
            Actions\DeleteAction::make(),
        ];
    }
}
