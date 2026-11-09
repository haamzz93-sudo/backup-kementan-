<?php

namespace App\Filament\Resources\SertifikatKompetensiResource\Pages;

use App\Filament\Resources\SertifikatKompetensiResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSertifikatKompetensis extends ListRecords
{
    protected static string $resource = SertifikatKompetensiResource::class;

    protected function getActions(): array
    {
        return [
            //Actions\CreateAction::make(),
        ];
    }
}
