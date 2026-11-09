<?php

namespace App\Filament\Resources\ProvincesSebaranResource\Pages;

use App\Filament\Resources\ProvincesSebaranResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProvincesSebarans extends ListRecords
{
    protected static string $resource = ProvincesSebaranResource::class;
    protected static ?string $title = 'Sebaran Varietas';

    protected function getActions(): array
    {
        return [
            
          //  Actions\CreateAction::make(),
        ];
    }
}
