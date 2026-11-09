<?php

namespace App\Filament\Resources\PemohonResource\Pages;

use App\Filament\Resources\PemohonResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPemohons extends ListRecords
{
    protected static string $resource = PemohonResource::class;

    protected static ?string $title = 'Pemohon Pendaftaran Varietas';
    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
