<?php

namespace App\Filament\Resources\ExportPohonIndukResource\Pages;

use App\Filament\Resources\ExportPohonIndukResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditExportPohonInduk extends EditRecord
{
    protected static string $resource = ExportPohonIndukResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
