<?php

namespace App\Filament\Resources\KelBenihResource\Pages;

use App\Filament\Resources\KelBenihResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKelBenih extends EditRecord
{
    protected static string $resource = KelBenihResource::class;
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
