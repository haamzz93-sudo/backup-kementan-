<?php

namespace App\Filament\Resources\KomoditasResource\Pages;

use App\Filament\Resources\KomoditasResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKomoditas extends ListRecords
{
    protected static string $resource = KomoditasResource::class;

    protected static ?string $title = 'Komoditas';
    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
