<?php

namespace App\Filament\Resources\KelBenihResource\Pages;

use App\Filament\Resources\KelBenihResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKelBenihs extends ListRecords
{
    protected static string $resource = KelBenihResource::class;
    
    protected static ?string $title = 'Kelompok Benih';

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
