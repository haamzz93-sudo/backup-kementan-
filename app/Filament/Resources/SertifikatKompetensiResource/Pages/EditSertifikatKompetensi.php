<?php

namespace App\Filament\Resources\SertifikatKompetensiResource\Pages;

use App\Filament\Resources\SertifikatKompetensiResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSertifikatKompetensi extends EditRecord
{
    protected static string $resource = SertifikatKompetensiResource::class;

    protected function getActions(): array
    {
        return [
            //Actions\DeleteAction::make(),
        ];
    }
    protected function getFormActions(): array
    {
        return array_merge(parent::getFormActions(), [
            Actions\Action::make('save')->hidden(),
            Actions\Action::make('cancel')->hidden(),
        ]);
    }
}
