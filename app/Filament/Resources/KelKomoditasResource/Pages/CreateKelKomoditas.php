<?php

namespace App\Filament\Resources\KelKomoditasResource\Pages;

use App\Filament\Resources\KelKomoditasResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateKelKomoditas extends CreateRecord
{
    protected static string $resource = KelKomoditasResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
