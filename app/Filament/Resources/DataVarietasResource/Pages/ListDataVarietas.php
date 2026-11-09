<?php

namespace App\Filament\Resources\DataVarietasResource\Pages;

use App\Filament\Resources\DataVarietasResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDataVarietas extends ListRecords
{
    protected static string $resource = DataVarietasResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
