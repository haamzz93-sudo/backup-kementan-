<?php

namespace App\Filament\Resources\FormLabelResource\Pages;

use App\Filament\Resources\FormLabelResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateFormLabel extends CreateRecord
{
    protected static string $resource = FormLabelResource::class;
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
