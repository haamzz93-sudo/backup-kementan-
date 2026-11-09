<?php

namespace App\Filament\Resources\FormLabelResource\Pages;

use App\Filament\Resources\FormLabelResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFormLabels extends ListRecords
{
    protected static string $resource = FormLabelResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
