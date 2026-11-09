<?php

namespace App\Filament\Resources\LaporanProduksiSwadayaResource\Pages;

use App\Filament\Resources\LaporanProduksiSwadayaResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLaporanProduksiSwadayas extends ListRecords
{
    protected static string $resource = LaporanProduksiSwadayaResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
