<?php

namespace App\Filament\Resources\ExportVarietasMasaSanggahResource\Pages;

use App\Filament\Resources\ExportVarietasMasaSanggahResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditExportVarietasMasaSanggah extends EditRecord
{
    protected static string $resource = ExportVarietasMasaSanggahResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
