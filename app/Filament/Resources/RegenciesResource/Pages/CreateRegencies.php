<?php

namespace App\Filament\Resources\RegenciesResource\Pages;

use App\Filament\Resources\RegenciesResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateRegencies extends CreateRecord
{
    protected static string $resource = RegenciesResource::class;
    protected static ?string $title = 'Buat Kab/Kota';
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
