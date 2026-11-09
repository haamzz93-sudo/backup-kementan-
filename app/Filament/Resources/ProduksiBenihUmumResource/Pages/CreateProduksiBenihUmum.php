<?php

namespace App\Filament\Resources\ProduksiBenihUmumResource\Pages;

use App\Filament\Resources\ProduksiBenihUmumResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProduksiBenihUmum extends CreateRecord
{
    protected static string $resource = ProduksiBenihUmumResource::class;
    protected static ?string $title = 'Buat Label Produksi Benih';
}
