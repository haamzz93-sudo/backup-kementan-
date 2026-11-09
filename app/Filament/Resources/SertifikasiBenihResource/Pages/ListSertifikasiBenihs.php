<?php

namespace App\Filament\Resources\SertifikasiBenihResource\Pages;

use App\Filament\Resources\SertifikasiBenihResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
class ListSertifikasiBenihs extends ListRecords
{
    protected static string $resource = SertifikasiBenihResource::class;

    protected function getActions(): array
    {
        return [
           // Actions\CreateAction::make(),
        ];
    }
}
