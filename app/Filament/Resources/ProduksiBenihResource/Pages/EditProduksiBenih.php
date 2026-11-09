<?php

namespace App\Filament\Resources\ProduksiBenihResource\Pages;

use App\Filament\Resources\ProduksiBenihResource;
use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\EditRecord;

class EditProduksiBenih extends EditRecord
{
    protected static string $resource = ProduksiBenihResource::class;
    protected static ?string $title = 'Laporan Produksi Benih';
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function getActions(): array
    {
        return [
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
