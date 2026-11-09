<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Provinces;
use App\Models\ProdusenBenih;
use App\Models\SertifikatKompetensi;
use DB;
use Filament\Tables;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Layout;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromCollection;

class Serkom extends Component implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;
    public $selectedProvincesId;
    public $filterOptions = [];

    public function mount()
    {
        $this->filterOptions['provinces_id'] = Provinces::all()->pluck('name', 'id')->toArray();
    }
    protected function getTableQuery(): Builder
    {
        return SertifikatKompetensi::with('produsenbenih','perpanjangansmm')->orderBy('id','desc');
    }
    protected function getTableColumns(): array
    {
        
        return [
            Tables\Columns\TextColumn::make('no_serti')
            ->label('Nomor Sertifikat')
            ->searchable(),
            Tables\Columns\TextColumn::make('produsenbenih.nama_lembaga')->label('Nama Lembaga'),
            Tables\Columns\TextColumn::make('produsenbenih.provinces.name')->label('Provinsi'),
            Tables\Columns\TextColumn::make('produsenbenih.alamat')->label('Alamat'),
            Tables\Columns\TextColumn::make('jenis')
            ->label('Jenis Kompetensi')
            ->getStateUsing(function($record){
                $col = collect($record->jenis_kompetensi);
                $array = $col->toArray();
                $string = implode(', ', $array);
                return $string;
            }),
            Tables\Columns\TextColumn::make('tgl_awal')->label('Tanggal Awal Berlaku Sertifikat'),
            Tables\Columns\TextColumn::make('akhir')
            ->label('Tanggal Berakhir Berlaku Sertifikat')
            ->getStateUsing(function($record){
                $tgl_akhir = $record->tgl_akhir;
                $panjang =  $record->perpanjangansmm->where('child_smm_id',$record->id)->sortByDesc('tgl_perpanjangan')->first();
                if($panjang){
                $tglakhirp = $panjang->tgl_berlaku;
                    return $tglakhirp;
                }else{
                    return $tgl_akhir;
                }
            }),
            Tables\Columns\TextColumn::make('panjang')
            ->label('Banyaknya Perpanjangan Sertifikat')
            ->getStateUsing(function($record){
                if($record->perpanjangansmm->count()>0){
                    return $record->perpanjangansmm->count()." Kali";
                }else{
                    return "Belum Pernah Diperpanjang";
                }
                
            }),
            Tables\Columns\TextColumn::make('stat')
            ->label('Status')
            ->getStateUsing(function($record){
                $now = date("Y-m-d");
                $tgl_akhir = $record->tgl_akhir;
                $panjang =  $record->perpanjangansmm->where('child_smm_id',$record->id)->sortByDesc('tgl_perpanjangan')->first();
                if($panjang){
                $tglakhirp = $panjang->tgl_berlaku;
                    $akhir=$tglakhirp;
                }else{
                    $akhir=$tgl_akhir;
                }
                if($now>$akhir){
                    return "Tidak Berlaku";
                }else{
                    return "Berlaku";
                }
                
            }),
        ];
    }
     protected function getTableFilters(): array
    {
        return [
            SelectFilter::make('provinces_id')
                ->label('Provinsi')
                ->options(function () {
                    return Provinces::all()->pluck('name', 'id')->toArray();
                })
                ->query(function (Builder $query, array $data) {
                    if (!empty($data['value']))
                    {
                        $query->whereHas(
                            'produsenbenih',fn (Builder $query) => $query->where('provinces_id', '=', (int) $data['value'])
                            );
                    }
                }),
                
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
        return view('livewire.serkom')->layout('layouts.base');
    }
}
