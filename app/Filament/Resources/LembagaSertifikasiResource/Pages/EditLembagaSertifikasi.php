<?php

namespace App\Filament\Resources\LembagaSertifikasiResource\Pages;

use App\Filament\Resources\LembagaSertifikasiResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLembagaSertifikasi extends EditRecord
{
    protected static string $resource = LembagaSertifikasiResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
