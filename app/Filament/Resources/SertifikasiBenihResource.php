<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SertifikasiBenihResource\Pages;
use App\Filament\Resources\SertifikasiBenihResource\RelationManagers;
use App\Models\SertifikasiBenih;
use App\Models\LaporanBenihPTM;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\Filter;
use Filament\Resources\RelationManagers\RelationGroup;
class SertifikasiBenihResource extends Resource
{
    protected static ?string $model = SertifikasiBenih::class;


    protected static ?string $navigationIcon = 'heroicon-o-document-report';
    // protected static bool $shouldRegisterNavigation = false;
    protected static ?string $navigationGroup = 'Laporan Produksi dan Kegiatan Sertifikasi APBN';
    protected static ?string $navigationLabel = 'Laporan Sertifikasi Benih APBN';
    protected static ?int $navigationSort = 11;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Placeholder::make('lembaga_id')
                        ->label(__('Nama Lembaga'))
                        ->content(fn ($record) => $record->lembaga?->nama_lembaga),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\Layout\Split::make([
                    Tables\Columns\Layout\Stack::make([
                        Tables\Columns\TextColumn::make('tes0')
                        ->getStateUsing(function($record) {
                            return "Lembaga Yang Mengajukan : ";
                        }),
                        Tables\Columns\TextColumn::make('lembaga_id')
                        ->sortable()
                        ->searchable()
                            ->size('sm')
                            ->color('secondary')
                            ->getStateUsing(function($record) {
                                if(isset($record->lembaga->nama_lembaga)){
                                return $record->lembaga->nama_lembaga;
                                }else{
                                return "-";
                                }
                        })
                        ->searchable(),
                        Tables\Columns\TextColumn::make('test0')
                        ->getStateUsing(function($record) {
                            return "Lokasi Produksi : ";
                        }),
                        Tables\Columns\TextColumn::make('lokasiproduksidetail.alamat')
                            ->size('sm')
                            ->color('secondary')
                            ->label('Lokasi Produksi'),
                    ]),
                        Tables\Columns\Layout\Stack::make([
                        Tables\Columns\TextColumn::make('kl')
                        ->getStateUsing(function($record) {
                            return "Kelompok Komoditas : ";
                        }),
                        Tables\Columns\TextColumn::make('kelkomoditas.nama_kelompok')
                            ->label('Kelompok Komoditas')
                            ->size('sm')
                            ->color('secondary')
                            ->alignLeft(),
                        Tables\Columns\TextColumn::make('km')
                        ->getStateUsing(function($record) {
                            return "Komoditas : ";
                        }),
                        Tables\Columns\TextColumn::make('komoditas.nama')
                            ->label('Komoditas')
                            ->size('sm')
                            ->color('secondary')
                            ->alignLeft(),
                        Tables\Columns\TextColumn::make('vr')
                            ->getStateUsing(function($record) {
                            return "Varietas : ";
                        }),
                        Tables\Columns\TextColumn::make('varietas.nama_varietas')
                            ->label('Varietas')
                            ->size('sm')
                            ->color('secondary')
                            ->alignLeft(),
                    ]),
                    
                    Tables\Columns\Layout\Stack::make([
                        Tables\Columns\TextColumn::make('ptm')
                            ->getStateUsing(function($record) {
                                $jumlahpengajuan = $record->benihptm->where('status','=',0)->count();
                            return "Pengajuan Label PTM : ".$jumlahpengajuan;
                        }),
                        
                        Tables\Columns\TextColumn::make('periksa')
                            ->getStateUsing(function($record) {
                                $jumlahperiksa = $record->benihptm->where('status','=',1)->count();
                            return "Pengajuan Sudah Diperiksa : ".$jumlahperiksa;
                        }),
                        Tables\Columns\TextColumn::make('blmlabel')
                            ->getStateUsing(function($record) {
                                $idnya = $record->id;
                                $all = LaporanBenihPTM::where('target_benih_id',$idnya)->count();
                                $ptm = LaporanBenihPTM::has('penentuanlabel')->where('target_benih_id',$idnya)->count();
                                $blm = $all-$ptm;
                            return "Pengajuan Belum Memiliki Label : ".$blm;
                        }),
                        Tables\Columns\TextColumn::make('label')
                            ->getStateUsing(function($record) {
                                $idnya = $record->id;
                                $ptm = LaporanBenihPTM::whereHas('penentuanlabel', function($q){
                                            $q->has('label');
                                        })->where('target_benih_id',$idnya)->count();
                            return "Label PTM Sudah Dibuat : ".$ptm;
                        }),
                         Tables\Columns\TextColumn::make('blmlabeling')
                            ->getStateUsing(function($record) {
                                $idnya = $record->id;
                                $blmcetak = LaporanBenihPTM::whereHas('penentuanlabel', function($q){
                                            $q->whereHas('label', function($a){
                                                $a->whereNull('status_cetak');
                                            });
                                        })->where('target_benih_id',$idnya)->count();
                            return "Label Belum Dicetak : ".$blmcetak;
                        }),
                        Tables\Columns\TextColumn::make('labeling')
                            ->getStateUsing(function($record) {
                                $idnya = $record->id;
                                $cetak = LaporanBenihPTM::whereHas('penentuanlabel', function($q){
                                            $q->whereHas('label', function($a){
                                                $a->where('status_cetak',1);
                                            });
                                        })->where('target_benih_id',$idnya)->count();
                            return "Label Sudah Dicetak : ".$cetak;
                        }),
                    ]),
                
                    
                ]),
            ])
            ->filters([
                Filter::make('ptm')->label('Tunjukan hanya yang masih pengajuan')
                ->query(fn (Builder $query): Builder => $query->whereHas('benihptm', function($q){
                                            $q->where('status','=',0);
                                        })
                )
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
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
    public static function getRelations(): array
    {
         return [
        RelationGroup::make('Laporan Produksi', [
            RelationManagers\BatangbawahRelationManager::class,
            RelationManagers\PerbanyakanbenihRelationManager::class,
        ]),
        
        RelationGroup::make('Laporan Sertifikasi', [
            RelationManagers\BenihptmRelationManager::class,
      ]),
            ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSertifikasiBenihs::route('/'),
            'create' => Pages\CreateSertifikasiBenih::route('/create'),
            'edit' => Pages\EditSertifikasiBenih::route('/{record}/edit'),
        ];
    }    
}
