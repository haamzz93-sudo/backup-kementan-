<?php

namespace App\Filament\Resources\JenisPenyimpananResource\Pages;

use App\Filament\Resources\JenisPenyimpananResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListJenisPenyimpanans extends ListRecords
{
    protected static string $resource = JenisPenyimpananResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
