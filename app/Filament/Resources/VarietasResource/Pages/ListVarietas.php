<?php

namespace App\Filament\Resources\VarietasResource\Pages;

use App\Filament\Resources\VarietasResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use pxlrbt\FilamentExcel\Columns\Column;

class ListVarietas extends ListRecords
{
    protected static string $resource = VarietasResource::class;

    protected function getActions(): array
    {
        return [
            ExportAction::make()->exports([
                ExcelExport::make()
                ->fromTable()
                    ->withColumns([
                        Column::make('kelkomoditas.nama_kelompok')
                        ->heading('Kelompok Komoditas'),
                        Column::make('komoditas.nama')
                        ->heading('Nama Komoditas'),
                        Column::make('nama_varietas')
                        ->heading('Nama Varietas'),
                        Column::make('kode')
                        ->heading('Kode Varietas'),
                        Column::make('pemohon.nama_produsen')
                        ->heading('Nama Pemohon'),
                        Column::make('no_sk')
                        ->heading('No. SK'),
                        Column::make('tahun_daftar')
                        ->heading('Tahun Pendaftaran Varietas'),
                        Column::make('upload_produk')
                        ->heading('File Produk'),
                        Column::make('upload_penciri')
                        ->heading('File Penciri'),
                        Column::make('upload_deskripsi')
                        ->heading('File Deskripsi'),
                        Column::make('no_reg')
                        ->heading('No. Registrasi'),
                        Column::make('wil_adaptasi')
                        ->heading('Wilayah Adaptasi')
                            ->getStateUsing(function ($record){
                                $tes = $record->wil_adaptasi;
                                if ($tes){
                                    foreach($tes as $data){
                                        if($data == "1"){
                                            $dd[] = "Dataran Rendah";
                                        }elseif($data == "2"){
                                            $dd[] = "Dataran Menengah";
                                        }elseif($data == "3"){
                                            $dd[] = "Dataran Tinggi";
                                        }
                                    }
                                    $tus =implode(", ",$dd);
                                    return $tus;
                                }else{
                                    return "Belum Diisi";
                                }  
                            }),
                        Column::make('iklim')
                        ->heading('Jenis Musim')
                            ->getStateUsing(function ($record){
                                $iklim = $record->iklim;
                                if ($iklim){
                                    foreach($iklim as $ik){
                                    if($ik == "1"){
                                        $k[] = "Musim Hujan";
                                    }elseif($ik == "2"){
                                        $k[] = "Musim Kemarau";
                                    }
                                }
                                $tus =implode(", ",$k);
                                    return $tus;
                                }else{
                                    return "Belum Diisi";
                                }  
                            }),
                        Column::make('asal')
                        ->heading('Asal Varietas')
                        ->getStateUsing(function ($record){
                            $asal = $record->asal;
                                if($asal == "1"){
                                    return "Introduksi";
                                }elseif($asal == "2"){
                                    return "Dalam Negeri";
                                }
                            })
                    ]),
            ])
        ];
    }
}
