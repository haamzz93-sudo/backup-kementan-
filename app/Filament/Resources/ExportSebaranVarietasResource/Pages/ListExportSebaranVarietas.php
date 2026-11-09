<?php

namespace App\Filament\Resources\ExportSebaranVarietasResource\Pages;

use App\Filament\Resources\ExportSebaranVarietasResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use pxlrbt\FilamentExcel\Columns\Column;

class ListExportSebaranVarietas extends ListRecords
{
    protected static string $resource = ExportSebaranVarietasResource::class;
    protected static ?string $title = 'Export Database Sebaran Varietas';
    protected function getActions(): array
    {
        return [
            ExportAction::make()->exports([
                ExcelExport::make()
                ->fromTable()])
        ];
    }
}
