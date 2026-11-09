<?php

namespace App\Filament\Resources\KelasBenihResource\Pages;

use App\Filament\Resources\KelasBenihResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKelasBenih extends EditRecord
{
    protected static string $resource = KelasBenihResource::class;
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
