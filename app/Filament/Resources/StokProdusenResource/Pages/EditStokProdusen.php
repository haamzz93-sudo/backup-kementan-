<?php

namespace App\Filament\Resources\StokProdusenResource\Pages;

use App\Filament\Resources\StokProdusenResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStokProdusen extends EditRecord
{
    protected static string $resource = StokProdusenResource::class;
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
            Actions\Action::make('save')->hidden(),
            Actions\Action::make('cancel')->hidden(),
        ]);
    }
}
