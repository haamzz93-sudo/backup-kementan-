<?php

namespace App\Http\Livewire;

use App\Models\ProvincesSebaran;
use App\Models\Regencies;
use App\Models\KelKomoditas;
use App\Models\Komoditas;
use App\Models\Varietas;
use App\Models\VarietasSebar;
use DB;
use Filament\Tables;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Filament\Tables\Filters\SelectFilter;
use Livewire\Component;
use Filament\Tables\Filters\Layout;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
class SebaranVarietas extends Component implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;

    protected function getTableQuery(): Builder
    {
        return VarietasSebar::groupBy('varietas_id','regencies_id')->orderBy('id','desc');
    }
    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('provinces.name')->label('Provinsi'),
            Tables\Columns\TextColumn::make('regencies.name')->label('Kabupaten/Kota')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('kelkomoditas.nama_kelompok')->label('Nama Kelompok Komoditas')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('komoditas.nama')->label('Nama Komoditas')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('varietas.nama_varietas')->label('Nama Varietas')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('tanggal_lapor_sebar')->label('Tanggal Lapor Terakhir')
            ->getStateUsing(function($record){
                $results = DB::table('varietas_sebar')
                    ->select(DB::raw('MAX(tanggal_lapor_sebar) as max'))
                    ->where([['varietas_id', $record->varietas_id],['regencies_id', $record->regencies_id]])
                    ->first();
                    return $results->max;
            }),
            Tables\Columns\TextColumn::make('luas_sebar')->label('Luas Sebaran')
            ->getStateUsing(function($record){
                $jumlah = DB::table('varietas_sebar')
                    ->select(DB::raw('SUM(luas_sebar) as total_luas_sebar'))
                    ->where([['varietas_id', $record->varietas_id],['regencies_id', $record->regencies_id]])
                    ->whereIn('tanggal_lapor_sebar', function ($query) use ($record) {
                        $query->select(DB::raw('MAX(tanggal_lapor_sebar) as max_tanggal'))
                            ->from('varietas_sebar')
                            ->where([['varietas_id', $record->varietas_id],['regencies_id', $record->regencies_id]]);
                    })
                    ->first();
                return $jumlah->total_luas_sebar." Ha";
                
            }),
            
        ];
    }
    protected function getTableRecordsPerPageSelectOptions(): array
    {
        return [10, 25, 50, 100];
    }
    protected function getTableFilters(): array
    {
        return [
            SelectFilter::make('komkel_id')
                ->label('Kelompok Komoditas')
                ->options(function () {
                    return KelKomoditas::all()->pluck('nama_kelompok', 'id')->toArray();
                }), // Set the selected value
            SelectFilter::make('komoditas_id')
                ->label('Komoditas')
                ->options(function () {
                    return Komoditas::all()->pluck('nama', 'id')->toArray();
                }), // Set the selected value
            SelectFilter::make('provinces_id')
                ->label('Provinsi')
                ->options(function () {
                    return ProvincesSebaran::all()->pluck('name', 'id')->toArray();
                }), // Set the selected value
             SelectFilter::make('regencies_id')
                ->label('Kabupaten/Kota')
                ->options(function () {
                    return Regencies::all()->pluck('name', 'id')->toArray();
                }), // Set the selected value
        ];
    }
    protected function getTableFiltersLayout(): ?string
    {
        return Layout::AboveContent;
    }
    public function isTableSearchable(): bool
    {
        return true;
    }
    public function render()
    {
        return view('livewire.sebaran-varietas')->layout('layouts.base');
    }
}
