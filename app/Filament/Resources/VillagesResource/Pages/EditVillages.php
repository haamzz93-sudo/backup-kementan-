<?php

namespace App\Filament\Resources\VillagesResource\Pages;

use App\Filament\Resources\VillagesResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVillages extends EditRecord
{
    protected static string $resource = VillagesResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected static ?string $title = 'Edit Desa';
    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
