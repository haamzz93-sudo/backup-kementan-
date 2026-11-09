<?php

namespace App\Filament\Resources\DistrictsResource\Pages;

use App\Filament\Resources\DistrictsResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDistricts extends EditRecord
{
    protected static string $resource = DistrictsResource::class;
    protected static ?string $title = 'Edit Kecamatan';
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    
    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
