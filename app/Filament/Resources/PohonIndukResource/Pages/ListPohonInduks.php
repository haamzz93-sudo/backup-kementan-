<?php

namespace App\Filament\Resources\PohonIndukResource\Pages;

use App\Filament\Resources\PohonIndukResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPohonInduks extends ListRecords
{
    protected static string $resource = PohonIndukResource::class;

    protected static ?string $title = 'Inventaris Tanaman Induk';
    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
