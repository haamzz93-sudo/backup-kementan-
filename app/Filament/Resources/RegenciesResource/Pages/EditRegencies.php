<?php

namespace App\Filament\Resources\RegenciesResource\Pages;

use App\Filament\Resources\RegenciesResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRegencies extends EditRecord
{
    protected static string $resource = RegenciesResource::class;
    protected static ?string $title = 'Edit Kab/Kota';
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
