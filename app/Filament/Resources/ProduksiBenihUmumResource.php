<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProduksiBenihUmumResource\Pages;
use App\Filament\Resources\ProduksiBenihUmumResource\RelationManagers;
use App\Models\ProduksiBenihUmum;
use App\Models\LaporanProduksiSwadaya;
use App\Models\Provinces;
use App\Models\Regencies;
use App\Models\Districts;
use App\Models\Villages;
use App\Models\JenisLembaga;
use App\Models\JenisProdusen;
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
class ProduksiBenihUmumResource extends Resource
{
    protected static ?string $model = ProduksiBenihUmum::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';
    protected static ?string $navigationGroup = 'Produksi dan Kegiatan Sertifikasi Benih';
    protected static ?int $navigationSort = 9;
    protected static ?string $navigationLabel = 'Label Produksi Benih';

    // protected static bool $shouldRegisterNavigation = false;
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('provinces_id')
                    ->label('Provinsi')
                    ->options(Provinces::all()->pluck('name','id')->toArray())
                    ->reactive()
                    ->required()
                    ->disabled()
                    ->afterStateUpdated(fn (callable $set) => $set('regencies_id',null)),
                Forms\Components\Select::make('regencies_id')
                    ->label('Kabupaten')
                    ->options(function(callable $get){
                        $provinces = Provinces::find($get('provinces_id'));
                        if(!$provinces){
                            return null;
                        }
                        return $provinces->regencies->pluck('name','id');
                    })
                    ->reactive()
                    ->disabled()
                    ->required()
                    ->afterStateUpdated(fn (callable $set) => $set('districts_id',null)),
                Forms\Components\Select::make('districts_id')
                    ->label('Kecamatan')
                    ->options(function(callable $get){
                        $regencies = Regencies::find($get('regencies_id'));
                        if(!$regencies){
                            return null;
                        }
                        return $regencies->districts->pluck('name','id');
                    })
                    ->reactive()
                    ->disabled()
                    ->required()
                    ->afterStateUpdated(fn (callable $set) => $set('villages_id',null)),
                Forms\Components\Select::make('villages_id')
                    ->label('Desa')
                    ->options(function(callable $get){
                        $districts = Districts::find($get('districts_id'));
                        if(!$districts){
                            return null;
                        }
                        return $districts->villages->pluck('name','id');
                    })
                    ->reactive()
                    ->disabled()
                    ->required(),
                    Forms\Components\TextInput::make('nama_lembaga')
                        ->label('Nama Lembaga')
                        ->disabled()
                        ->required(),
                    Forms\Components\Select::make('jenis_lembaga_id')
                        ->label('Jenis Lembaga')
                        ->options(JenisLembaga::whereIn('id',[2,6])->pluck('nama_jenis','id')->toArray())
                        ->disabled()
                        ->required(),
                    Forms\Components\Select::make('jenis_produsen_id')
                        ->label('Jenis Produsen')
                        ->relationship('jenis_produsen','nama_jenis')
                        ->disabled()
                        ->required(),
                    Forms\Components\TextInput::make('nama_kepala')
                        ->label('Nama Kepala Lembaga')
                        ->disabled()
                        ->required(),
                    Forms\Components\Textarea::make('alamat')
                        ->label('Alamat')
                        ->disabled()
                        ->required(),
                    Forms\Components\TextInput::make('rt')
                        ->label('RT')
                        ->disabled()
                        ->required(),
                    Forms\Components\TextInput::make('rw')
                        ->label('RW')
                        ->disabled()
                        ->required(),
                    Forms\Components\TextInput::make('kodepos')
                        ->label('Kode Pos')
                        ->disabled()
                        ->required(),
                    Forms\Components\TextInput::make('no_telp')
                        ->label('No. Telp')
                        ->required()->disabled()
                        ->tel()
                        ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/'),
                    Forms\Components\Card::make()
                        ->schema([
                    Forms\Components\FileUpload::make('upload')
                    ->disabled()
                    ->label("Upload Foto Lembaga")
                    ->enableDownload()
                    ->enableOpen(),
                Forms\Components\FileUpload::make('logo')
                ->disabled()
                ->label("Upload Logo")
                ->enableDownload()
                ->enableOpen(),
                Forms\Components\FileUpload::make('stempel')
                ->disabled()
                ->label("Upload Stempel")
                ->enableDownload()
                ->enableOpen(),
                    ])
                    ->columns(1),
                    Forms\Components\Card::make()
                        ->schema([
                            LeafletInput::make('location')
                            ->setMapHeight(300) // Here you can specify a map height in pixels, by default the height is equal to 200
                            ->setZoomControl(true) // Here you can enable/disable zoom control on the map (default: true)
                            ->setScrollWheelZoom(true)
                            ->setZoomLevel(3) // Here you can change the default zoom level (when the map is loaded for the first time), default value is 10
                            ->reactive()
                            ->disabled()
                            ->afterStateUpdated(function ($state, $set) {
                                $result = json_encode($state);
                                $obj = json_decode($result);
                                if(isset($obj->y)){$teslat = $obj->y;}else{$teslat = $obj->lat;};
                                if(isset($obj->x)){$teslng = $obj->x;}else{$teslng = $obj->lng;};
                                 $set('latitude', $teslat);
                                $set('longitude', $teslng);
                                }),
                        ])->columns(1),
                    Forms\Components\TextInput::make('latitude')
                        ->required()
                        ->disabled(),
                    Forms\Components\TextInput::make('longitude')
                        ->required()
                        ->disabled(),
                        ])
                        ->columns(2);
    }

    public static function table(Table $table): Table
    {
       return $table
            ->columns([
                Tables\Columns\Layout\Split::make([
                    Tables\Columns\Layout\Stack::make([
                        Tables\Columns\TextColumn::make('nama_lembaga')
                            ->label('Nama Lembaga')
                            ->searchable()
                            ->sortable(),
                        Tables\Columns\TextColumn::make('jenis_lembaga.nama_jenis')
                            ->label('Jenis Lembaga')
                            ->size('sm')
                            ->color('secondary')
                            ->alignLeft(),
                        Tables\Columns\TextColumn::make('jenis_produsen.nama_jenis')
                            ->label('Jenis Produsen')
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
                            ->alignLeft()
							->searchable()
                            ->size('sm')
                            ->color('secondary')
                            ->getStateUsing( function ($record){
                                $prov = $record->provinces->name;
                                return $prov;
                            }),
                        Tables\Columns\TextColumn::make('kb')
                            ->getStateUsing(function($record) {
                                return "Kabupaten/Kota : ";
                        }),
                        Tables\Columns\TextColumn::make('regencies.name')
                            ->label('Nama Kabupaten/Kota')
                            ->alignLeft()
                            ->size('sm')
                            ->color('secondary')
                            ->getStateUsing( function ($record){
                                $kab = $record->regencies->name ?? null;
                                return $kab;
                            }),
                        Tables\Columns\TextColumn::make('kc')
                            ->getStateUsing(function($record) {
                                return "Kecamatan : ";
                        }),
                        Tables\Columns\TextColumn::make('districts.name')
                            ->label('Nama Kecamatan')
                            ->alignLeft()
                            ->size('sm')
                            ->color('secondary')
                            ->getStateUsing( function ($record){
                                $kec = $record->districts->name;
                                return $kec;
                            }),
                        Tables\Columns\TextColumn::make('ds')
                            ->getStateUsing(function($record) {
                                return "Desa : ";
                        }),
                        Tables\Columns\TextColumn::make('villages.name')
                            ->label('Nama Desa/Kelurahan')
                            ->alignLeft()
                            ->size('sm')
                            ->color('secondary')
                            ->getStateUsing( function ($record){
                                $des = $record->villages->name;
                                return $des;
                            }),
                
                    ]),
                    Tables\Columns\Layout\Stack::make([
                        Tables\Columns\TextColumn::make('tes')
                            ->getStateUsing(function($record) {
                                return "Nama Kepala Lembaga : ";
                        }),
                        Tables\Columns\TextColumn::make('nama_kepala')
                            ->label('Nama Kepala Lembaga')
                            ->alignLeft()
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
                ]),
                
            ])
            ->filters([
                
                SelectFilter::make('jenis_produsen_id')
                ->label('Jenis Produsen/Pengedar')
                ->options(JenisProdusen::all()->pluck('nama_jenis','id')->toArray()),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            RelationManagers\LaporanProduksiSwadayaRelationManager::class,
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProduksiBenihUmums::route('/'),
            'create' => Pages\CreateProduksiBenihUmum::route('/create'),
            'edit' => Pages\EditProduksiBenihUmum::route('/{record}/edit'),
        ];
    } public static function getEloquentQuery(): Builder
    {
        if(auth()->user()->hasRole("Pelapor") or auth()->user()->hasRole("Produsen Benih")){
        return parent::getEloquentQuery()->where('id',auth()->user()->lembaga_id);
        }else if (auth()->user()->hasRole("Lembaga Sertifikasi Benih")){
            return parent::getEloquentQuery()->where('lembaga_serti_id',auth()->user()->lembaga_id);
        }else{
            return parent::getEloquentQuery()->where('jenis_lembaga_id','!=',1)->whereNotNull('jenis_produsen_id');
        } 
    }    
}
