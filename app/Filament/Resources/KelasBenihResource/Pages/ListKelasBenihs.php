<?php

namespace App\Filament\Resources\KelasBenihResource\Pages;

use App\Filament\Resources\KelasBenihResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKelasBenihs extends ListRecords
{
    protected static string $resource = KelasBenihResource::class;

    protected static ?string $title = 'Kelas Benih';
    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
