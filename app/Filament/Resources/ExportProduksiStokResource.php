<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExportProduksiStokResource\Pages;
use App\Filament\Resources\ExportProduksiStokResource\RelationManagers;
use App\Models\ExportProduksiStok;
use App\Models\Komoditas;
use App\Models\LaporanBenihPTM;
use App\Models\ProdusenBenih;
use App\Models\LaporanLabelMati;
use App\Models\LaporanProduksiMati;
use App\Models\PemeriksaanTanaman;
use App\Models\PenerimaanBatangBawah;
use App\Models\PenyaluranStokBenih;
use App\Models\JenisProdusen;
use App\Models\ProsesPerbanyakanBenih;
use App\Models\Provinces;
use App\Models\Varietas;
use Filament\Forms;
use DB;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Layout;
class ExportProduksiStokResource extends Resource
{
    protected static ?string $model = ExportProduksiStok::class;

    protected static ?string $navigationIcon = 'heroicon-o-database';
    protected static ?string $navigationGroup = 'Export';
    protected static ?int $navigationSort = 14;
    protected static ?string $navigationLabel = 'Export Database Produksi APBN';
    // protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                    
			Tables\Columns\TextColumn::make('tahun')
                ->label("Tahun Target Produksi")
                ->searchable()
                            ->sortable(),
				Tables\Columns\TextColumn::make('lembaga.kode_produsen')
                ->label("Kode Produsen")
                ->searchable()
                            ->sortable(),
                Tables\Columns\TextColumn::make('lembaga.jenisprodusen.nama_jenis')
                ->label("Jenis Produsen")
                ->searchable()
                            ->sortable(),
				Tables\Columns\TextColumn::make('lembaga.nama_lembaga')
                ->label("Nama Lembaga")
                ->searchable()
                  ->sortable(),
				  Tables\Columns\TextColumn::make('lembaga.provinces.name')
                ->label("Provinsi")
                ->searchable()
                  ->sortable(),
				   Tables\Columns\TextColumn::make('lembaga.regencies.name')
                ->label("Kab/Kota")
                ->searchable()
                  ->sortable(),
				   Tables\Columns\TextColumn::make('lembaga.districts.name')
                ->label("Kecamatan")
                ->searchable()
                  ->sortable(),
				   Tables\Columns\TextColumn::make('lembaga.villages.name')
                ->label("Desa")
                ->searchable()
                  ->sortable(),
				  Tables\Columns\TextColumn::make('lembaga.alamat')
                ->label("Alamat Produsen")
                ->searchable()
                  ->sortable(),
				   Tables\Columns\TextColumn::make('lokasiproduksidetail.alamat')
                ->label("Lokasi Produksi")
                ->searchable()
                  ->sortable(),
				  
				  Tables\Columns\TextColumn::make('komoditas.nama')
                ->label("Komoditas")
                ->searchable()
                  ->sortable(),
                Tables\Columns\TextColumn::make('varietas.nama_varietas')
                ->label("Varietas")
                ->searchable()
                  ->sortable(),
				  Tables\Columns\TextColumn::make('satuan.nama_satuan')
                ->label("Satuan")
                ->searchable()
                  ->sortable(),
				  Tables\Columns\TextColumn::make('jum_target')
                ->label("Jumlah Target")
				->getStateUsing(function($record){
					return number_format($record->jum_target,0,",",".")." ".$record->satuan->nama_satuan;
				}),
				  Tables\Columns\TextColumn::make('salur')
                ->label("Target Penyaluran")
				->getStateUsing(function($record){
					return number_format($record->targetsalur->sum('jumlah'),0,",",".")." ".$record->satuan->nama_satuan;
				}),
				 Tables\Columns\TextColumn::make('banyakhasil')
                ->label("Proses Perbanyakan Berhasil")
				->getStateUsing(function($record){
					return number_format(($record->produksi->sum('pengadaan_benih')-$record->produksimati->sum('produksi_mati')),0,",",".")." ".$record->satuan->nama_satuan;
				}),
				Tables\Columns\TextColumn::make('gagalhasil')
                ->label("Proses Perbanyakan Gagal")
				->getStateUsing(function($record){
					return number_format($record->produksimati->sum('produksi_mati'),0,",",".")." ".$record->satuan->nama_satuan;
				}),
				Tables\Columns\TextColumn::make('belumhasil')
                ->label("Belum Proses Perbanyakan")
				->getStateUsing(function($record){
					return number_format(($record->jum_target-$record->produksi->sum('pengadaan_benih')+$record->produksimati->sum('produksi_mati')),0,",",".")." ".$record->satuan->nama_satuan;
				}),
				Tables\Columns\TextColumn::make('kinerjahasil')
                ->label("Kinerja Perbanyakan")
				->getStateUsing(function($record){
				if(($record->produksi->sum('pengadaan_benih')-$record->produksimati->sum('produksi_mati'))>0 ){
					return number_format((($record->produksi->sum('pengadaan_benih')-$record->produksimati->sum('produksi_mati'))*100/$record->jum_target),0,",",".")."%";
				}else{
					return "Belum Ada Pelaporan";
				}
					
				}),
				 Tables\Columns\TextColumn::make('ptmhasil')
                ->label("Proses PTM Berhasil")
				->getStateUsing(function($record){
					return number_format(($record->ptm->sum('jum_panen')-$record->ptmmati->sum('label_mati')),0,",",".")." ".$record->satuan->nama_satuan;
				}),
				Tables\Columns\TextColumn::make('gagalptm')
                ->label("Proses PTM Gagal")
				->getStateUsing(function($record){
					return number_format($record->ptmmati->sum('label_mati'),0,",",".")." ".$record->satuan->nama_satuan;
				}),
				Tables\Columns\TextColumn::make('belumptm')
                ->label("Belum PTM")
				->getStateUsing(function($record){
					return number_format(($record->produksi->sum('pengadaan_benih')-$record->produksimati->sum('produksi_mati')-$record->ptm->sum('jum_panen')+$record->ptmmati->sum('label_mati')))." ".$record->satuan->nama_satuan;
				}),
				Tables\Columns\TextColumn::make('kinerjaptm')
                ->label("Kinerja PTM")
				->getStateUsing(function($record){
				 if(($record->ptm->sum('jum_panen')-$record->ptmmati->sum('label_mati'))>0){
                        return number_format((($record->ptm->sum('jum_panen')-$record->ptmmati->sum('label_mati'))*100/$record->jum_target),0,",",".")."%";
				}else{
                       return "Belum Ada Pelaporan";
                }
					
				}),
						 Tables\Columns\TextColumn::make('ptmhasil')
                ->label("Proses Labeling Berhasil")
				->getStateUsing(function($record){
					$jumlah = DB::table('target_benih')
                    ->join('lap_benih_panen','lap_benih_panen.target_benih_id','target_benih.id')
                    ->join('lap_benih_label','lap_benih_label.lap_benih_panen_id','lap_benih_panen.id')
                    ->where('target_benih.id',$record->id)
                    ->sum('jumlah_lanjut');
					return number_format(($jumlah-$record->penguranganstok->sum('jumlah')),0,",",".")." ".$record->satuan->nama_satuan;
				}),
				Tables\Columns\TextColumn::make('gagalptm')
                ->label("Proses Labeling Gagal")
				->getStateUsing(function($record){
					$jumlah = DB::table('target_benih')
                    ->join('lap_benih_panen','lap_benih_panen.target_benih_id','target_benih.id')
                    ->join('lap_benih_label','lap_benih_label.lap_benih_panen_id','lap_benih_panen.id')
                    ->where('target_benih.id',$record->id)
                    ->sum('jumlah_lanjut');
					return number_format($record->penguranganstok->sum('jumlah'),0,",",".")." ".$record->satuan->nama_satuan;
				}),
				Tables\Columns\TextColumn::make('belumptm')
                ->label("Belum Labeling")
				->getStateUsing(function($record){
					$jumlah = DB::table('target_benih')
                    ->join('lap_benih_panen','lap_benih_panen.target_benih_id','target_benih.id')
                    ->join('lap_benih_label','lap_benih_label.lap_benih_panen_id','lap_benih_panen.id')
                    ->where('target_benih.id',$record->id)
                    ->sum('jumlah_lanjut');
					return number_format(($record->ptm->sum('jum_panen')-$record->ptmmati->sum('label_mati')-$jumlah),0,",",".")." ".$record->satuan->nama_satuan;
				}),
				Tables\Columns\TextColumn::make('kinerjaptm')
                ->label("Kinerja Labeling")
				->getStateUsing(function($record){
					$jumlah = DB::table('target_benih')
                    ->join('lap_benih_panen','lap_benih_panen.target_benih_id','target_benih.id')
                    ->join('lap_benih_label','lap_benih_label.lap_benih_panen_id','lap_benih_panen.id')
                    ->where('target_benih.id',$record->id)
                    ->sum('jumlah_lanjut');
				  if(($jumlah-$record->penguranganstok->sum('jumlah'))>0){
                        return number_format((($jumlah-$record->penguranganstok->sum('jumlah'))*100/$record->jum_target),0,",",".")."%";
				}else{
                        return "Belum Ada Pelaporan";
				}
					
				}),		 
					  Tables\Columns\TextColumn::make('salur')
                ->label("Stok Tersalur")
				->getStateUsing(function($record){
					return number_format($record->penyaluranstok->sum('jumlah'),0,",",".")." ".$record->satuan->nama_satuan;
				}),
				Tables\Columns\TextColumn::make('kinerjasalur')
                ->label("Kinerja Penyaluran")
				->getStateUsing(function($record){
					if(($record->penyaluranstok->sum('jumlah'))>0){
						
                        return number_format((($record->penyaluranstok->sum('jumlah'))*100/$record->jum_target),0,",",".")."%";
					}else{
                        return "Belum Ada Pelaporan";
                    }
					
				}),
				Tables\Columns\TextColumn::make('sisastok')
                ->label("Sisa Stok")
				->getStateUsing(function($record){
					$jumlah = DB::table('target_benih')
                    ->join('lap_benih_panen','lap_benih_panen.target_benih_id','target_benih.id')
                    ->join('lap_benih_label','lap_benih_label.lap_benih_panen_id','lap_benih_panen.id')
                    ->where('target_benih.id',$record->id)
                    ->sum('jumlah_lanjut');
					return number_format(($jumlah-$record->penguranganstok->sum('jumlah')-$record->penyaluranstok->sum('jumlah')),0,",",".")." ".$record->satuan->nama_satuan;
				}),
				Tables\Columns\TextColumn::make('status')
                ->label("Status Target")
				->getStateUsing(function($record){
					 if($record->status=="active"){
                      return "Terverifikasi";
					 }elseif($record->status=="pending"){
                      return "Diajukan Ulang";
                     }elseif($record->status=="tolak"){
                      return "Ditolak dengan keterangan"." ".$record->keterangan;
				}elseif($record->status=="selesai"){
                      return "Target Selesai";
				}else{
                      return "Diajukan";
				}
				}),
                 //penyaluran end//
            ])
			->defaultSort('tahun','desc')
            ->filters([
			SelectFilter::make('jenis')
                ->label('Jenis Produsen')
				->searchable()
                ->options(function () {
                    return JenisProdusen::all()->pluck('nama_jenis', 'id')->toArray();
                })->query(function (Builder $query, array $data) {
				if (!empty($data['value']))
				{
					$query->whereHas(
						'lembaga',
						fn (Builder $query) => $query->where('jenis_produsen_id', '=', (int) $data['value'])
					);
				}
				}),
			SelectFilter::make('tahun')
                ->label('Tahun Target Produksi')
				->searchable()
                ->options(function () {
                    return ExportProduksiStok::groupBy('tahun')->pluck('tahun', 'tahun')->toArray();
                }), // Set the selected value
			SelectFilter::make('provinsi')
                ->label('Provinsi')
				->searchable()
                ->options(function () {
                    return Provinces::all()->pluck('name', 'id')->toArray();
                })->query(function (Builder $query, array $data) {
				if (!empty($data['value']))
				{
					$query->whereHas(
						'lembaga',
						fn (Builder $query) => $query->where('provinces_id', '=', (int) $data['value'])
					);
				}
				}),
            SelectFilter::make('lembaga_serti_id')
                ->label('Lembaga Sertifikasi')
				->searchable()
                ->options(function () {
                    return ProdusenBenih::where('jenis_lembaga_id', [1,7])->pluck('nama_lembaga', 'id')->toArray();
                }),
			SelectFilter::make('komoditas_id')
                ->label('Komoditas')
                ->options(function () {
                    return Komoditas::all()->pluck('nama', 'id')->toArray();
                })
				->searchable(),
            ],layout: Layout::AboveContent)
            ->actions([
                //Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                //Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    public static function canEdit(Model $record): bool
    {
        return false;
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListExportProduksiStoks::route('/'),
            'create' => Pages\CreateExportProduksiStok::route('/create'),
            'edit' => Pages\EditExportProduksiStok::route('/{record}/edit'),
        ];
    }    
}
