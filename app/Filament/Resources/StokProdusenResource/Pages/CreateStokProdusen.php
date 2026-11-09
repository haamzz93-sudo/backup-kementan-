<?php

namespace App\Filament\Resources\StokProdusenResource\Pages;

use App\Filament\Resources\StokProdusenResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateStokProdusen extends CreateRecord
{
    protected static string $resource = StokProdusenResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
