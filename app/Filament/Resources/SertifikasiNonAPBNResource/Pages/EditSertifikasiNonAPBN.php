<?php

namespace App\Filament\Resources\SertifikasiNonAPBNResource\Pages;

use App\Filament\Resources\SertifikasiNonAPBNResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Pages\Actions\Action;

class EditSertifikasiNonAPBN extends EditRecord
{
    protected static string $resource = SertifikasiNonAPBNResource::class;

    protected function getActions(): array
    {
        return [
           // Actions\DeleteAction::make(),
        ];
    }
    
    protected function getFormActions(): array
    {
        return array_merge(parent::getFormActions(), [
            Action::make('save')->hidden(),
            Action::make('cancel')->hidden(),
        ]);
    }
}
