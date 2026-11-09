<?php

namespace App\Filament\Resources\PemeriksaanPertanamanResource\Pages;

use App\Filament\Resources\PemeriksaanPertanamanResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPemeriksaanPertanamen extends ListRecords
{
    protected static string $resource = PemeriksaanPertanamanResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
