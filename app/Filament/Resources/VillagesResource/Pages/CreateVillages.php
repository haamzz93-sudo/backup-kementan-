<?php

namespace App\Filament\Resources\VillagesResource\Pages;

use App\Filament\Resources\VillagesResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateVillages extends CreateRecord
{
    protected static string $resource = VillagesResource::class;
    protected static ?string $title = 'Buat Desa';
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
