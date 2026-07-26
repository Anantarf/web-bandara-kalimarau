<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageUsers extends ManageRecords
{
    protected static string $resource = UserResource::class;

    protected static ?string $title = 'Pengaturan Pengguna Admin';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Pengguna')
                ->modalHeading('Tambah Pengguna Admin')
                ->modalSubmitActionLabel('Simpan Pengguna'),
        ];
    }
}
