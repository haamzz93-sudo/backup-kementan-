<?php

namespace App\Filament\Resources\DistrictsResource\Pages;

use App\Filament\Resources\DistrictsResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDistricts extends CreateRecord
{
    protected static string $resource = DistrictsResource::class;
    protected static ?string $title = 'Buat Kecamatan';
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
