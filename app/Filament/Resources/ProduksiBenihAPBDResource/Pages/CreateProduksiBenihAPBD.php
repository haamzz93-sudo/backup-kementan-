<?php

namespace App\Filament\Resources\ProduksiBenihAPBDResource\Pages;

use App\Filament\Resources\ProduksiBenihAPBDResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProduksiBenihAPBD extends CreateRecord
{
    protected static string $resource = ProduksiBenihAPBDResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
