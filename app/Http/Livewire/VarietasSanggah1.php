<?php

namespace App\Http\Livewire;

use App\Models\VarietasSanggah;
use App\Models\KelKomoditas;
use App\Models\Komoditas;
use App\Exports\VarietasSanggahExport;
use DB;
use Filament\Tables;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Filament\Tables\Filters\SelectFilter;
use Livewire\Component;
use Filament\Tables\Filters\Layout;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromCollection;

class VarietasSanggah1 extends Component implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;
    public $selectedKomkelId;
    public $selectedKomoditasId;
    public $filterOptions = [];

    public function mount()
    {
        $this->filterOptions['komkel_id'] = KelKomoditas::all()->pluck('nama_kelompok', 'id')->toArray();
        $this->filterOptions['komoditas_id'] = Komoditas::all()->pluck('nama', 'id')->toArray();
    }
    protected function getTableQuery(): Builder
    {
        return  VarietasSanggah::whereRaw('tanggal_entri >= DATE_SUB(NOW(), INTERVAL 1 MONTH)')
        ->whereRaw('tanggal_entri < LAST_DAY(DATE_ADD(NOW(), INTERVAL 1 MONTH))');
;
    }
    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('tanggal_entri')->label('Tanggal Lapor')->sortable(),
            Tables\Columns\TextColumn::make('kelkomoditas.nama_kelompok')->label('Kelompok Komoditas')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('komoditas.nama')->label('Nama Komoditas')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('nama_varietas')->label('Nama Varietas')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('pemohon.nama_produsen')->label('Nama Pemohon')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('upload_deskripsi')->label('Deskripsi')
			->getStateUsing(function($record){
				if($record->upload_deskripsi){
					return "Klik Disini";
				}else{
					return "Belum Diupload";
				}
			})
            ->url(function ($record) {
                return asset('storage/' . $record->upload_deskripsi);
            })->openUrlInNewTab(),
            Tables\Columns\TextColumn::make('pemulia')->label('Pemulia')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('peneliti')->label('Peneliti')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('verifikasi')
                ->getStateUsing(
                    function ($record) {
                        $now = date("Y-m-d");
                        $time = strtotime($record->tanggal_entri);
                        $final = date("Y-m-d", strtotime("+1 month", $time));
                        if ($record->verifikasi == 2) {
                            return "Tersanggah";
                        } else {
                            if ($final <= $now) {
                                return "Terverifikasi";
                            } else {
                                return "Diajukan";
                            }
                        }
                    }
                )->sortable()->searchable(),
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
    public function exportToExcel()
    {
        $now = date('Y-m-d');
        $query = VarietasSanggah::whereDate('tanggal_entri', '>', $now);

        if ($this->selectedKomkelId) {
            $query->where('komkel_id', $this->selectedKomkelId);
        }

        if ($this->selectedKomoditasId) {
            $query->where('komoditas_id', $this->selectedKomoditasId);
        }

        $data = $query->get();

        return Excel::download(new VarietasSanggahExport($data), 'varietassanggah.xlsx');
    }
    public function render()
    {
        return view('livewire.varietas-sanggah', [
            'filterOptions' => $this->filterOptions,
        ])->layout('layouts.base');
    }
}
