<?php

namespace App\Filament\Resources\JenisLembagaResource\Pages;

use App\Filament\Resources\JenisLembagaResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditJenisLembaga extends EditRecord
{
    protected static string $resource = JenisLembagaResource::class;

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
