<?php

namespace App\Filament\Resources\ProvincesResource\Pages;

use App\Filament\Resources\ProvincesResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProvinces extends CreateRecord
{
    protected static string $resource = ProvincesResource::class;
    protected static ?string $title = 'Buat Provinsi';
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
