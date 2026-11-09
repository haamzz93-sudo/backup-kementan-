<?php

namespace App\Filament\Resources\DokumenPemeriksaanAPBNResource\Pages;

use App\Filament\Resources\DokumenPemeriksaanAPBNResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDokumenPemeriksaanAPBNS extends ListRecords
{
    protected static string $resource = DokumenPemeriksaanAPBNResource::class;

    protected function getActions(): array
    {
        return [
           // Actions\CreateAction::make(),
        ];
    }
}
