<?php

namespace App\Filament\Resources;
use DB;
use App\Filament\Resources\ProduksiBenihResource\Pages;
use App\Filament\Resources\ProduksiBenihResource\RelationManagers;
use Filament\Resources\RelationManagers\RelationGroup;
use App\Models\Provinces;
use App\Models\Regencies;
use App\Models\Districts;
use App\Models\Villages;

use App\Models\JenisLembaga;
use App\Models\JenisProdusen;
use App\Models\ProduksiBenih;
use App\Models\LaporanBenihPTM;
use App\Models\ProsesPerbanyakanBenih;
use App\Models\PenerimaanBatangBawah;
use App\Models\ProdusenBenih;

use App\Models\LaporanBatangMati;
use App\Models\LaporanProduksiMati;
use App\Models\LaporanLabelMati;
use App\Models\KelKomoditas;
use App\Models\Komoditas;
use App\Models\Varietas;
use App\Models\KelasBenih;
use App\Models\Golongan;
use App\Models\Cara;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\SelectFilter;

class ProduksiBenihResource extends Resource
{
    protected static ?string $model = ProduksiBenih::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Laporan Produksi dan Kegiatan Sertifikasi APBN';
    protected static ?int $navigationSort = 7;
    protected static ?string $navigationLabel = 'Laporan Produksi Lembaga APBN';

    public static function form(Form $form): Form
    {
        if(isset (auth()->user()->lembaga_id)){
            $saya = auth()->user()->lembaga_id;
            $lembaga = ProdusenBenih::where('id',$saya)->first();
            $lemid = $lembaga->id;
            }
            if(auth()->user()->hasRole("Pelapor") or auth()->user()->hasRole("Produsen Benih")){
            //Pelapor
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                Forms\Components\Select::make('lembaga_id')
                ->label('Nama Lembaga')
                    ->options(ProdusenBenih::where('id',$lemid)->pluck('nama_lembaga','id')->toArray())
                    ->disabled()
                    ->reactive(),
                    ])->columns(1),
                Forms\Components\Card::make()
                    ->schema([
                Forms\Components\Select::make('komkel_id')
                ->label('Kelompok Komoditas')
                ->options(KelKomoditas::all()->pluck('nama_kelompok','id')->toArray())
                ->disabled()
                ->reactive()
                ->required(),
                Forms\Components\Select::make('komoditas_id')
                ->label('Komoditas')
                ->disabled()
                ->options(function(callable $get){
                    $komkel = KelKomoditas::find($get('komkel_id'));
                    if(!$komkel){
                        return null;
                    }
                    return $komkel->komoditas->pluck('nama','id');
                })
                ->reactive()
                ->required(),
                Forms\Components\Select::make('varietas_id')
                ->label('Varietas')
                ->disabled()
                ->options(function(callable $get){
                    $komoditas = Komoditas::find($get('komoditas_id'));
                    if(!$komoditas){
                        return null;
                    }
                    return $komoditas->varietas->pluck('nama_varietas','id');
                })
                ->reactive()
                ->required(),
                ])->columns(3),
                
                Forms\Components\Card::make()
                    ->schema([
                Forms\Components\Select::make('kelas_benih_id')
                ->label('Kelas Benih')
                ->disabled()
                ->options(KelasBenih::select( DB::raw("kelas_benih AS name"),'id')
                ->where('kel_benih_id', 1)
                ->pluck('name','id')->toArray())
                ->reactive()
                ->required(),
                Forms\Components\Select::make('golongan_id')
                    ->label('Golongan Perbanyakan')
                    ->disabled()
                    ->options(Golongan::all()->pluck('gol_banyak','id')->toArray())
                    ->reactive()
                    ->required(),
                    
                Forms\Components\Select::make('cara_id')
                ->label('Metode Perbanyakan')
                ->disabled()
                ->options(function(callable $get){
                    $golongan = Golongan::find($get('golongan_id'));
                    if(!$golongan){
                        return null;
                    }
                    return $golongan->cara->pluck('cara_banyak','id');
                })
                ->reactive()
                ->required()
                ->afterStateUpdated(fn (callable $set) => $set('cara_id',null)),
                ])->columns(3),
                ]);
            }else{
            //Pusat
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                Forms\Components\Select::make('lembaga_id')
                ->label('Nama Lembaga')
                ->disabled()
                    ->options(ProdusenBenih::all()->pluck('nama_lembaga','id')->toArray())
                    ->reactive(),
                    ])->columns(1),
                Forms\Components\Card::make()
                    ->schema([
                Forms\Components\Select::make('komkel_id')
                ->label('Kelompok Komoditas')
                ->disabled()
                ->options(KelKomoditas::all()->pluck('nama_kelompok','id')->toArray())
                ->reactive()
                ->required(),
                Forms\Components\Select::make('komoditas_id')
                ->label('Komoditas')
                ->disabled()
                ->options(function(callable $get){
                    $komkel = KelKomoditas::find($get('komkel_id'));
                    if(!$komkel){
                        return null;
                    }
                    return $komkel->komoditas->pluck('nama','id');
                })
                ->reactive()
                ->required(),
                Forms\Components\Select::make('varietas_id')
                ->label('Varietas')
                ->disabled()
                ->options(function(callable $get){
                    $komoditas = Komoditas::find($get('komoditas_id'));
                    if(!$komoditas){
                        return null;
                    }
                    return $komoditas->varietas->pluck('nama_varietas','id');
                })
                ->required()
                ])->columns(3),
                
                Forms\Components\Card::make()
                    ->schema([
                Forms\Components\Select::make('kelas_benih_id')
                ->label('Kelas Benih')
                ->disabled()
                ->options(KelasBenih::select( DB::raw("kelas_benih AS name"),'id')
                ->where('kel_benih_id', 2)
                ->pluck('name','id')->toArray())
                ->reactive()
                ->required(),
                Forms\Components\Select::make('golongan_id')
                    ->label('Golongan Perbanyakan')
                    ->disabled()
                    ->options(Golongan::all()->pluck('gol_banyak','id')->toArray())
                    ->reactive()
                    ->required(),
                    
                Forms\Components\Select::make('cara_id')
                ->label('Metode Perbanyakan')
                ->disabled()
                ->options(function(callable $get){
                    $golongan = Golongan::find($get('golongan_id'));
                    if(!$golongan){
                        return null;
                    }
                    return $golongan->cara->pluck('cara_banyak','id');
                })
                ->required(),
                ])->columns(3),
                ]);
            }
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\Layout\Split::make([
                    Tables\Columns\Layout\Stack::make([
                        Tables\Columns\TextColumn::make('produsenbenih.nama_lembaga')
                            ->label('Nama Lembaga')
                            ->sortable()
                            ->searchable()
                            ->size('sm')
                            ->color('secondary')
                            ->alignLeft(),
			Tables\Columns\TextColumn::make('lokasiproduksidetail.alamat')
                            ->label('Lokasi Produksi')
                            ->sortable()
                            ->size('sm')
                            ->color('secondary')
                            ->alignLeft()
                            ->getStateUsing(function($record) {
                                $lok = $record->lokasiproduksidetail->alamat;
                                return "Lokasi Produksi : " .$lok;
                            }),
                        Tables\Columns\TextColumn::make('kelkomoditas.nama_kelompok')
                            ->label('Kelompok Komoditas')
                            ->sortable()
                            ->searchable()
                            ->size('sm')
                            ->color('secondary')
                            ->alignLeft()
                            ->getStateUsing(function($record) {
                                $kel = $record->kelkomoditas->nama_kelompok;
                                return "Kelompok Komoditas : " .$kel;
                            }),
                        Tables\Columns\TextColumn::make('komoditas.nama')
                            ->label('Komoditas')
                            ->sortable()
                            ->searchable()
                            ->size('sm')
                            ->color('secondary')
                            ->alignLeft()
                            ->getStateUsing(function($record) {
                                $keom = $record->komoditas->nama;
                                return "Komoditas : " .$keom;
                            }),
                        Tables\Columns\TextColumn::make('varietas.nama_varietas')
                            ->label('Varietas')
                            ->sortable()
                            ->searchable()
                            ->size('sm')
                            ->color('secondary')
                            ->alignLeft()
                            ->getStateUsing(function($record) {
                                if(isset($record->varietas->nama_varietas)){
                                    return "Varietas : " .$record->varietas->nama_varietas;
                                }else{
                                    return "Varietas : ";
                                }
                                
                            }),
                        Tables\Columns\TextColumn::make('kelasbenih.kelas_benih')
                            ->label('Kelas Benih')
                            ->sortable()
                            ->searchable()
                            ->size('sm')
                            ->color('secondary')
                            ->alignLeft()
                            ->getStateUsing(function($record) {
                                $kb = $record->kelasbenih->kelas_benih;
                                return "Kelas Benih : " .$kb;
                            }),
                ]),
                    Tables\Columns\Layout\Stack::make([
                        Tables\Columns\TextColumn::make('tehun')
                            ->getStateUsing(function($record) {
                                return "Tahun Target : ";
                        }),
                        Tables\Columns\TextColumn::make('tahun')
                            ->size('sm')
                            ->color('secondary')
                            ->alignLeft()->sortable()->searchable(),
                        Tables\Columns\TextColumn::make('tes')
                            ->getStateUsing(function($record) {
                                return "Jumlah Target Siap Salur: ";
                        }),
                        Tables\Columns\TextColumn::make('jum_target')
                            ->size('sm')
                            ->color('secondary')
                            ->alignLeft()
                            ->getStateUsing(function($record) {
                                $target = $record->jum_target;
                                $satuan = $record->satuan->nama_satuan;
                                return $target ." ". "$satuan";
                        }),
                       
                        Tables\Columns\TextColumn::make('sts')
                            ->getStateUsing(function($record) {
                                return "Verifikasi BPSB: ";
                        }),
                        Tables\Columns\TextColumn::make('mengetahui')
                            ->size('sm')
                            ->color('secondary')
                            ->alignLeft()
                            ->getStateUsing(function($record) {
                                $target = $record->mengetahui;
                                if($target){
                                    return "Diketahui BPSB";
                                }else{
                                    return "Belum Diketahui BPSB";
                                }
                        }),
                    ]),
                        
                ]),
            ])
            ->filters([

                SelectFilter::make('tahun')
                ->label('Tahun Target')
                ->options(
                    function (){ 
                    return ProduksiBenih::groupBy('tahun')
                    ->pluck('tahun','tahun')->toArray();
                    }
                ),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Laporan'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    public static function getEloquentQuery(): Builder
    {
        if(auth()->user()->hasRole("Pelapor")){
        return parent::getEloquentQuery()->where([['lokasi_produksi_detail_id',auth()->user()->lokasi_produksi_detail_id],['status', "active"],['lembaga_id',auth()->user()->lembaga_id]]);
        }else if (auth()->user()->hasRole("Produsen Benih")){
	return parent::getEloquentQuery()->where([['status', "active"],['lembaga_id',auth()->user()->lembaga_id]]);
	}else if (auth()->user()->hasRole("Lembaga Sertifikasi Benih")){
            //INI PENTING!
            return parent::getEloquentQuery()->whereHas('produsenbenih', function($q) {
                $q->where('lembaga_serti_id',auth()->user()->lembaga_id);
            })->where('status', "active");
        }else{
            return parent::getEloquentQuery();
        } 
    }
    public static function getRelations(): array
    {
        
        return [
        RelationGroup::make('Laporan Produksi', [
            RelationManagers\PenerimaanBatangBawahRelationManager::class,  
            RelationManagers\ProsesPerbanyakanBenihRelationManager::class,
            RelationManagers\LaporanBenihPTMRelationManager::class,
        ]),
        
        RelationGroup::make('Laporan Kegagalan', [
            
            RelationManagers\LaporanBatangMatiRelationManager::class,  
            RelationManagers\LaporanProduksiMatiRelationManager::class,
            RelationManagers\LaporanLabelMatiRelationManager::class,
        ]),
        ]; 
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProduksiBenihs::route('/'),
            'create' => Pages\CreateProduksiBenih::route('/create'),
            'edit' => Pages\EditProduksiBenih::route('/{record}/edit'),
        ];
    }    
    
}
