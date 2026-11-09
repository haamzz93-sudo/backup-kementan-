<?php

namespace App\Filament\Resources\KelKomoditasResource\Pages;

use App\Filament\Resources\KelKomoditasResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKelKomoditas extends EditRecord
{
    protected static string $resource = KelKomoditasResource::class;
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
