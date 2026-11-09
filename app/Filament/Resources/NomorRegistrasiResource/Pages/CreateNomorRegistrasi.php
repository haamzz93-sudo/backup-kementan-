<?php

namespace App\Filament\Resources\NomorRegistrasiResource\Pages;

use App\Filament\Resources\NomorRegistrasiResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateNomorRegistrasi extends CreateRecord
{
    protected static string $resource = NomorRegistrasiResource::class;
    protected static ?string $title = 'Buat Laporan Kondisi Tanaman Induk';
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
