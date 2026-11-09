<?php

namespace App\Filament\Resources\VillagesResource\Pages;

use App\Filament\Resources\VillagesResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVillages extends ListRecords
{
    protected static string $resource = VillagesResource::class;
    protected static ?string $title = 'Database Desa';
    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Tambah Data'),
        ];
    }
}
