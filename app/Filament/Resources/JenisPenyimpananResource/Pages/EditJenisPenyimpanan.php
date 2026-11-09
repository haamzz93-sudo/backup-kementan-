<?php

namespace App\Filament\Resources\JenisPenyimpananResource\Pages;

use App\Filament\Resources\JenisPenyimpananResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditJenisPenyimpanan extends EditRecord
{
    protected static string $resource = JenisPenyimpananResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
