<?php

namespace App\Filament\Resources\JenisProdusenResource\Pages;

use App\Filament\Resources\JenisProdusenResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListJenisProdusens extends ListRecords
{
    protected static string $resource = JenisProdusenResource::class;

    protected static ?string $title = 'Jenis Produsen';
    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
