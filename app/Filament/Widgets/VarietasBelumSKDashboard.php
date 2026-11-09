<?php

namespace App\Filament\Widgets;

use App\Models\Varietas;
use Closure;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class VarietasBelumSKDashboard extends BaseWidget
{
    protected static ?int $sort = 3;
    protected static ?string $heading = 'Pendaftaran Varietas Belum SK';
    protected int | string | array $columnSpan = [
        'md' => 2,
        'xl' => 3,
    ];
    protected function getTableQuery(): Builder
    {
        return Varietas::query()->whereNull('no_sk');
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('pemohon.nama_produsen')
            ->sortable()
            ->searchable(),
            Tables\Columns\TextColumn::make('nama_varietas')
            ->sortable()
            ->searchable(),
            Tables\Columns\TextColumn::make('tanggal_entri'),
        ];
    }
}
