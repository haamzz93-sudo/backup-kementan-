<?php

namespace App\Filament\Resources\StokProdusenResource\Pages;

use App\Filament\Resources\StokProdusenResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStokProdusens extends ListRecords
{
    protected static string $resource = StokProdusenResource::class;

    protected function getActions(): array
    {
        return [
            //Actions\CreateAction::make(),
        ];
    }
}
