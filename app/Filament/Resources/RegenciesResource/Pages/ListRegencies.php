<?php

namespace App\Filament\Resources\RegenciesResource\Pages;

use App\Filament\Resources\RegenciesResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRegencies extends ListRecords
{
    protected static string $resource = RegenciesResource::class;
    protected static ?string $title = 'Database Kab/Kota';
    
    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Tambah Data'),
        ];
    }
}
