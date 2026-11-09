<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Provinces;
use App\Models\ProdusenBenih;
use App\Models\Regencies;
use App\Models\Districts;
use App\Models\LembagaSertifikasi;
use App\Models\Villages;
use App\Models\User;
use App\Models\JenisLembaga;
use App\Models\JenisProdusen;
use App\Models\SaranaLembaga;
use App\Models\SertifikatKompetensi;
use App\Models\LokasiGudangDetail;
use App\Models\LokasiProduksiDetail;
use DB;
use Filament\Tables;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Layout;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromCollection;

class Produsen extends Component implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;
    public $selectedKomkelId;
    public $selectedKomoditasId;
    public $filterOptions = [];

    public function mount()
    {
        
    }
    protected function getTableQuery(): Builder
    {
        return ProdusenBenih::whereNotIn('jenis_lembaga_id', [1,7])->orderBy('id','desc');
    }
    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\Layout\Split::make([
                Tables\Columns\Layout\Stack::make([
                    Tables\Columns\TextColumn::make('kode_produsen')
                        ->label('Kode Produsen')
                        ->sortable()
                        ->searchable()
                        ->getStateUsing( function ($record){
                            $kp = $record->kode_produsen;
                            return "Kode Produsen: ".$kp;
                        })->searchable(),
                    Tables\Columns\TextColumn::make('nama_lembaga')
                        ->label('Nama Lembaga')
                        ->searchable()
                        ->sortable(),
                    Tables\Columns\TextColumn::make('jenis_lembaga.nama_jenis')
                        ->label('Status Lembaga Produsen/Pengedar')
                        ->sortable()
                        ->searchable()
                        ->size('sm')
                        ->color('secondary')
                        ->alignLeft(),
                    Tables\Columns\TextColumn::make('jenis_produsen.nama_jenis')
                        ->label('Jenis Produsen/Pengedar')
                        ->sortable()
                        ->searchable()
                        ->size('sm')
                        ->color('secondary')
                        ->alignLeft(),
            
                ]),
                Tables\Columns\Layout\Stack::make([
                    Tables\Columns\TextColumn::make('prv')
                        ->getStateUsing(function($record) {
                            return "Provinsi : ";
                    }),
                    Tables\Columns\TextColumn::make('provinces.name')
                        ->label('Nama Provinsi')
                        ->searchable()
                        ->alignLeft()
                        ->size('sm')
                        ->color('secondary'),

                    Tables\Columns\TextColumn::make('kb')
                        ->getStateUsing(function($record) {
                            return "Kabupaten/Kota : ";
                    }),
                    Tables\Columns\TextColumn::make('regencies.name')
                        ->label('Nama Kabupaten/Kota')
                        ->searchable()
                        ->alignLeft()
                        ->size('sm')
                        ->color('secondary'),
                    Tables\Columns\TextColumn::make('kc')
                        ->getStateUsing(function($record) {
                            return "Kecamatan : ";
                    }),
                    Tables\Columns\TextColumn::make('districts.name')
                        ->label('Nama Kecamatan')
                        ->searchable()
                        ->alignLeft()
                        ->size('sm')
                        ->color('secondary'),
                    Tables\Columns\TextColumn::make('ds')
                        ->getStateUsing(function($record) {
                            return "Desa : ";
                    }),
                    Tables\Columns\TextColumn::make('villages.name')
                        ->label('Nama Desa/Kelurahan')
                        ->sortable()
                        ->searchable()
                        ->alignLeft()
                        ->size('sm')
                        ->color('secondary'),
            
                ]),
                Tables\Columns\Layout\Stack::make([
                    Tables\Columns\TextColumn::make('tes')
                        ->getStateUsing(function($record) {
                            return "Nama Kepala Lembaga : ";
                    }),
                    Tables\Columns\TextColumn::make('nama_kepala')
                        ->label('Nama Kepala Lembaga')
                        ->alignLeft()
                        ->searchable()
                        ->getStateUsing( function ($record){
                            $kepala = $record->nama_kepala;
                            return $kepala;
                        }),
                    Tables\Columns\TextColumn::make('no_telp')
                        ->label('No. Telepon')
                        ->size('sm')
                        ->color('secondary')
                        ->alignLeft()
                        ->getStateUsing( function ($record){
                            $tel = $record->no_telp;
                            return "No. Telepon: ".$tel;
                        }),
                    Tables\Columns\TextColumn::make('alamat')
                        ->label('Alamat')
                        ->size('sm')
                        ->color('secondary')
                        ->alignLeft()
                        ->getStateUsing( function ($record){
                            $alamat = $record->alamat;
                            return "Alamat: ".$alamat;
                        }),
                    Tables\Columns\TextColumn::make('rt')
                        ->label('RT')
                        ->size('sm')
                        ->color('secondary')
                        ->alignLeft()
                        ->getStateUsing( function ($record){
                            $rt = $record->rt;
                            return "RT: ".$rt;
                        }),
                    Tables\Columns\TextColumn::make('rw')
                        ->label('RW')
                        ->size('sm')
                        ->color('secondary')
                        ->alignLeft()
                        ->getStateUsing( function ($record){
                            $rw = $record->rw;
                            return "RW: ".$rw;
                        }), 
                    Tables\Columns\TextColumn::make('kodepos')
                        ->label('Kode Pos')
                        ->size('sm')
                        ->color('secondary')
                        ->alignLeft()
                    ->getStateUsing( function ($record){
                        $pos = $record->kodepos;
                        return "Kode Pos: ".$pos;
                    }),
                    
                ]),
                Tables\Columns\Layout\Stack::make([
                    Tables\Columns\TextColumn::make('link')
                        ->getStateUsing(function($record) {
                            return "Lihat Detail Lembaga";
                    })
                    ->url(function($record){
                        return "/detail-produsen/$record->id";
                    })
                    ->openUrlInNewTab(),
                    
                    
                ]),
            ]),
        ];
    }
    protected function getTableFilters(): array
    {
        return [
            SelectFilter::make('provinces_id')
                ->label('Provinsi')
                ->options(function () {
                    return Provinces::all()->pluck('name', 'id')->toArray();
                }), // Set the selected value
            SelectFilter::make('jenis_lembaga_id')
                ->label('Status Lembaga Produsen/Pengedar')
                ->options(function () {
                    return JenisLembaga::whereNotIn('id', [1,7])->pluck('nama_jenis', 'id')->toArray();
                }), // Set the selected value
                SelectFilter::make('jenis_produsen_id')
                ->label('Jenis Produsen/Pengedar')
                ->options(function () {
                    return JenisProdusen::all()->pluck('nama_jenis', 'id')->toArray();
                }), // Set the selected value
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
        return view('livewire.produsen')->layout('layouts.base');
    }
}
