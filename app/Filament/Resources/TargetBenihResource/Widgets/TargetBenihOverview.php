<?php

namespace App\Filament\Resources\TargetBenihResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use App\Models\LaporanTargetBenih;

class TargetBenihOverview extends BaseWidget
{
        protected int | string | array $columnSpan = [
        'md' => 2,
        'xl' => 2,
    ];
    public bool $readyToLoad = false;

    public function loadData()
    {
        $this->readyToLoad = true;
    }
    protected function getCards(): array
    {
        if (! $this->readyToLoad) {
            return [
            Card::make('Belum Diverifikasi', 'Loading'),
            Card::make('Terverifikasi', 'Loading'),
            Card::make('Ditolak', 'Loading'),
            Card::make('Selesai', 'Loading'),
            ];
        }
        sleep(2);
        if(auth()->user()->hasRole("Pelapor")){
        $belum = LaporanTargetBenih::where([['lokasi_produksi_detail_id',auth()->user()->lokasi_produksi_detail_id],['status','=','reactive']])->orWhereNull('status')->count();
        $verif = LaporanTargetBenih::where([['lokasi_produksi_detail_id',auth()->user()->lokasi_produksi_detail_id],['status','=','active']])->count();
        $tolak = LaporanTargetBenih::where([['lokasi_produksi_detail_id',auth()->user()->lokasi_produksi_detail_id],['status','=','tolak']])->count();
        $selesai = LaporanTargetBenih::where([['lokasi_produksi_detail_id',auth()->user()->lokasi_produksi_detail_id],['status','=','selesai']])->count();
        }elseif( auth()->user()->hasRole("Produsen Benih")){
            $belum = LaporanTargetBenih::where([['lembaga_id',auth()->user()->lembaga_id],['status','=','reactive']])->orWhereNull('status')->count();
        $verif = LaporanTargetBenih::where([['lembaga_id',auth()->user()->lembaga_id],['status','=','active']])->count();
        $tolak = LaporanTargetBenih::where([['lembaga_id',auth()->user()->lembaga_id],['status','=','tolak']])->count();
        $selesai = LaporanTargetBenih::where([['lembaga_id',auth()->user()->lembaga_id],['status','=','selesai']])->count();
        }elseif(auth()->user()->hasRole("Lembaga Sertifikasi Benih")){
            $belum = LaporanTargetBenih::join('lembaga','lembaga.id','=','target_benih.lembaga_id')->where([['lembaga.lembaga_serti_id',auth()->user()->lembaga_id],['target_benih.status','=','reactive']])->orWhereNull('target_benih.status')->count();
        $verif = LaporanTargetBenih::join('lembaga','lembaga.id','=','target_benih.lembaga_id')->where([['lembaga.lembaga_serti_id',auth()->user()->lembaga_id],['target_benih.status','=','active']])->count();
        $tolak = LaporanTargetBenih::join('lembaga','lembaga.id','=','target_benih.lembaga_id')->where([['lembaga.lembaga_serti_id',auth()->user()->lembaga_id],['target_benih.status','=','tolak']])->count();
        $selesai = LaporanTargetBenih::join('lembaga','lembaga.id','=','target_benih.lembaga_id')->where([['lembaga.lembaga_serti_id',auth()->user()->lembaga_id],['target_benih.status','=','selesai']])->count();
        }else{
        $belum = LaporanTargetBenih::select('status')->where('status','=','reactive')->orWhereNull('status')->count();
        $verif = LaporanTargetBenih::select('status')->where('status','=','active')->count();
        $tolak = LaporanTargetBenih::select('status')->where('status','=','tolak')->count();
        $selesai = LaporanTargetBenih::select('status')->where('status','=','selesai')->count();
        }
        
        return [
            Card::make('Belum Diverifikasi', $belum)
            ->chart([7, 2, 10, 3, 15, 4, 17])
            ->color('warning'),
            Card::make('Terverifikasi', $verif)
            ->chart([7, 2, 10, 3, 15, 4, 17])
            ->color('success'),
            Card::make('Ditolak', $tolak)
            ->chart([7, 2, 10, 3, 15, 4, 17])
            ->color('danger'),
            Card::make('Selesai', $selesai)
            ->chart([7, 2, 10, 3, 15, 4, 17])
            ->color('info'),
            
        ];
    }
}
