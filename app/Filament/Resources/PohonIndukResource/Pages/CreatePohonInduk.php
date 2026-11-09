<?php

namespace App\Filament\Resources\PohonIndukResource\Pages;

use App\Filament\Resources\PohonIndukResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use DB;
class CreatePohonInduk extends CreateRecord
{
    protected static string $resource = PohonIndukResource::class;
    protected static ?string $title = 'Buat Inventaris Tanaman Induk';
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    
    protected function afterCreate():void
    {
       $data = $this->record;
       $kodeawal = $data->kode_awal;
       $kodeakhir = $data->kode_akhir;
       $urutawal = $data->urut_awal;
       $urutakhir = $data->urut_akhir;
       $idnya = $data->id;
       $urutawal1 = sprintf('%02d', $urutawal);
       $urutakhir1 = sprintf('%02d', $urutakhir);
       $induk = $kodeawal.$urutawal1.'-'.$urutakhir1.$kodeakhir;
       DB::table('pohon_induk')->where('id',$idnya)->update(['nomor_induk' => $induk]); 
    for ($x = $urutawal; $x <= $urutakhir; $x++){
        $urut = sprintf('%02d', $x);
       DB::table('child_pohon_induk')->where('pohon_induk_id',$idnya)->updateOrInsert(
        ['no_registrasi' => $kodeawal.$urut.$kodeakhir,
        'pohon_induk_id' => $idnya,
        'pemilik_pohon_id' => $data->pemilik_pohon_id,
        'lembaga_serti_id' => $data->lembaga_serti_id],        
       );
    }
   }
}
