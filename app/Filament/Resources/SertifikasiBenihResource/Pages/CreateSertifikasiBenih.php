<?php

namespace App\Filament\Resources\SertifikasiBenihResource\Pages;

use App\Filament\Resources\SertifikasiBenihResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSertifikasiBenih extends CreateRecord
{
    protected static string $resource = SertifikasiBenihResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
