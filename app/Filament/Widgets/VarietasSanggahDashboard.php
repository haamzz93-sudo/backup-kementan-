<?php

namespace App\Filament\Widgets;

use App\Models\VarietasSanggah;
use Closure;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class VarietasSanggahDashboard extends BaseWidget
{
    protected static ?int $sort = 2;
    
    protected static ?string $heading = 'Masa Sanggah Pendaftaran Varietas';
    protected int | string | array $columnSpan = [
        'md' => 2,
        'xl' => 3,
    ];
    protected function getTableQuery(): Builder
    {
        return VarietasSanggah::query();
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
