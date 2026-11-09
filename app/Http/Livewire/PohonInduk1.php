<?php

namespace App\Http\Livewire;

use App\Models\JenisPemilik;
use App\Models\KepemilikanPohonInduk;
use App\Models\Provinces;
use App\Models\KelasBenih;
use App\Models\PohonInduk;
use App\Models\ProdusenBenih;
use App\Models\KelKomoditas;
use App\Models\Komoditas;
use App\Models\Varietas;
use App\Models\NomorRegistrasi;
use App\Models\KondisiPohon;
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

class PohonInduk1 extends Component implements Tables\Contracts\HasTable
{

    use Tables\Concerns\InteractsWithTable;

    protected function getTableQuery(): Builder
    {
        return NomorRegistrasi::has('pohoninduk')->orderBy('id','desc');
    }
    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('lemser')
                ->label('Lembaga Sertifikasi')
                ->getStateUsing(function ($record) {

                    return $record->lembagasertifikasi->nama_lembaga;
                }),
            Tables\Columns\TextColumn::make('pemilik_pohon_id')
                ->label('Pemilik')
                ->getStateUsing(function ($record) {
                    return $record->pemilikpohon->nama_lembaga;
                }),
            Tables\Columns\TextColumn::make('no_registrasi')
                ->label('Nomor Induk')
                ->getStateUsing(function ($record) {
                    if (null !== $record->no_registrasi) {
                        return $record->no_registrasi;
                    } else {
                        return "Tidak digenerate sistem";
                    }
                }),
            Tables\Columns\TextColumn::make('no_registrasi')
                ->label('Nomor Registrasi'),
            Tables\Columns\TextColumn::make('tahuntanam')
                ->label('Tahun Tanam')
                ->getStateUsing(function ($record) {
                    if (null !== $record->pohoninduk->tahun_tanam) {
                        return $record->pohoninduk->tahun_tanam;
                    } else {
                        return "Belum Terisi";
                    }
                }),
            Tables\Columns\TextColumn::make('tahunreg')
                ->label('Tahun Terregistrasi')
                ->getStateUsing(function ($record) {
                    if (null !== $record->pohoninduk->tahun_regis) {
                        return $record->pohoninduk->tahun_regis;
                    } else {
                        return "Belum Terisi";
                    }
                }),
            Tables\Columns\TextColumn::make('komkel')
                ->label('Kelompok Komoditas')
                ->getStateUsing(function ($record) {
                    return $record->pohoninduk->kel_komoditas->nama_kelompok;
                }),
            Tables\Columns\TextColumn::make('komoditas')
                ->label('Komoditas')
                ->getStateUsing(function ($record) {
                    return $record->pohoninduk->komoditas->nama;
                }),
            Tables\Columns\TextColumn::make('varietas')
                ->label('Varietas')
                ->getStateUsing(function ($record) {
                    return $record->pohoninduk->varietas->nama_varietas;
                }),
            Tables\Columns\TextColumn::make('label')
                ->label('Kelas Benih')
                ->getStateUsing(function ($record) {
                    if (null !== $record->pohoninduk->label_induk) {
                        return $record->pohoninduk->label_induk;
                    } else {
                        return "Belum Terisi";
                    }
                }),
            Tables\Columns\TextColumn::make('lasben')
                ->label('Status Tanaman Induk')
                ->getStateUsing(function ($record) {
                    if (null !== $record->pohoninduk->kelasbenih->kelas_benih) {
                        return $record->pohoninduk->kelasbenih->kelas_benih;
                    } else {
                        return "Belum Terisi";
                    }
                }),
            Tables\Columns\ImageColumn::make('foto')
                ->label('Foto')
                ->getStateUsing(function ($record) {
                    if (null !== $record->pohoninduk->upload) {
                        return url('/storage') . "/" . $record->pohoninduk->upload;
                    } else {
                        return "Belum Terisi";
                    }
                })->circular(),
            Tables\Columns\TextColumn::make('detail')
                ->label('Lihat Detail')
                ->getStateUsing(function ($record) {
                    return "Klik Disini";
                })
                ->url(function ($record) {
                    return route('detail-pohon-kosong', ['id' => $record->id]);
                }),

        ];
    }
    protected function getTableFilters(): array
    {
        return [
            SelectFilter::make('komoditas_id')
                ->label('Komoditas')
                ->options(function () {
                    return Komoditas::all()->pluck('nama', 'id')->toArray();
                })
                ->query(function (Builder $query, array $data) {
                    if (!empty($data['value']))
                    {
                        // if we have a value (the aircraft ID from our options() query), just query a nested
                        // set of whereHas() clauses to reach our target, in this case two deep
                        $query->whereHas(
                            'pohoninduk',
                            fn (Builder $query) => $query->whereHas(
                                'komoditas',
                                fn (Builder $query) => $query->where('id', '=', (int) $data['value'])
                            )
                        );
                    }
                }), // Set the selected value
            SelectFilter::make('pemilik_pohon_id')
                ->label('Pemilik Pohon')
                ->options(function () {
                    return KepemilikanPohonInduk::all()->pluck('nama_lembaga', 'id')->toArray();
                })
                ->query(function (Builder $query, array $data) {
                    if (!empty($data['value']))
                    {
                        // if we have a value (the aircraft ID from our options() query), just query a nested
                        // set of whereHas() clauses to reach our target, in this case two deep
                        $query->whereHas(
                            'pohoninduk',
                            fn (Builder $query) => $query->whereHas(
                                'pemilik_pohon',
                                fn (Builder $query) => $query->where('id', '=', (int) $data['value'])
                            )
                        );
                    }
                }), // Set the selected value
            SelectFilter::make('provinces')
                ->label('Provinsi')
                ->options(function () {
                    return Provinces::all()->pluck('name', 'id')->toArray();
                })
                ->query(function (Builder $query, array $data) {
                    if (!empty($data['value']))
                    {
                        // if we have a value (the aircraft ID from our options() query), just query a nested
                        // set of whereHas() clauses to reach our target, in this case two deep
                        $query->whereHas(
                            'pohoninduk',
                            fn (Builder $query) => $query->whereHas(
                                'pemilik_pohon',
                                fn (Builder $query) => $query->where('provinces_id', '=', (int) $data['value'])
                            )
                        );
                    }
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
        return view('livewire.pohon-induk1')->layout('layouts.base');
    }
}
