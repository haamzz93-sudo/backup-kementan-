<?php

namespace App\Filament\Resources\ProduksiBenihUmumResource\Pages;

use App\Filament\Resources\ProduksiBenihUmumResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

use Filament\Pages\Actions\Action;
class EditProduksiBenihUmum extends EditRecord
{
    protected static string $resource = ProduksiBenihUmumResource::class;

    protected static ?string $title = 'Ubah Data Label Produksi Benih';
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
