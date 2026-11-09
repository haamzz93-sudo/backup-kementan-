<?php

namespace App\Filament\Resources\NomorRegistrasiResource\Pages;

use App\Filament\Resources\NomorRegistrasiResource;
use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\EditRecord;

class EditNomorRegistrasi extends EditRecord
{
    protected static string $resource = NomorRegistrasiResource::class;
    protected static ?string $title = 'Ubah Laporan Kondisi Tanaman Induk';
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
