<?php

namespace App\Filament\Resources\SatuanResource\Pages;

use App\Filament\Resources\SatuanResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSatuans extends ListRecords
{
    protected static string $resource = SatuanResource::class;

    protected static ?string $title = 'Satuan Benih';
    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
