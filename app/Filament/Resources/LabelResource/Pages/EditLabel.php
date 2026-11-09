<?php

namespace App\Filament\Resources\LabelResource\Pages;

use App\Filament\Resources\LabelResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLabel extends EditRecord
{
    protected static string $resource = LabelResource::class;
    protected static ?string $title = 'Label Benih';
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
