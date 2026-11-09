<?php

namespace App\Filament\Resources\ProduksiBenihAPBDResource\Pages;

use App\Filament\Resources\ProduksiBenihAPBDResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProduksiBenihAPBDS extends ListRecords
{
    protected static string $resource = ProduksiBenihAPBDResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
