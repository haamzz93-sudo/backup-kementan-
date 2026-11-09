<?php

namespace App\Filament\Resources\ProduksiBenihResource\Pages;

use App\Filament\Resources\ProduksiBenihResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProduksiBenih extends CreateRecord
{
    protected static string $resource = ProduksiBenihResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    



}
