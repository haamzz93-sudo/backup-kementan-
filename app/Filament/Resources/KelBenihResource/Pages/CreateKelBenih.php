<?php

namespace App\Filament\Resources\KelBenihResource\Pages;

use App\Filament\Resources\KelBenihResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateKelBenih extends CreateRecord
{
    protected static string $resource = KelBenihResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
