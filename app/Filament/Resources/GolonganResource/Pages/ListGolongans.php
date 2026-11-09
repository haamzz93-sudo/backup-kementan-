<?php

namespace App\Filament\Resources\GolonganResource\Pages;

use App\Filament\Resources\GolonganResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGolongans extends ListRecords
{
    protected static string $resource = GolonganResource::class;
    protected static ?string $title = 'Golongan Perbanyakan Benih';
    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
