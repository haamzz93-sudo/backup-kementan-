<?php

namespace App\Filament\Resources\LembagaSertifikasiResource\Pages;

use App\Filament\Resources\LembagaSertifikasiResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;

class ListLembagaSertifikasis extends ListRecords
{
    protected static string $resource = LembagaSertifikasiResource::class;
    
    protected static ?string $title = 'Lembaga Sertifikasi';
    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery();
    }
    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
