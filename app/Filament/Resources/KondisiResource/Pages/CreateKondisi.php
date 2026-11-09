<?php

namespace App\Filament\Resources\KondisiResource\Pages;

use App\Filament\Resources\KondisiResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateKondisi extends CreateRecord
{
    protected static string $resource = KondisiResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
