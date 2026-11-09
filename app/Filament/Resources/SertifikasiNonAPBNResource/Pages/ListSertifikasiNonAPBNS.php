<?php

namespace App\Filament\Resources\SertifikasiNonAPBNResource\Pages;

use App\Filament\Resources\SertifikasiNonAPBNResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSertifikasiNonAPBNS extends ListRecords
{
    protected static string $resource = SertifikasiNonAPBNResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
