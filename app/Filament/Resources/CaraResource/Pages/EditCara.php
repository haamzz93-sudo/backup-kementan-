<?php

namespace App\Filament\Resources\CaraResource\Pages;

use App\Filament\Resources\CaraResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCara extends EditRecord
{
    protected static string $resource = CaraResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
