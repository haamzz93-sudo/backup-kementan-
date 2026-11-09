<?php

namespace App\Filament\Resources\ProdusenBenihResource\Pages;

use Illuminate\Contracts\View\View;
use Livewire\Component;
use App\Filament\Resources\ProdusenBenihResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;


class ListProdusenBenihs extends ListRecords
{
    protected static string $resource = ProdusenBenihResource::class;
    
    protected static ?string $title = 'Produsen/Pengedar Benih';
    // protected function getHeaderWidgets(): array
    // {
    //     return [
    //         ProdusenBenihResource\Widgets\ProdusenBenihOverview::class,
    //     ];
    // }
    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery();
    }
    
    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    
}
