<?php

namespace App\Filament\Resources\CaraResource\Pages;

use App\Filament\Resources\CaraResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCara extends CreateRecord
{
    protected static string $resource = CaraResource::class;
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
