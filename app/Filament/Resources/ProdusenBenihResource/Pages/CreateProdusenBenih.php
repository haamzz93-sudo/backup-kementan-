<?php

namespace App\Filament\Resources\ProdusenBenihResource\Pages;

use App\Filament\Resources\ProdusenBenihResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use DB;
class CreateProdusenBenih extends CreateRecord
{
    protected static string $resource = ProdusenBenihResource::class;
    protected static ?string $title = 'Buat Produsen/Pengedar Benih';
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function afterCreate():void
    {
       $data = $this->record;
       $jenis_produsen_id = $data->jenis_produsen_id;
       $kode = DB::table('jenis_produsen')->where('id',$jenis_produsen_id)->first();
       $nkode = $kode->kode;
       $prov_id=$data->provinces_id;
       if($data->jenis_lembaga_id == 2){
        $jenis_lembaga = "01";
        }     
        else{
        $jenis_lembaga = "02";
        }
       if($data->smm === true){
        $smm = "01";
       }else{
        $smm = "00";
       }
       $idnya = $data->id;
       $kodenya = $nkode.'.'.$prov_id.'.'.$jenis_lembaga.'.'.$smm.'.'.$idnya;
       DB::table('lembaga')->where('id',$idnya)->update(['kode_produsen' => $kodenya]);
       
   }
      
   }
