<?php

namespace App\Filament\Resources\ExportProduksiNonAPBNResource\Pages;

use App\Filament\Resources\ExportProduksiNonAPBNResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditExportProduksiNonAPBN extends EditRecord
{
    protected static string $resource = ExportProduksiNonAPBNResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
