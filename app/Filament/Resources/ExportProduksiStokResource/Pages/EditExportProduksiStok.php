<?php

namespace App\Filament\Resources\ExportProduksiStokResource\Pages;

use App\Filament\Resources\ExportProduksiStokResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditExportProduksiStok extends EditRecord
{
    protected static string $resource = ExportProduksiStokResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
