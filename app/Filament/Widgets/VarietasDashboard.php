<?php

namespace App\Filament\Widgets;

use Closure;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

use App\Models\ProdusenBenih;
use App\Models\JenisLembaga;
use App\Models\Provinces;
use App\Models\Varietas;
use App\Models\VarietasSanggah;
use App\Models\VarietasSebar;
use App\Models\LaporanTargetBenih;
use App\Models\LembagaSertifikasi;
use App\Models\LokasiProduksiDetail;
use App\Models\NomorRegistrasi;
use DB;

class VarietasDashboard extends BaseWidget
{
    protected static ?int $sort = 1;
    protected static ?string $heading = 'Varietas Terdaftar';
    protected int | string | array $columnSpan = [
        'md' => 2,
        'xl' => 3,
    ];
    protected function getTableQuery(): Builder
    {
        return Varietas::query();
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('komoditas.nama')->sortable()
            ->searchable(),
            Tables\Columns\TextColumn::make('nama_varietas')->sortable()
            ->searchable(),
            Tables\Columns\TextColumn::make('no_sk')->sortable()
            ->searchable(),
            Tables\Columns\TextColumn::make('pemohon.nama_produsen')->sortable()
            ->searchable(),
        ];
    }
}
