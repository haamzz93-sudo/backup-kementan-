<?php

namespace App\Filament\Resources\JenisPenyimpananResource\Pages;

use App\Filament\Resources\JenisPenyimpananResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateJenisPenyimpanan extends CreateRecord
{
    protected static string $resource = JenisPenyimpananResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
