<?php

namespace App\Filament\Resources\LaporanProduksiSwadayaResource\Pages;

use App\Filament\Resources\LaporanProduksiSwadayaResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLaporanProduksiSwadaya extends EditRecord
{
    protected static string $resource = LaporanProduksiSwadayaResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
