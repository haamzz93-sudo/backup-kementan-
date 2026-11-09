<?php

namespace App\Filament\Resources\KepemilikanPohonIndukResource\Pages;

use App\Filament\Resources\KepemilikanPohonIndukResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKepemilikanPohonInduks extends ListRecords
{
    protected static string $resource = KepemilikanPohonIndukResource::class;
    protected static ?string $title = 'Pemilik Tanaman Induk';
    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
