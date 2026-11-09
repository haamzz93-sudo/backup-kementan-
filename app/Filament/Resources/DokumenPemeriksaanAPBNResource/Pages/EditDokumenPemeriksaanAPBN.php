<?php

namespace App\Filament\Resources\DokumenPemeriksaanAPBNResource\Pages;

use App\Filament\Resources\DokumenPemeriksaanAPBNResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDokumenPemeriksaanAPBN extends EditRecord
{
    protected static string $resource = DokumenPemeriksaanAPBNResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl;
    }

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
