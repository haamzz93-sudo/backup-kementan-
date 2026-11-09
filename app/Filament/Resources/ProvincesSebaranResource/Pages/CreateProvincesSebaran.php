<?php

namespace App\Filament\Resources\ProvincesSebaranResource\Pages;

use App\Filament\Resources\ProvincesSebaranResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProvincesSebaran extends CreateRecord
{
    protected static string $resource = ProvincesSebaranResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
