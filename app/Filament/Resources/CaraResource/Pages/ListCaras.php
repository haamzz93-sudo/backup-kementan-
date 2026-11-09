<?php

namespace App\Filament\Resources\CaraResource\Pages;

use App\Filament\Resources\CaraResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCaras extends ListRecords
{
    protected static string $resource = CaraResource::class;
    protected static ?string $title = 'Cara Perbanyakan Benih';
    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
