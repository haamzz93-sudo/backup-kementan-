<?php

namespace App\Http\Livewire;

use App\Models\LaporanProduksiSwadaya;
use App\Exports\VarietasSanggahExport;
use App\Models\ExportProduksiNonAPBN;
use App\Models\Provinces;
use App\Models\Komoditas;
use App\Models\Varietas;
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

class NonApbn extends Component implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;

    protected function getTableQuery(): Builder
    {
        return LaporanProduksiSwadaya::with('produksiumum','satuan','childproduksiswadaya','komoditas','varietas')->orderBy('id','desc');
    }
    protected function getTableColumns(): array
    {
        
        return [
			Tables\Columns\TextColumn::make('produksiumum.kode_produsen')
                ->label("Kode Produsen")->searchable(),
				 Tables\Columns\TextColumn::make('produksiumum.jenis_produsen.nama_jenis')
                ->label("Jenis Produsen")->searchable(),
                Tables\Columns\TextColumn::make('produksiumum.nama_lembaga')
                ->label("Nama Produsen")->searchable(),
				Tables\Columns\TextColumn::make('produksiumum.provinces.name')
                ->label("Nama Provinsi"),
				Tables\Columns\TextColumn::make('produksiumum.regencies.name')
                ->label("Nama Kab/Kota"),
				Tables\Columns\TextColumn::make('produksiumum.districts.name')
                ->label("Nama Kecamatan"),
				Tables\Columns\TextColumn::make('produksiumum.villages.name')
                ->label("Nama Desa"),
				 Tables\Columns\TextColumn::make('produksiumum.alamat')
                ->label("Alamat Produsen"),
                Tables\Columns\TextColumn::make('komoditas.nama')
                ->label("Nama Komoditas")->searchable(),
                Tables\Columns\TextColumn::make('varietas.nama_varietas')
                ->label("Nama Varietas")->searchable(),
                Tables\Columns\TextColumn::make('satuan.nama_satuan')
                ->label("Satuan"),
				 Tables\Columns\TextColumn::make('produksi')
                ->label("Jumlah Produksi")
				->getStateUsing(function($record){
					return number_format(($record->childproduksiswadaya->sum('produksi_benih')),0,",",".");
				}),
				 Tables\Columns\TextColumn::make('salur')
                ->label("Jumlah Penyaluran")
				->getStateUsing(function($record){
					return number_format(($record->childproduksiswadaya->sum('salur_benih')),0,",",".");
				}),
				 Tables\Columns\TextColumn::make('stok')
                ->label("Stok Saat Ini")
				->getStateUsing(function($record){
					return number_format(($record->childproduksiswadaya->sum('produksi_benih')-$record->childproduksiswadaya->sum('salur_benih')),0,",",".");
				}),
                Tables\Columns\TextColumn::make('sumber_dana')
                ->label("Sumber Dana"),
        ];
    }
   protected function getTableFilters(): array
    {
        return [
             SelectFilter::make('provinsi')
                ->label('Provinsi')
                ->options(function () {
                    return Provinces::all()->pluck('name', 'id')->toArray();
                })
				->query(function (Builder $query, array $data) {
				if (!empty($data['value']))
				{
					$query->whereHas(
						'produksiumum',
						fn (Builder $query) => $query->where('provinces_id', '=', (int) $data['value'])
					);
				}
			}),
			SelectFilter::make('komoditas_id')
                ->label('Komoditas')
                ->options(function () {
                    return Komoditas::all()->pluck('nama', 'id')->toArray();
                })
        ];
    }
    protected function getTableFiltersLayout(): ?string
    {
        return Layout::AboveContent;
    }
    protected function getTableRecordsPerPageSelectOptions(): array
    {
        return [10, 25, 50, 100];
    }
    public function render()
    {
        return view('livewire.non-apbn')->layout('layouts.base');
    }
}
