<?php

namespace App\Filament\Resources\NomorRegistrasiResource\Pages;

use App\Filament\Resources\NomorRegistrasiResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListNomorRegistrasis extends ListRecords
{
    protected static string $resource = NomorRegistrasiResource::class;
    protected static ?string $title = 'Laporan Kondisi Tanaman Induk';

    protected function getActions(): array
    {
        return [
        ];
    }
}
