<?php

namespace App\Filament\Resources\ProdusenBenihResource\Widgets;

use Filament\Widgets\Widget;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use App\Models\ProdusenBenih;

class ProdusenBenihOverview extends BaseWidget
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
            Card::make('Jumlah BBH', 'Loading'),
            Card::make('Jumlah Produsen Umum', 'Loading'),
            Card::make('Jumlah Mitra Swasta', 'Loading'),
            Card::make('Jumlah UPBS', 'Loading'),
            ];
        }
        sleep(2);
        $bbh = ProdusenBenih::select('jenis_produsen_id')->where('jenis_produsen_id','=','4')->count();
        $umum = ProdusenBenih::select('jenis_produsen_id')->where('jenis_produsen_id','=','3')->count();
        $upbs = ProdusenBenih::select('jenis_produsen_id')->where('jenis_produsen_id','=','1')->count();
        $swasta = ProdusenBenih::select('jenis_produsen_id')->where('jenis_produsen_id','=','2')->count();
        return [
            Card::make('Jumlah BBH', $bbh)
            ->color('success'),
            Card::make('Jumlah Produsen Umum', $umum)
            ->color('primary'),
            Card::make('Jumlah Mitra Swasta', $swasta)
            ->color('info'),
            Card::make('Jumlah UPBS', $upbs)
            ->color('danger'),
            
        ];
    }
}
