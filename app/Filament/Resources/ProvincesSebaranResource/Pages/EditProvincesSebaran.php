<?php

namespace App\Filament\Resources\ProvincesSebaranResource\Pages;

use App\Filament\Resources\ProvincesSebaranResource;
use Filament\Pages\Actions;
use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\EditRecord;

class EditProvincesSebaran extends EditRecord
{
    protected static string $resource = ProvincesSebaranResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getActions(): array
    {
        return [
          //Actions\DeleteAction::make(),
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
