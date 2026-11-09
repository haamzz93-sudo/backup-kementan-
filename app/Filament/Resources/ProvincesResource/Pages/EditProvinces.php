<?php

namespace App\Filament\Resources\ProvincesResource\Pages;

use App\Filament\Resources\ProvincesResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProvinces extends EditRecord
{
    protected static string $resource = ProvincesResource::class;
    protected static ?string $title = 'Edit Provinsi';
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
