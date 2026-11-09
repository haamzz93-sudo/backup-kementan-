<?php

namespace App\Filament\Resources\ProduksiBenihUmumResource\Pages;

use App\Filament\Resources\ProduksiBenihUmumResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProduksiBenihUmums extends ListRecords
{
    protected static string $resource = ProduksiBenihUmumResource::class;
    protected static ?string $title = 'Label Produksi Benih';
    protected function getActions(): array
    {
        return [
            //Actions\CreateAction::make(),
        ];
    }
}
