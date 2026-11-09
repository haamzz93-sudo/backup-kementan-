<?php

namespace App\Filament\Resources\KepemilikanPohonIndukResource\Pages;

use App\Filament\Resources\KepemilikanPohonIndukResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKepemilikanPohonInduk extends EditRecord
{
    protected static string $resource = KepemilikanPohonIndukResource::class;
    protected static ?string $title = 'Ubah Pemilik Tanaman Induk';
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
