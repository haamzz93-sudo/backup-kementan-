<?php

namespace App\Filament\Resources\ExportProduksiNonAPBNResource\Pages;

use App\Filament\Resources\ExportProduksiNonAPBNResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use pxlrbt\FilamentExcel\Columns\Column;

class ListExportProduksiNonAPBNS extends ListRecords
{
    protected static string $resource = ExportProduksiNonAPBNResource::class;
    protected static ?string $title = 'Export Database Produksi Non APBN';
    protected function getActions(): array
    {
        return [
            ExportAction::make()->exports([
                ExcelExport::make()
                ->fromTable()
            ])
        ];
    }
}
