<?php

namespace App\Filament\Resources\LembagaSertifikasiResource\Pages;

use App\Filament\Resources\LembagaSertifikasiResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateLembagaSertifikasi extends CreateRecord
{
    protected static string $resource = LembagaSertifikasiResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
