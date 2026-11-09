<?php

namespace App\Filament\Resources\ProduksiBenihResource\Pages;

use App\Filament\Resources\ProduksiBenihResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProduksiBenihs extends ListRecords
{
    protected static string $resource = ProduksiBenihResource::class;
    protected static ?string $title = 'Produksi Benih';
    
    protected function getActions(): array
    {
        return [
            //Actions\CreateAction::make(),
            
        ];
    }
    
}
