<?php

namespace App\Filament\Resources\TargetBenihResource\Pages;

use App\Filament\Resources\TargetBenihResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTargetBenihs extends ListRecords
{
    protected static string $resource = TargetBenihResource::class;
    protected static ?string $title = 'Laporan Target Benih';
    protected function getActions(): array
    {
        return [
            //Actions\CreateAction::make(),
        ];
    }
}
