<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TargetBenihResource\Widgets;
use App\Filament\Resources\TargetBenihResource\Pages;
use App\Filament\Resources\TargetBenihResource\RelationManagers;
use App\Filament\Widgets\ProdusenUmum;
use App\Models\TargetBenih;
use App\Models\Provinces;
use App\Models\Regencies;
use App\Models\Districts;
use App\Models\Villages;
use App\Models\ProdusenBenih;
use App\Models\JenisLembaga;
use App\Models\JenisProdusen;
use App\Models\LaporanTargetBenih;
use Filament\Forms;
use DB;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
class TargetBenihResource extends Resource
{
    protected static ?string $model = TargetBenih::class;
    protected static ?string $navigationIcon = 'heroicon-o-plus';
    protected static ?string $navigationGroup = 'Laporan Produksi dan Kegiatan Sertifikasi APBN';
    protected static ?int $navigationSort = 6;
    protected static ?string $navigationLabel = 'Target Produksi Benih APBN';
    
    // protected static bool $shouldRegisterNavigation = false;
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Placeholder::make('nama_lembaga')
                ->label(__('Nama Lembaga'))
                ->content(fn ($record) => $record->nama_lembaga)
                ->hiddenOn('create'),
                Forms\Components\Placeholder::make('alamat')
                ->label(__('Alamat'))
                ->content(fn ($record) => $record->alamat)
                ->hiddenOn('create'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\Layout\Split::make([
                    Tables\Columns\Layout\Stack::make([
                        Tables\Columns\TextColumn::make('nama_lembaga')
                        ->sortable()
                        ->searchable()
                        ->weight('medium')
                        ->alignLeft(),
                        
                        Tables\Columns\TextColumn::make('jenislembaga.nama_jenis')
                        ->label('Jenis Lembaga')
                        ->sortable()
                        ->searchable()
                        ->size('sm')
                        ->color('secondary')
                        ->alignLeft(),
                        
                        Tables\Columns\TextColumn::make('jenisprodusen.nama_jenis')
                        ->label('Jenis Produsen')
                        ->sortable()
                        ->searchable()
                        ->size('sm')
                        ->color('secondary')
                        ->alignLeft(),
                        
                        Tables\Columns\TextColumn::make('alamat')
                        ->label('Alamat')
                        ->size('sm')
                        ->color('secondary')
                        ->alignLeft(),
                        Tables\Columns\TextColumn::make('nama_kepala')
                        ->label('Nama Kepala')
						->searchable()
                        ->size('sm')
                        ->color('secondary')
                        ->alignLeft(),
                    ]),
                    Tables\Columns\Layout\Stack::make([
                        Tables\Columns\TextColumn::make('st1')
                        ->icon('heroicon-o-question-mark-circle')
                        ->label('Belum Diverifikasi')
                        ->color('warning')
                        ->getStateUsing(function($record) {
                           $tes = $record->laporantargetbenih->where('status','=',null)->count();
                            return "Belum Diverifikasi :".$tes;
                        }),
                        Tables\Columns\TextColumn::make('st2')
                        ->icon('heroicon-o-check')
                        ->label('Terverifikasi')
                        ->color('success')
                        ->getStateUsing(function($record) {
                           $tes1 = $record->laporantargetbenih->where('status','=','active')->count();
                            return "Terverifikasi :".$tes1;
                        }),
                        Tables\Columns\TextColumn::make('st3')
                        ->icon('heroicon-o-ban')
                        ->label('Ditolak')
                        ->color('danger')
                        ->getStateUsing(function($record) {
                           $tes2 = $record->laporantargetbenih->where('status','=','tolak')->count();
                            return "Ditolak :".$tes2;
                        }),
                        Tables\Columns\TextColumn::make('st5')
                        ->icon('heroicon-o-ban')
                        ->label('Diajukan Ulang')
                        ->color('danger')
                        ->getStateUsing(function($record) {
                           $tes3 = $record->laporantargetbenih->where('status','=','reactive')->count();
                            return "Diajukan Ulang :".$tes3;
                        }),
                        Tables\Columns\TextColumn::make('st4')
                        ->icon('heroicon-o-flag')
                        ->label('Selesai')
                        ->getStateUsing(function($record) {
                           $tes4 = $record->laporantargetbenih->where('status','=','selesai')->count();
                            return "Selesai :".$tes4;
                        }),
                        Tables\Columns\TextColumn::make('st5')
                        ->icon('heroicon-o-flag')
                        ->label('Mengetahui BPSB')
                        ->getStateUsing(function($record) {
                           $tes5 = $record->laporantargetbenih->where('mengetahui','=','Diketahui Oleh BPSB')->count();
                            return "Mengetahui BPSB :".$tes5;
                        }),
                    ]), 
                ]),
            ])
            ->filters([
                Filter::make('st1')
                ->label('Belum Terverifikasi')
                ->query(fn (Builder $query): Builder => 
                $query
                ->whereRaw('(select count(target_benih.lembaga_id) from target_benih where target_benih.status is null and target_benih.lembaga_id=lembaga.id) > 0')),
                
                SelectFilter::make('provinces_id')
                    ->label('Pilih Provinsi')
                    ->options(Provinces::pluck('name','id')->toArray()),
				SelectFilter::make('jenis_produsen_id')
                    ->label('Pilih Jenis Produsen')
                    ->options(JenisProdusen::pluck('nama_jenis','id')->toArray())
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
        if(auth()->user()->hasRole("Pelapor") or auth()->user()->hasRole("Produsen Benih")){
        return parent::getEloquentQuery()->where('id',auth()->user()->lembaga_id);
        }else if (auth()->user()->hasRole("Lembaga Sertifikasi Benih")){
            return parent::getEloquentQuery()->where('lembaga_serti_id',auth()->user()->lembaga_id);
        }else{
            return parent::getEloquentQuery()->whereNotNull('jenis_produsen_id');
        } 
    }
    public static function getRelations(): array
    {
        return [
            RelationManagers\LaporanTargetBenihRelationManager::class,
        ];
    }
    protected static function getNavigationBadge(): ?string
    {
    if(auth()->user()->hasRole("Pelapor")){
            return LaporanTargetBenih::where([['lokasi_produksi_detail_id',auth()->user()->lokasi_produksi_detail_id],['status','=','reactive']])
            ->orWhere([['lokasi_produksi_detail_id',auth()->user()->lokasi_produksi_detail_id],['status','=',null]])->count();
        }elseif( auth()->user()->hasRole("Produsen Benih")){
        return LaporanTargetBenih::where([['lembaga_id',auth()->user()->lembaga_id],['status','=','reactive']])
        ->orWhere([['lembaga_id',auth()->user()->lembaga_id],['status','=',null]])->count();
        }elseif(auth()->user()->hasRole("Lembaga Sertifikasi Benih")){
            return LaporanTargetBenih::join('lembaga','lembaga.id','=','target_benih.lembaga_id')
            ->where([['lembaga.lembaga_serti_id',auth()->user()->lembaga_id],['target_benih.status','=','reactive']])
            ->orWhere([['lembaga.lembaga_serti_id',auth()->user()->lembaga_id],['target_benih.status','=',null]])->count();
        }else{
            return LaporanTargetBenih::where('status','=','reactive')->orWhereNull('status')->count();
        }
    }
    protected static function getNavigationBadgeColor(): ?string
    {
        if(auth()->user()->hasRole("Pelapor")){
            return LaporanTargetBenih::where([['lokasi_produksi_detail_id',auth()->user()->lokasi_produksi_detail_id],['status','=','reactive']])
            ->orWhere([['lokasi_produksi_detail_id',auth()->user()->lokasi_produksi_detail_id],['status','=',null]])->count() > 0 ? 'danger' : 'primary';;
        }elseif( auth()->user()->hasRole("Produsen Benih")){
            return LaporanTargetBenih::where([['lembaga_id',auth()->user()->lembaga_id],['status','=','reactive']])
            ->orWhere([['lembaga_id',auth()->user()->lembaga_id],['status','=',null]])->count() > 0 ? 'danger' : 'primary';
        }elseif(auth()->user()->hasRole("Lembaga Sertifikasi Benih")){
            return LaporanTargetBenih::join('lembaga','lembaga.id','=','target_benih.lembaga_id')
            ->where([['lembaga.lembaga_serti_id',auth()->user()->lembaga_id],['target_benih.status','=','reactive']])
            ->orWhere([['lembaga.lembaga_serti_id',auth()->user()->lembaga_id],['target_benih.status','=',null]])->count() > 0 ? 'danger' : 'primary';;
        }else{
            return LaporanTargetBenih::where('status','=','reactive')->orWhereNull('status')->count() > 0 ? 'danger' : 'primary';;
        }
        }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTargetBenihs::route('/'),
            'create' => Pages\CreateTargetBenih::route('/create'),
            'edit' => Pages\EditTargetBenih::route('/{record}/edit'),
        ];
    }    

}
