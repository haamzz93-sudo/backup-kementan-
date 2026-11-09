<?php

namespace App\Filament\Resources\TargetSalurResource\Pages;

use App\Filament\Resources\TargetSalurResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTargetSalurs extends ListRecords
{
    protected static string $resource = TargetSalurResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
