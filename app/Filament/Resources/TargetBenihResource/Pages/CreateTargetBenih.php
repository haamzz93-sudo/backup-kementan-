<?php

namespace App\Filament\Resources\TargetBenihResource\Pages;

use App\Filament\Resources\TargetBenihResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTargetBenih extends CreateRecord
{
    protected static string $resource = TargetBenihResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
