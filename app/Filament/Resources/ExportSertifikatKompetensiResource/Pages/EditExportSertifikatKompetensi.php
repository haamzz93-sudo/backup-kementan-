<?php

namespace App\Filament\Resources\ExportSertifikatKompetensiResource\Pages;

use App\Filament\Resources\ExportSertifikatKompetensiResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditExportSertifikatKompetensi extends EditRecord
{
    protected static string $resource = ExportSertifikatKompetensiResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
