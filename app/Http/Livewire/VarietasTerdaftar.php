<?php

namespace App\Http\Livewire;

use App\Models\Varietas;
use App\Models\KelKomoditas;
use App\Models\Komoditas;
use App\Exports\VarietasExport;
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

class VarietasTerdaftar extends Component implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;

   
    protected function getTableQuery(): Builder
    {
        return Varietas::query()->orderBy('tahun_daftar','desc');
    }
    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('kode')
                ->label('Kode Varietas')
				->searchable(),
            Tables\Columns\TextColumn::make('no_sk')->label('No. SK')->searchable(),
            Tables\Columns\TextColumn::make('kelkomoditas.nama_kelompok')
                ->label('Kelompok Komoditas')
                ->searchable(),
            Tables\Columns\TextColumn::make('komoditas.nama')
                ->label('Komoditas')->searchable(),
            Tables\Columns\TextColumn::make('nama_varietas')
                ->label('Nama Varietas')->searchable(),
            Tables\Columns\TextColumn::make('pemohon.nama_produsen')
                ->label('Nama Pemohon')->searchable(),
            Tables\Columns\TextColumn::make('tahun_daftar')
                ->label('Tahun Daftar'),
            Tables\Columns\TextColumn::make('upload_produk')
                ->label('Produk')
                ->url(function ($record) {
                    return url('/storage') . "/" . $record->upload_produk;
                })
                ->getStateUsing(function () {
                    return "Klik Disini";
                }),
            Tables\Columns\TextColumn::make('upload_penciri')
                ->label('Penciri')
                ->url(function ($record) {
                    return url('/storage') . "/" . $record->upload_penciri;
                })
                ->getStateUsing(function () {
                    return "Klik Disini";
                }),
            Tables\Columns\TextColumn::make('upload_deskripsi')
                ->label('Deskripsi')
                ->url(function ($record) {
                    return url('/storage') . "/" . $record->upload_deskripsi;
                })
                ->getStateUsing(function () {
                    return "Klik Disini";
                }),
            Tables\Columns\TextColumn::make('wil_adaptasi')
                ->label('WIlayah Adaptasi')
                ->getStateUsing(function ($record) {
                    $tes = $record->wil_adaptasi;
                    if ($tes) {
                        foreach ($tes as $data) {
                            if ($data == "1") {
                                $dd[] = "Dataran Rendah";
                            } elseif ($data == "2") {
                                $dd[] = "Dataran Menengah";
                            } elseif ($data == "3") {
                                $dd[] = "Dataran Tinggi";
                            }
                        }
                        return $dd;
                    } else {
                        return "Belum Diisi";
                    }
                }),
            Tables\Columns\TextColumn::make('iklim')
                ->label('Iklim')
                ->getStateUsing(function ($record) {
                    $iklim = $record->iklim;
                    if ($iklim) {
                        foreach ($iklim as $ik) {
                            if ($ik == "1") {
                                $k[] = "Musim Hujan";
                            } elseif ($ik == "2") {
                                $k[] = "Musim Kemarau";
                            }
                        }
                        return $k;
                    } else {
                        return "Belum Diisi";
                    }
                }),
            Tables\Columns\TextColumn::make('asal')
                ->label('Asal')
                ->enum([
                    '' => 'Belum Diisi',
                    '1' => 'Introduksi',
                    '2' => 'Dalam Negeri',
                ])
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
            SelectFilter::make('tahun_daftar')
                ->label('Tahun Daftar')
                ->options(function () {
                    return Varietas::groupBy('tahun_daftar')->pluck('tahun_daftar', 'tahun_daftar')->toArray();
                }), // Set the selected value
            SelectFilter::make('wil_adaptasi')
                ->label('Wilayah Adaptasi')
                ->options(function () {
                    return ['["1","2","3"]' => 'Semua Ketinggian','["1"]' => 'Dataran Rendah', '["2"]' => 'Dataran Menengah', '["3"]' => 'Dataran Tinggi'];
                }), // Set the selected value
            SelectFilter::make('iklim')
                ->label('Iklim')
                ->options(function () {
                    return ['["1"]' => 'Musim Hujan', '["2"]' => 'Musim Kemarau', '["1","2"]' => 'Musim Hujan dan Kemarau'];
                }), // Set the selected value
            SelectFilter::make('asal')
                ->label('Asal')
                ->options(function () {
                    return ['1' => 'Introduksi', '2' => 'Dalam Negeri'];
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
        return view('livewire.varietas-terdaftar')->layout('layouts.base');
    }
}
