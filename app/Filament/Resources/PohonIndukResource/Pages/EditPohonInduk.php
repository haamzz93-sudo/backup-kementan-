<?php

namespace App\Filament\Resources\PohonIndukResource\Pages;

use App\Filament\Resources\PohonIndukResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use DB;
class EditPohonInduk extends EditRecord
{
    protected static string $resource = PohonIndukResource::class;
    protected static ?string $title = 'Ubah Inventaris Tanaman Induk';
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getActions(): array
    {
        return [
            //Actions\DeleteAction::make(),
        ];
    }
    protected function afterSave():void
    {
        $data = $this->record;
        $kodeawal = $data->kode_awal;
        $kodeakhir = $data->kode_akhir;
        $urutawal = $data->urut_awal;
        $urutakhir = $data->urut_akhir;
        $idnya = $data->id;
        $induk = $kodeawal.'/'.$urutawal.'-'.$urutakhir.'/'.$kodeakhir;
        DB::table('pohon_induk')->where('id',$idnya)->update(['nomor_induk' => $induk]);    
   }
}
