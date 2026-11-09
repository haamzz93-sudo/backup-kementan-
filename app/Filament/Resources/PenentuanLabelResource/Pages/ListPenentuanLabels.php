<?php

namespace App\Filament\Resources\PenentuanLabelResource\Pages;

use App\Filament\Resources\PenentuanLabelResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPenentuanLabels extends ListRecords
{
    protected static string $resource = PenentuanLabelResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
