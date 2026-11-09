<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExportLembagaResource\Pages;
use App\Filament\Resources\ExportLembagaResource\RelationManagers;
use App\Models\ExportLembaga;
use App\Models\Provinces;
use App\Models\Regencies;
use App\Models\Districts;
use App\Models\LembagaSertifikasi;
use App\Models\Villages;
use App\Models\User;
use App\Models\JenisLembaga;
use App\Models\JenisProdusen;
use App\Models\ProdusenBenih;
use App\Models\SaranaLembaga;
use App\Models\SertifikatKompetensi;
use App\Models\LokasiGudangDetail;
use App\Models\LokasiProduksiDetail;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Heloufir\FilamentLeafLetGeoSearch\Forms\Components\LeafletInput;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Filters\Layout;
class ExportLembagaResource extends Resource
{
    protected static ?string $model = ExportLembaga::class;

    protected static ?string $navigationIcon = 'heroicon-o-database';
    protected static ?string $navigationGroup = 'Export';
    protected static ?int $navigationSort = 12;
    protected static ?string $navigationLabel = 'Export Database Produsen/Pengedar Benih';
    // protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Textarea::make('kode_produsen')
                    ->maxLength(16777215),
                Forms\Components\TextInput::make('provinces_id')
                    ->maxLength(255),
                Forms\Components\TextInput::make('regencies_id')
                    ->maxLength(255),
                Forms\Components\Textarea::make('districts_id')
                    ->maxLength(16777215),
                Forms\Components\Textarea::make('villages_id')
                    ->maxLength(16777215),
                Forms\Components\Textarea::make('rt')
                    ->maxLength(16777215),
                Forms\Components\Textarea::make('rw')
                    ->maxLength(16777215),
                Forms\Components\Textarea::make('kodepos')
                    ->maxLength(16777215),
                Forms\Components\Textarea::make('nama_lembaga')
                    ->maxLength(65535),
                Forms\Components\TextInput::make('lembaga_serti_id')
                    ->maxLength(255),
                Forms\Components\TextInput::make('jenis_lembaga_id'),
                Forms\Components\Textarea::make('jenis_produsen_id')
                    ->maxLength(16777215),
                Forms\Components\Textarea::make('smm')
                    ->maxLength(16777215),
                Forms\Components\Textarea::make('sedia_bwg_pth')
                    ->maxLength(16777215),
                Forms\Components\Textarea::make('jenis_kompetensi'),
                Forms\Components\TextInput::make('alamat')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('koordinat')
                    ->maxLength(16777215),
                Forms\Components\Textarea::make('location'),
                Forms\Components\TextInput::make('latitude')
                    ->maxLength(255),
                Forms\Components\TextInput::make('longitude')
                    ->maxLength(255),
                Forms\Components\TextInput::make('nama_kepala')
                    ->maxLength(255),
                Forms\Components\TextInput::make('no_telp')
                    ->tel()
                    ->maxLength(255),
                Forms\Components\Textarea::make('lokasi_produksi_detail_id')
                    ->maxLength(16777215),
                Forms\Components\Textarea::make('lokasi_gudang_detail_id')
                    ->maxLength(16777215),
                Forms\Components\Textarea::make('status')
                    ->maxLength(16777215),
                Forms\Components\Textarea::make('upload')
                    ->maxLength(16777215),
                Forms\Components\Textarea::make('status_stok')
                    ->maxLength(16777215),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                    Tables\Columns\TextColumn::make('nama_lembaga')
                        ->label('Nama Lembaga')
                        ->searchable()
                        ->sortable(),
                    Tables\Columns\TextColumn::make('jenis_lembaga.nama_jenis')
                        ->label('Status Lembaga Produsen/Pengedar')
                        ->sortable()
                        ->searchable(),
                    Tables\Columns\TextColumn::make('jenis_produsen.nama_jenis')
                        ->label('Jenis Produsen/Pengedar')
                        ->sortable()
                        ->searchable(),
                    Tables\Columns\TextColumn::make('provinces.name')
                        ->label('Nama Provinsi')
                        ->searchable(),
                    Tables\Columns\TextColumn::make('regencies.name')
                        ->label('Nama Kabupaten/Kota')
                        ->searchable(),
                    Tables\Columns\TextColumn::make('districts.name')
                        ->label('Nama Kecamatan')
                        ->searchable(),
                    Tables\Columns\TextColumn::make('villages.name')
                        ->label('Nama Desa/Kelurahan')
                        ->sortable()
                        ->searchable(),
                    Tables\Columns\TextColumn::make('nama_kepala')
                        ->label('Nama Kepala Lembaga')
                        ->searchable()
                        ->getStateUsing( function ($record){
                            $kepala = $record->nama_kepala;
                            return $kepala;
                        }),
                    Tables\Columns\TextColumn::make('no_telp')
                        ->label('No. Telepon')
                        ->getStateUsing( function ($record){
                            $tel = $record->no_telp;
                            return $tel;
                        }),
                    Tables\Columns\TextColumn::make('alamat')
                        ->label('Alamat')
                        ->getStateUsing( function ($record){
                            $alamat = $record->alamat;
                            return $alamat;
                        }),
                    Tables\Columns\TextColumn::make('rt')
                        ->label('RT')
                        ->getStateUsing( function ($record){
                            $rt = $record->rt;
                            return $rt;
                        }),
                    Tables\Columns\TextColumn::make('rw')
                        ->label('RW')
                        ->getStateUsing( function ($record){
                            $rw = $record->rw;
                            return $rw;
                        }), 
                    Tables\Columns\TextColumn::make('kodepos')
                        ->label('Kode Pos')
                    ->getStateUsing( function ($record){
                        $pos = $record->kodepos;
                        return $pos;
                    }),
                    Tables\Columns\TextColumn::make('link')
                        ->getStateUsing(function($record) {
                            return "Lihat Detail Lembaga";
                    })
                    ->url(function($record){
                        return "/detail-produsen/$record->id";
                    })
                    ->openUrlInNewTab(),
            ])
            ->filters([
                 SelectFilter::make('provinces_id')
				 ->searchable()
                ->label('Provinsi')
                ->options(function () {
                    return Provinces::all()->pluck('name', 'id')->toArray();
                }), // Set the selected value
            SelectFilter::make('jenis_lembaga_id')
                ->label('Status Lembaga')
				->searchable()
                ->options(function () {
                    return JenisLembaga::whereNotIn('id', [1,7])->pluck('nama_jenis', 'id')->toArray();
                }), // Set the selected value
                SelectFilter::make('jenis_produsen_id')
				->searchable()
                ->label('Jenis Produsen/Pengedar')
                ->options(function () {
                    return JenisProdusen::all()->pluck('nama_jenis', 'id')->toArray();
                }), // Set the selected value
            ],layout: Layout::AboveContent,)
            ->actions([
                //Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                //Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    public static function canEdit(Model $record): bool
    {
        return false;
    }
    public static function getRelations(): array
    {
        return [
            //
        ];
    }
     public static function getEloquentQuery(): Builder
    {
         if(auth()->user()->hasRole("Pelapor") or auth()->user()->hasRole("Produsen Benih")){
        return parent::getEloquentQuery()->where('id',auth()->user()->lembaga_id)->whereNotIn('jenis_lembaga_id', [1,7]);
        }else if (auth()->user()->hasRole("Lembaga Sertifikasi Benih")){
            return parent::getEloquentQuery()->where('lembaga_serti_id',auth()->user()->lembaga_id)->whereNotIn('jenis_lembaga_id', [1,7]);
        }else{
            return parent::getEloquentQuery()->whereNotIn('jenis_lembaga_id', [1,7]);
        } 
		
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListExportLembagas::route('/'),
            'create' => Pages\CreateExportLembaga::route('/create'),
            'edit' => Pages\EditExportLembaga::route('/{record}/edit'),
        ];
    }    
}
