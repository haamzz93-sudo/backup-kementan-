<?php

namespace App\Filament\Resources\JenisPemilikResource\Pages;

use App\Filament\Resources\JenisPemilikResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListJenisPemiliks extends ListRecords
{
    protected static string $resource = JenisPemilikResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
