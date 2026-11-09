<?php

namespace App\Filament\Resources\KondisiResource\Pages;

use App\Filament\Resources\KondisiResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKondisis extends ListRecords
{
    protected static string $resource = KondisiResource::class;

    protected static ?string $title = 'Kondisi Sarpras';
    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
