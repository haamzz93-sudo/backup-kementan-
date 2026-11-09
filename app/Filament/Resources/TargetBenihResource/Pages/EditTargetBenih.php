<?php

namespace App\Filament\Resources\TargetBenihResource\Pages;

use App\Filament\Resources\TargetBenihResource;
use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\EditRecord;

class EditTargetBenih extends EditRecord
{
    protected static string $resource = TargetBenihResource::class;
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
