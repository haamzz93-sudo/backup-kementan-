<?php

namespace App\Filament\Resources\JenisProdusenResource\Pages;

use App\Filament\Resources\JenisProdusenResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditJenisProdusen extends EditRecord
{
    protected static string $resource = JenisProdusenResource::class;
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
