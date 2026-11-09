<?php

namespace App\Filament\Resources\ProvincesResource\Pages;

use App\Filament\Resources\ProvincesResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProvinces extends ListRecords
{
    protected static string $resource = ProvincesResource::class;
    protected static ?string $title = 'Database Provinsi';
    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Tambah Data'),
        ];
    }
}
