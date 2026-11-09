<?php

namespace App\Filament\Resources\DistrictsResource\Pages;

use App\Filament\Resources\DistrictsResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDistricts extends ListRecords
{
    protected static string $resource = DistrictsResource::class;
    protected static ?string $title = 'Database Kecamatan';
    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Tambah Data'),
        ];
    }
}
