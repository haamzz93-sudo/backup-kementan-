<?php

namespace App\Filament\Resources\ExportLembagaResource\Pages;

use App\Filament\Resources\ExportLembagaResource;
use Filament\Pages\Actions;
use App\Models\SertifikatKompetensi;
use App\Models\PerpanjanganSMM;
use Filament\Resources\Pages\ListRecords;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use pxlrbt\FilamentExcel\Columns\Column;

class ListExportLembagas extends ListRecords
{
    protected static string $resource = ExportLembagaResource::class;
    protected static ?string $title = 'Export Database Produsen/Pengedar Benih';
    protected function getActions(): array
    {
        return [
            ExportAction::make()->exports([
                ExcelExport::make()
                ->fromTable()
                    ->withColumns([
                        Column::make('kode_produsen'),
                        Column::make('nama_lembaga'),
                        Column::make('jenis_lembaga.nama_jenis'),
                        Column::make('jenis_produsen.nama_jenis'),
                        Column::make('provinces.name'),
                        Column::make('regencies.name'),
                        Column::make('districts.name'),
                        Column::make('villages.name'),
                        Column::make('nama_kepala'),
                        Column::make('no_telp'),
                        Column::make('alamat'),
                        Column::make('rt'),
                        Column::make('rw'), 
                        Column::make('kodepos'),
                        Column::make('serkom')
                        ->heading("Status Sertifikat Kompetensi")
                        ->getStateUsing(
                            function($record){
                                $now = date("Y-m-d");
                                $serkom = SertifikatKompetensi::where('lembaga_id',$record->id)
                                ->whereDate('tgl_akhir','<=', now())
                                ->groupBy('no_serti')
                                ->count();
                                $panjang = SertifikatKompetensi::where('lembaga_id',$record->id)
                                ->whereDate('tgl_akhir','>=', now())
                                ->whereHas('perpanjangansmm',function($q){
                                    $q->where('tgl_berlaku', '<=', now());
                                })
                                ->groupBy('no_serti')
                                ->count();
                                // foreach($serkom as $sert){
                                //     $now = date("Y-m-d");
                                //     $tgl_akhir = $sert->tgl_akhir;
                                //     $panjang =  $sert->perpanjangansmm->where('child_smm_id',$sert->id)->sortByDesc('tgl_perpanjangan')->first();
                                //     if($panjang){
                                //     $tglakhirp = $panjang->tgl_berlaku;
                                //     if($now>$tglakhirp){
                                //         $ucap = "Perpanjangan Tidak Berlaku";
                                //     }else{
                                //         $ucap = "Perpanjangan Berlaku";
                                //     }
                                //     }else{
                                //         if($now>$tgl_akhir){
                                //             $ucap = "Sert. Tidak Berlaku" ;
                                //         }else{
                                //             $ucap = "Sert. Berlaku";
                                //         }
                                //     }
                                //     return $sert->no_serti." - ".$ucap;

                                // }
                               // $tus = implode(", ",$ts);
                                return $serkom+$panjang." Sertifikat yang masih berlaku";
                            }
                        ),
                    ]),
            ])
        ];
    }
}
