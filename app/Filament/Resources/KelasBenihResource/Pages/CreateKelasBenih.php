<?php

namespace App\Filament\Resources\KelasBenihResource\Pages;

use App\Filament\Resources\KelasBenihResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateKelasBenih extends CreateRecord
{
    protected static string $resource = KelasBenihResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
