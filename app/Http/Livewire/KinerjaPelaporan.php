<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Provinces;
use App\Models\JenisLembaga;
use App\Models\JenisProdusen;
use App\Models\ProduksiBenih;
use DB;
use Filament\Tables;
use Filament\Forms;
use Filament\Tables\Filters\Filter;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Layout;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromCollection;

class KinerjaPelaporan extends Component implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;

    protected function getTableQuery(): Builder
    {
        return User::whereHas('produsenbenih',function ($query) {
            $query->where('jenis_produsen_id', 4)
                  ->orWhere('jenis_lembaga_id', 1)
                  ->orWhere('jenis_lembaga_id', 7);
        });
    }
    protected function getTableColumns(): array
    {
		
			$year = date("Y");
		
        
        $months = array(
            array("01-" . $year, "Januari"),
            array("02-" . $year, "Februari"),
            array("03-" . $year, "Maret"),
            array("04-" . $year, "April"),
            array("05-" . $year, "Mei"),
            array("06-" . $year, "Juni"),
            array("07-" . $year, "Juli"),
            array("08-" . $year, "Agustus"),
            array("09-" . $year, "September"),
            array("10-" . $year, "Oktober"),
            array("11-" . $year, "November"),
            array("12-" . $year, "Desember")
        );

        $columns = [
            Tables\Columns\TextColumn::make('name')->label('Nama Pengguna')->searchable(),
            Tables\Columns\TextColumn::make('roles.name')->label('Wewenang')->searchable(),
            Tables\Columns\TextColumn::make('produsenbenih.nama_lembaga')->label('Nama Lembaga')->searchable(),
            Tables\Columns\TextColumn::make('produsenbenih.provinces.name')->label('Nama Provinsi')->searchable(),
            Tables\Columns\TextColumn::make('produsenbenih.jenis_lembaga.nama_jenis')->label('Jenis Lembaga')->searchable(),
            Tables\Columns\TextColumn::make('produsenbenih.jenis_produsen.nama_jenis')->label('Jenis Produsen')->searchable(),
        ];
		
        foreach ($months as $month) {
            $monthName = $month[1];
            $columns[] = Tables\Columns\TextColumn::make(strtolower($monthName))
                ->label($monthName)
                ->url(
                    function ($record) use ($month) {
                        $monthyear = $month[0];
                        $log = DB::table('activity_log')
                            ->select(
                                'activity_log.causer_id as idnya',
                                DB::raw('DATE_FORMAT(activity_log.created_at,"%m-%Y") as bulan_tahun')
                            )
                            ->where('activity_log.causer_id', $record->id) // Replace $us with the appropriate user object
                            ->where(DB::raw('DATE_FORMAT(activity_log.created_at,"%m-%Y")'), $monthyear)
                            ->where('description', 'not like', '%logged%')
                            ->count('activity_log.causer_id');
                        if ($log > 1) {
                            return route('detaillapor', ['user_id' => $record->id, 'bulan' => $monthyear]);
                        };
                    }
                )
                ->getStateUsing(function ($record) use ($month) {
                    $monthyear = $month[0];
                    $log = DB::table('activity_log')
                        ->select(
                            'activity_log.causer_id as idnya',
                            DB::raw('DATE_FORMAT(activity_log.created_at,"%m-%Y") as bulan_tahun')
                        )
                        ->where('activity_log.causer_id', $record->id) // Replace $us with the appropriate user object
                        ->where(DB::raw('DATE_FORMAT(activity_log.created_at,"%m-%Y")'), $monthyear)
                        ->where('description', 'not like', '%logged%')
                        ->count('activity_log.causer_id');
                    return $log;
                });
        }

        return $columns;
    }
    protected function getTableFilters(): array
    {
        return [
            
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
    protected function getTableRecordsPerPageSelectOptions(): array
    {
        return [10, 25, 50, 100];
    }
    public function render()
    {
        return view('livewire.kinerja-pelaporan')->layout('layouts.base');
    }
}
