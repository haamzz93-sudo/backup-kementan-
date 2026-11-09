<?php

namespace App\Filament\Resources\VarietasResource\Pages;

use App\Filament\Resources\VarietasResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVarietas extends EditRecord
{
    protected static string $resource = VarietasResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
