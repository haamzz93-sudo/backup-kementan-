<?php

namespace App\Filament\Resources\KomoditasResource\Pages;

use App\Filament\Resources\KomoditasResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateKomoditas extends CreateRecord
{
    protected static string $resource = KomoditasResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
