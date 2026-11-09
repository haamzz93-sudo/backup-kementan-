<?php

namespace App\Filament\Resources\ExportLembagaResource\Pages;

use App\Filament\Resources\ExportLembagaResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditExportLembaga extends EditRecord
{
    protected static string $resource = ExportLembagaResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
