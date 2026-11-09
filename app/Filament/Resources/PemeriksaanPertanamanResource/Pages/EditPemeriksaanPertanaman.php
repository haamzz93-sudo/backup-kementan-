<?php

namespace App\Filament\Resources\PemeriksaanPertanamanResource\Pages;

use App\Filament\Resources\PemeriksaanPertanamanResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPemeriksaanPertanaman extends EditRecord
{
    protected static string $resource = PemeriksaanPertanamanResource::class;
    protected static ?string $title = 'Pemeriksaan Pertanaman';
    protected function getActions(): array
    {
        return [
           // Actions\DeleteAction::make(),
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
