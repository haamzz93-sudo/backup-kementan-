<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StokProdusenResource\Pages;
use App\Filament\Resources\StokProdusenResource\RelationManagers;
use App\Models\StokProdusen;
use App\Models\ProdusenBenih;
use App\Models\KelKomoditas;
use App\Models\Komoditas;
use App\Models\LaporanTargetBenih;
use App\Models\Varietas;
use App\Models\LokasiProduksiDetail;
use App\Models\PenguranganStokBenih;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\SelectFilter;
use DB;
use Closure;
class StokProdusenResource extends Resource
{
    protected static ?string $model = StokProdusen::class;
    // protected static bool $shouldRegisterNavigation = false;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Laporan Produksi dan Kegiatan Sertifikasi APBN';
    protected static ?int $navigationSort = 10;
    protected static ?string $navigationLabel = 'Laporan Stok Benih Lembaga APBN';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Placeholder::make('nomor_induk')
                    ->label(__('Nomor Induk'))
                    ->content(fn ($record) => $record?->nomor_induk)
                    ->hiddenOn('create'),
                Forms\Components\Placeholder::make('lembaga_id')
                    ->label(__('Nama Lembaga'))
                    ->content(fn ($record) => $record->produsenbenih?->nama_lembaga)
                    ->hiddenOn('create'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                
                Tables\Columns\Layout\Split::make([
                    Tables\Columns\Layout\Stack::make([
                        Tables\Columns\TextColumn::make('y')
                            ->getStateUsing(function($record) {
                                return "Tahun Stok : ";
                    }),
                Tables\Columns\TextColumn::make('tahun')
                ->date('Y')
                ->size('sm')
                ->color('secondary'),
                    Tables\Columns\TextColumn::make('lp')
                        ->getStateUsing(function($record) {
                            return "Lokasi Produksi : ";
                    }),
                Tables\Columns\TextColumn::make('lokasi_produksi_detail_id')
                ->sortable()
                ->searchable()
                ->size('sm')
                ->color('secondary')
                ->getStateUsing(function($record) {
                    $target = $record->produsenbenih->nama_lembaga ?? '';
                    return $target;
                }),
                Tables\Columns\TextColumn::make('lokasi_produksi_detail_id')
                ->sortable()
                ->searchable()
                ->size('sm')
                ->color('secondary')
                ->getStateUsing(function($record) {
                    $satuan = $record->lokasiproduksidetail->alamat ?? '';
                    return $satuan;
                }),
            ]),
                Tables\Columns\Layout\Stack::make([
                    Tables\Columns\TextColumn::make('kl')
                        ->getStateUsing(function($record) {
                            return "Kelompok Komoditas : ";
                    }),
                    Tables\Columns\TextColumn::make('kelkomoditas.nama_kelompok')
                        ->label('Kelompok Komoditas')
                        ->sortable()
                        ->searchable()
                        ->size('sm')
                        ->color('secondary')
                        ->getStateUsing( function ($record){
                            $kl = $record->kelkomoditas->nama_kelompok;
                            return $kl;
                        }),
                        Tables\Columns\TextColumn::make('km')
                        ->getStateUsing(function($record) {
                            return "Komoditas : ";
                    }),
                    Tables\Columns\TextColumn::make('komoditas.nama')
                        ->label('Komoditas')
                        ->sortable()
                        ->searchable()
                        ->size('sm')
                        ->color('secondary')
                        ->getStateUsing( function ($record){
                            $km = $record->komoditas->nama;
                            return $km;
                        }),
                    Tables\Columns\TextColumn::make('vr')
                        ->getStateUsing(function($record) {
                            return "Varietas : ";
                    }),
                       Tables\Columns\TextColumn::make('varietas.nama_varietas')
                        ->label('Varietas')
                        ->sortable()
                        ->searchable()
                        ->size('sm')
                        ->color('secondary')
                        ->getStateUsing( function ($record){
                            $vr = $record->varietas->nama_varietas ?? "";
                            return $vr;
                        }),
                ]),
                
                Tables\Columns\Layout\Stack::make([
                    Tables\Columns\TextColumn::make('ss')
                        ->getStateUsing(function($record) {
                            return "Jumlah Stok Siap Salur : ";
                    }),
                    Tables\Columns\TextColumn::make('dd')
                    ->size('sm')
                    ->color('secondary')
                    ->getStateUsing( function ($record){
                        $jb = $record->jum_s_benih;
                        $ja = $record->jum_s_ada;
                        $js = $record->jum_s_salur;
                        $jm = $record->jum_s_mati;
                        
                        return ($jb+$ja)-($js+$jm);
                    }),
                ]),
                Tables\Columns\Layout\Stack::make([
                    Tables\Columns\TextColumn::make('pb')
                        ->getStateUsing(function($record) {
                            return "Realisasi Perbanyakan Benih : ";
                    }),
                    Tables\Columns\TextColumn::make('tanggal_r_tanam')
                    ->sortable()
                    ->searchable()
                    ->size('sm')
                    ->color('secondary')
                    ->getStateUsing( function ($record){
                        $tt = $record->tanggal_r_tanam;
                        return $tt;
                    }),
                    
                    Tables\Columns\TextColumn::make('ptm')
                        ->getStateUsing(function($record) {
                            return "Realisasi Sudah PTM : ";
                    }),
                    Tables\Columns\TextColumn::make('tanggal_r_panen')
                    ->sortable()
                    ->searchable()
                    ->size('sm')
                    ->color('secondary')
                    ->getStateUsing( function ($record){
                        $tts = $record->tanggal_r_panen;
                        return $tts;
                    }),
                    
                    Tables\Columns\TextColumn::make('sp')
                        ->getStateUsing(function($record) {
                            return "Realisasi Siap Salur : ";
                    }),
                    Tables\Columns\TextColumn::make('tanggal_r_salur')
                    ->sortable()
                    ->searchable()
                    ->size('sm')
                    ->color('secondary')
                    ->getStateUsing( function ($record){
                        $ttd = $record->tanggal_r_salur;
                        return $ttd;
                    }),
                ]),
            ]),
            ])
            ->filters([
                SelectFilter::make('lembaga_id')
                ->label('Lembaga')
                ->options(ProdusenBenih::all()->pluck('nama_lembaga','id')->toArray())->multiple(),
                SelectFilter::make('komkel_id')
                ->label('Kelompok Komoditas')
                ->options(KelKomoditas::all()->pluck('nama_kelompok','id')->toArray())->multiple(),
                SelectFilter::make('komoditas_id')
                ->label('Komoditas')
                ->options(Komoditas::all()->pluck('nama','id')->toArray())->multiple(),
                SelectFilter::make('varietas_id')
                ->label('Varietas')
                ->options(Varietas::all()->pluck('nama_varietas','id')->toArray())->multiple(),
            ])
            ->actions([
                Tables\Actions\Action::make('status')
                ->label('Target Selesai')
                ->action(
                    function ($record) {
                        $id = $record->id;
                        return[
                            DB::table('target_benih')->where('id',$id)->update([
                                'status' => "selesai",
                            ])
                        ];
                    }
            )
                ->visible(function ($record){
                    if($record->jum_s_salur==$record->jum_target)
                    {return true;}
                    elseif($record->status!=="selesai")
                    {return true;}
                    else
                    {return false;}
                })
                ->requiresConfirmation("Apakah Anda Yakin?"),
                Tables\Actions\EditAction::make()
                ->label('Laporan Stok Benih')
                ->visible(function ($record){
                    if($record->status=="selesai")
                    {return false;}
                    else
                    {return true;}
                }),
            ])->defaultSort('id', 'desc')
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    public static function getRelations(): array
    {
        return [
                RelationManagers\PengadaanStokBenihRelationManager::class,
                RelationManagers\PenguranganStokBenihRelationManager::class,
                RelationManagers\PenyaluranStokBenihRelationManager::class,
            ];
        
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStokProdusens::route('/'),
            'create' => Pages\CreateStokProdusen::route('/create'),
            'edit' => Pages\EditStokProdusen::route('/{record}/edit'),
        ];
    }   
    public static function getEloquentQuery(): Builder
    {
        if(auth()->user()->hasRole("Pelapor")){
        return parent::getEloquentQuery()->where([['sumber_dana', "APBN"],['status', "active"],['lokasi_produksi_detail_id',auth()->user()->lokasi_produksi_detail_id]]);
        }else if(auth()->user()->hasRole("Produsen Benih")){
        return parent::getEloquentQuery()->where([['sumber_dana', "APBN"],['status', "active"],['lembaga_id',auth()->user()->lembaga_id]]);
        }else if (auth()->user()->hasRole("Lembaga Sertifikasi Benih")){
            //INI PENTING!
            return parent::getEloquentQuery()->whereHas('produsenbenih', function($q) {
                $q->where('lembaga_serti_id',auth()->user()->lembaga_id);
            })->where([['sumber_dana', "APBN"],['status', "active"]]);
        }else{
            return parent::getEloquentQuery();
        } 
    } 
}
