<?php

namespace App\Filament\Resources\KepemilikanPohonIndukResource\Pages;

use App\Filament\Resources\KepemilikanPohonIndukResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateKepemilikanPohonInduk extends CreateRecord
{
    protected static string $resource = KepemilikanPohonIndukResource::class;
    protected static ?string $title = 'Buat Pemilik Tanaman Induk';
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
