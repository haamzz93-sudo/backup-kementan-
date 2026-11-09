<?php

namespace App\Filament\Resources\ExportSertifikatKompetensiResource\Pages;

use App\Filament\Resources\ExportSertifikatKompetensiResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use pxlrbt\FilamentExcel\Columns\Column;

class ListExportSertifikatKompetensis extends ListRecords
{
    protected static string $resource = ExportSertifikatKompetensiResource::class;
    protected static ?string $title = 'Export Database Sertifikat Kompetensi';
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
