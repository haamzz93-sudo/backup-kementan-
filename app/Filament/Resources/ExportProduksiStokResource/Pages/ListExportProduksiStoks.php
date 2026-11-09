<?php

namespace App\Filament\Resources\ExportProduksiStokResource\Pages;

use App\Filament\Resources\ExportProduksiStokResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use pxlrbt\FilamentExcel\Columns\Column;

class ListExportProduksiStoks extends ListRecords
{
    protected static string $resource = ExportProduksiStokResource::class;
    protected static ?string $title = 'Export Database Produksi APBN';
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
