<?php

namespace App\Filament\Resources\DataVarietasResource\Pages;

use App\Filament\Resources\DataVarietasResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDataVarietas extends EditRecord
{
    protected static string $resource = DataVarietasResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
