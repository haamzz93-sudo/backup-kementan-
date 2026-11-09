<?php

namespace App\Filament\Resources\KelKomoditasResource\Pages;

use App\Filament\Resources\KelKomoditasResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKelKomoditas extends ListRecords
{
    protected static string $resource = KelKomoditasResource::class;

    protected static ?string $title = 'Kelompok Komoditas';
    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
