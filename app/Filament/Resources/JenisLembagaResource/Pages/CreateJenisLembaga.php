<?php

namespace App\Filament\Resources\JenisLembagaResource\Pages;

use App\Filament\Resources\JenisLembagaResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateJenisLembaga extends CreateRecord
{
    protected static string $resource = JenisLembagaResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
