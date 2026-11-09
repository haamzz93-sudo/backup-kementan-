<?php

namespace App\Filament\Resources\PenentuanLabelResource\Pages;

use App\Filament\Resources\PenentuanLabelResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPenentuanLabel extends EditRecord
{
    protected static string $resource = PenentuanLabelResource::class;
    protected static ?string $title = 'Penentuan Label';
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
