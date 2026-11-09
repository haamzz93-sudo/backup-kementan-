<?php

namespace App\Filament\Resources\ExportPohonIndukResource\Pages;

use App\Filament\Resources\ExportPohonIndukResource;
use App\Models\KondisiPohon;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use pxlrbt\FilamentExcel\Columns\Column;

class ListExportPohonInduks extends ListRecords
{
    protected static string $resource = ExportPohonIndukResource::class;

    protected static ?string $title = 'Export Database Tanaman Induk';
    protected function getActions(): array
    {
        return [
            ExportAction::make()->exports([
                ExcelExport::make()
                ->fromTable()
                    // ->withColumns([
                    //     Column::make('no_registrasi')
                    //     ->heading('Nomor Registrasi'),
                    //     Column::make('pohoninduk.komoditas.nama')
                    //     ->heading('Komoditas'),
                    //     Column::make('pohoninduk.varietas.nama_varietas')
                    //     ->heading('Varietas'),
                    //     Column::make('pohoninduk.kelasbenih.kelas_benih')
                    //     ->heading('Kelas Benih'),
                    //     Column::make('pemilikpohon.nama_lembaga')
                    //     ->heading('Pemilik'),
                    //     Column::make('lembagasertifikasi.nama_lembaga')
                    //     ->heading('Lembaga Sertifikasi'),
                    //     Column::make('kondisipohon.kapasitas')
                    //     ->heading()
                    // ])
            ])
        ];
    }
}