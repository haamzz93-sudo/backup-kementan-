<?php

namespace App\Filament\Resources\JenisLembagaResource\Pages;

use App\Filament\Resources\JenisLembagaResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListJenisLembagas extends ListRecords
{
    protected static string $resource = JenisLembagaResource::class;
    protected static ?string $title = 'Jenis Lembaga';
    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
