<?php

namespace App\Filament\Resources\PemohonResource\Pages;

use App\Filament\Resources\PemohonResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePemohon extends CreateRecord
{
    protected static string $resource = PemohonResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
