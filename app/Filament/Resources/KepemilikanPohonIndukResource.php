<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KepemilikanPohonIndukResource\Pages;
use App\Filament\Resources\KepemilikanPohonIndukResource\RelationManagers;
use App\Models\KepemilikanPohonInduk;
use App\Models\Provinces;
use App\Models\Regencies;
use App\Models\Districts;
use App\Models\Villages;
use App\Models\LembagaSertifikasi;
use App\Models\ProdusenBenih;
use App\Models\JenisLembaga;
use App\Models\JenisProdusen;
use App\Models\JenisPemilik;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Heloufir\FilamentLeafLetGeoSearch\Forms\Components\LeafletInput;
use Closure;

class KepemilikanPohonIndukResource extends Resource
{
    // protected static bool $shouldRegisterNavigation = false;
    protected static ?string $model = KepemilikanPohonInduk::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';
    protected static ?string $navigationGroup = 'Tanaman Induk';
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationLabel = 'Pemilik Tanaman Induk';
    public static function form(Form $form): Form
    {
        if(auth()->user()->lembaga_id){
            $saya = auth()->user()->lembaga_id;
            $lembaga = LembagaSertifikasi::where('id',$saya)->first();
            $lemprov = $lembaga->provinces_id;
            }
            if (auth()->user()->hasRole("Lembaga Sertifikasi Benih")){
        return $form
        ->schema([
            Forms\Components\Toggle::make('dapat_lapor')
                        ->label('Pelaporan dapat dilaporkan oleh lembaga produsen?')
                        ->reactive()
                        ->requiredWith('lembaga_id')
                        ->afterStateUpdated(
                            fn ($state, callable $set) => $state ? $set('lembaga_id', null) : $set('lembaga_id', 'hidden')
                        ),
                        Forms\Components\Select::make('lembaga_id')
                        ->options(function(callable $get){
                            return ProdusenBenih::where('lembaga_serti_id',$get('lembaga_serti_id'))
                            ->pluck('nama_lembaga','id')->toArray();
                        })
                        ->afterStateUpdated(function (Closure $set, $state) {
                            $tes =  ProdusenBenih::where('id',$state)->first();
                            $set('provinces_id',$tes->provinces_id);
                            $set('regencies_id',$tes->regencies_id);
                            $set('districts_id',$tes->districts_id);
                            $set('villages_id',$tes->villages_id);
                            $set('nama_lembaga',$tes->nama_lembaga);
                            $set('alamat',$tes->alamat);
                            $set('rt',$tes->rt);
                            $set('rw',$tes->rw);
                            $set('kodepos',$tes->kodepos);
                            $set('nama_kepala',$tes->nama_kepala);
                            $set('no_telp',$tes->no_telp);
                            $set('location',$tes->location);
                            $set('latitude',$tes->latitude);
                            $set('longitude',$tes->longitude);
                        })
                        ->reactive()
                        ->searchable()
                        ->requiredWith('dapat_lapor')
                        ->label('Nama Lembaga')
                        ->hidden(
                            fn (Closure $get): bool => $get('dapat_lapor') == false
                        ), 
            Forms\Components\Select::make('provinces_id')
                    ->label('Provinsi')
                    ->options(Provinces::where('id',$lemprov)->pluck('name','id')->toArray())
                    ->reactive()
                    ->required()
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
                ->required()
                ->reactive()
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
                ->required()
                ->reactive()
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
                ->required()
                    ->reactive(),
                    Forms\Components\Select::make('lembaga_serti_id')
                    ->label('Lembaga Sertifikasi')
                    ->options(function(callable $get){
                        $saya = auth()->user()->lembaga_id;
                        if(!$get('provinces_id')){
                            return null;
                        }
                        return LembagaSertifikasi::where('id',$saya)
                        ->pluck('nama_lembaga','id');
                    })
                        ->required()->reactive(),    
            Forms\Components\TextInput::make('nama_lembaga')
            ->label('Nama Pemilik')
            ->required(),
            Forms\Components\Select::make('jenis_pemilik_id')
            ->label('Jenis Kepemilikan')
            ->options(JenisPemilik::all()->pluck('nama_jenis','id')->toArray())
            ->required()
            ->reactive(),
            Forms\Components\Textarea::make('alamat')
            ->label('Alamat')
            ->required(),
            Forms\Components\TextInput::make('rt')
            ->label('RT')
            ->required(),
            Forms\Components\TextInput::make('rw')
            ->label('RW')
            ->required(),
            Forms\Components\TextInput::make('kodepos')
            ->label('Kode Pos')
            ->required(),
            Forms\Components\TextInput::make('nama_kepala')
            ->label('Nama Pemilik Pohon')
            ->required(),
            Forms\Components\TextInput::make('no_telp')
            ->label('No. Telp')
            ->required()
            ->tel()
            ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/'),
            Forms\Components\Card::make()
                ->schema([
                Forms\Components\FileUpload::make('upload')
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
						->afterStateUpdated(function ($state, $set) {
							$result = json_encode($state);
							$obj = json_decode($result);
                            if(isset($obj->y)){
                                $set('latitude', $obj->y);
                                $set('longitude', $obj->x);
                            }else{
                                $set('latitude', $state['lat']);
                                $set('longitude', $state['lng']);
                            }
						 	
						}),
                    ])->columns(1),
                Forms\Components\TextInput::make('latitude')->required(),
                Forms\Components\TextInput::make('longitude')->required(),
                    ])
                    ->columns(2);
                        }else{
                            return $form
        ->schema([
                Forms\Components\Toggle::make('dapat_lapor')
                        ->label('Pelaporan dapat dilaporkan oleh lembaga produsen?')
                        ->reactive()
                        ->requiredWith('lembaga_id')
                        ->afterStateUpdated(
                            fn ($state, callable $set) => $state ? $set('lembaga_id', null) : $set('lembaga_id', 'hidden')
                        ),
                        Forms\Components\Select::make('lembaga_id')
                        ->options(function(callable $get){
                            return ProdusenBenih::where('jenis_lembaga_Id',[2,6])
                            ->pluck('nama_lembaga','id')->toArray();
                        })
                        ->afterStateUpdated(function (Closure $set, $state) {
                            $tes =  ProdusenBenih::where('id',$state)->first();
                            $set('provinces_id',$tes->provinces_id);
                            $set('lembaga_serti_id',$tes->lembaga_serti_id);
                            $set('regencies_id',$tes->regencies_id);
                            $set('districts_id',$tes->districts_id);
                            $set('villages_id',$tes->villages_id);
                            $set('nama_lembaga',$tes->nama_lembaga);
                            $set('alamat',$tes->alamat);
                            $set('rt',$tes->rt);
                            $set('rw',$tes->rw);
                            $set('kodepos',$tes->kodepos);
                            $set('nama_kepala',$tes->nama_kepala);
                            $set('no_telp',$tes->no_telp);
                            $set('location',$tes->location);
                            $set('latitude',$tes->latitude);
                            $set('longitude',$tes->longitude);
                        })
                        ->reactive()
                        ->searchable()
                        ->requiredWith('dapat_lapor')
                        ->label('Nama Lembaga')
                        ->hidden(
                            fn (Closure $get): bool => $get('dapat_lapor') == false
                        ), 
            Forms\Components\Select::make('provinces_id')
                ->label('Provinsi')
                ->options(Provinces::all()->pluck('name','id')->toArray())
                ->reactive()
                ->required()
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
                    ->reactive()->required(),
            Forms\Components\Select::make('lembaga_serti_id')
                    ->label('Lembaga Sertifikasi')
                    ->options(function(callable $get){
                        if(!$get('provinces_id')){
                            return null;
                        }
                        return LembagaSertifikasi::where('provinces_id',$get('provinces_id'))
                        ->whereNotIn('jenis_lembaga_id',[2,6])
                        ->pluck('nama_lembaga','id');
                    })
                        ->required(),
                            
            Forms\Components\TextInput::make('nama_lembaga')
            ->label('Nama Pemilik')
            ->required(),
            Forms\Components\Select::make('jenis_pemilik_id')
            ->label('Jenis Kepemilikan')
            ->options(JenisPemilik::all()->pluck('nama_jenis','id')->toArray())
            ->reactive()->required(),
            Forms\Components\Textarea::make('alamat')
            ->label('Alamat')
            ->required(),
            Forms\Components\TextInput::make('rt')
            ->label('RT')
            ->required(),
            Forms\Components\TextInput::make('rw')
            ->label('RW')
            ->required(),
            Forms\Components\TextInput::make('kodepos')
            ->label('Kode Pos')
            ->required(),
            Forms\Components\TextInput::make('nama_kepala')
            ->label('Nama Pemilik Pohon')
            ->required(),
            Forms\Components\TextInput::make('no_telp')
            ->label('No. Telp')
            ->required()
            ->tel()
            ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/'),
            Forms\Components\Card::make()
                ->schema([
                Forms\Components\FileUpload::make('upload')
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
						->afterStateUpdated(function ($state, $set) {
							$result = json_encode($state);
							$obj = json_decode($result);
                            if(isset($obj->y)){
                                $set('latitude', $obj->y);
                                $set('longitude', $obj->x);
                            }else{
                                $set('latitude', $state['lat']);
                                $set('longitude', $state['lng']);
                            }
						 	
						}),
                    ])->columns(1),
                Forms\Components\TextInput::make('latitude')->required(),
                Forms\Components\TextInput::make('longitude')->required(),
                    ])
                    ->columns(2);
                        }
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
                        // Tables\Columns\TextColumn::make('jenis_pemilik.nama_jenis')
                        // ->sortable()
                        // ->label('Jenis Kepemilikan Pohon Induk')
                        // ->getStateUsing( function ($record){
                        //     $jp = $record->jenis_pemilik->nama_jenis;
                        //     return "Jenis Kepemilikan Pohon".$jp;
                        // }),
                    ]),
                    Tables\Columns\Layout\Stack::make([
                        Tables\Columns\TextColumn::make('prv')
                            ->getStateUsing(function($record) {
                                return "Provinsi : ";
                        }),
                        Tables\Columns\TextColumn::make('provinces.name')
                            ->label('Nama Provinsi')
                            ->sortable()
                            ->searchable()
                            ->alignLeft()
                            ->size('sm')
                            ->color('secondary'),
                        Tables\Columns\TextColumn::make('kb')
                            ->getStateUsing(function($record) {
                                return "Kabupaten/Kota : ";
                        }),
                        Tables\Columns\TextColumn::make('regencies.name')
                            ->label('Nama Kabupaten/Kota')
                            ->sortable()
                            ->searchable()
                            ->alignLeft()
                            ->size('sm')
                            ->color('secondary'),
                        Tables\Columns\TextColumn::make('kc')
                            ->getStateUsing(function($record) {
                                return "Kecamatan : ";
                        }),
                        Tables\Columns\TextColumn::make('districts.name')
                            ->label('Nama Kecamatan')
                            ->sortable()
                            ->searchable()
                            ->alignLeft()
                            ->size('sm')
                            ->color('secondary'),
                        Tables\Columns\TextColumn::make('ds')
                            ->getStateUsing(function($record) {
                                return "Desa : ";
                        }),
                        Tables\Columns\TextColumn::make('villages.name')
                            ->label('Nama Desa/Kelurahan')
                            ->sortable()
                            ->searchable()
                            ->alignLeft()
                            ->size('sm')
                            ->color('secondary'),
                
                    ]),
                    Tables\Columns\Layout\Stack::make([
                        Tables\Columns\TextColumn::make('tes')
                            ->getStateUsing(function($record) {
                                return "Nama Pemilik Pohon : ";
                        }),
                        Tables\Columns\TextColumn::make('nama_kepala')
                            ->label('Nama Pemilik Pohon')
							->searchable()
                            ->alignLeft(),
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
                //
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
            //
        ];
    }
    public static function getEloquentQuery(): Builder
    {
        if (auth()->user()->hasRole("Lembaga Sertifikasi Benih")){
            return parent::getEloquentQuery()->where('lembaga_serti_id',auth()->user()->lembaga_id);
        }else{
            return parent::getEloquentQuery();
        } 
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKepemilikanPohonInduks::route('/'),
            'create' => Pages\CreateKepemilikanPohonInduk::route('/create'),
            'edit' => Pages\EditKepemilikanPohonInduk::route('/{record}/edit'),
        ];
    }    
}