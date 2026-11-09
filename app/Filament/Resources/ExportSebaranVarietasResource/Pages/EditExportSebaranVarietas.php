<?php

namespace App\Filament\Resources\ExportSebaranVarietasResource\Pages;

use App\Filament\Resources\ExportSebaranVarietasResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditExportSebaranVarietas extends EditRecord
{
    protected static string $resource = ExportSebaranVarietasResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
