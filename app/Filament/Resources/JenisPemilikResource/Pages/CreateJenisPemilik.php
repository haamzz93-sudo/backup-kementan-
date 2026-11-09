<?php

namespace App\Filament\Resources\JenisPemilikResource\Pages;

use App\Filament\Resources\JenisPemilikResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateJenisPemilik extends CreateRecord
{
    protected static string $resource = JenisPemilikResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
