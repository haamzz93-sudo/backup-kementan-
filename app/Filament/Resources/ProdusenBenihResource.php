<?php

namespace App\Filament\Resources;
use App\Filament\Resources\ProdusenBenihResource\Widgets;
use App\Filament\Resources\ProdusenBenihResource\Pages;
use App\Filament\Resources\ProdusenBenihResource\RelationManagers;
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
use Illuminate\Database\Eloquent\Collection;


class ProdusenBenihResource extends Resource
{
    // protected static bool $shouldRegisterNavigation = false;
    protected static ?string $model = ProdusenBenih::class;
    protected static ?string $navigationIcon = 'heroicon-o-badge-check';
    protected static ?string $navigationGroup = 'Lembaga';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationLabel = 'Produsen/Pengedar Benih';

    public static function form(Form $form): Form
    {
        if(isset (auth()->user()->lembaga_id)){
        $saya = auth()->user()->lembaga_id;
        $lembaga = LembagaSertifikasi::where('id',$saya)->first();
        $lemprov = $lembaga->provinces_id;
        $lemid = $lembaga->id;
        }
        if (auth()->user()->hasRole("Lembaga Sertifikasi Benih")){
            //lembaga sertifikasi
        return $form
            ->schema([
                Forms\Components\Select::make('provinces_id')
                    ->label('Provinsi')
                    ->options(function(){
						$saya = auth()->user()->lembaga_id;
						$lembaga = LembagaSertifikasi::where('id',$saya)->first();
						if($lembaga->jenis_lembaga_id==7){
							return Provinces::all()->pluck('name','id')->toArray();
						}else{
							return Provinces::where('id',$lembaga->provinces_id)->pluck('name','id')->toArray();
						}
						
					})
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
                        ->reactive()
                        ->required(),
                Forms\Components\Select::make('lembaga_serti_id')
                    ->label('Lembaga Penjamin Sertifikasi')
                    ->options(function(callable $get){
                        $saya = auth()->user()->lembaga_id;
                        if(!$get('provinces_id')){
                            return null;
                        }
                        return LembagaSertifikasi::where('id',$saya)
                        ->pluck('nama_lembaga','id');
                    })
                    ->required(),
                Forms\Components\TextInput::make('nama_lembaga')
                    ->label('Nama Lembaga')
                    ->required(),
                Forms\Components\Select::make('jenis_lembaga_id')
                    ->label('Status Lembaga Produsen/Pengedar')
                    ->options(JenisLembaga::whereIn('id',[2,6,8])->pluck('nama_jenis','id')->toArray())
                    ->required(),
                Forms\Components\Select::make('jenis_produsen_id')
                    ->label('Jenis Produsen/Pengedar')
                    ->relationship('jenis_produsen','nama_jenis')
                    ->required(),
                Forms\Components\Toggle::make('smm')
                    ->label('Bisa Melakukan Sertifikasi Benih Secara Mandiri?'),
                Forms\Components\CheckboxList::make('jenis_kompetensi')
                    ->label('Jenis Kompetensi')
                    ->options([
                        'produsen' => 'Produsen',
                        'pengedar' => 'Pengedar',
                    ]),
                Forms\Components\Textarea::make('alamat')
                    ->label('Alamat')
                    ->required(),
                Forms\Components\TextInput::make('rt')
                    ->label('RT')
                    ->numeric()
                    ->required(),
                Forms\Components\TextInput::make('rw')
                    ->label('RW')
                    ->numeric()
                    ->required(),
                Forms\Components\TextInput::make('kodepos')
                    ->label('Kode Pos')
                    ->numeric()
                    ->required(),
                Forms\Components\TextInput::make('nama_kepala')
                    ->label('Nama Pemilik/Kepala Produsen')
                    ->required(),
                Forms\Components\TextInput::make('no_telp')
                    ->label('No. Telp')
                    ->required()
                    ->tel()
                    ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/'),
                Forms\Components\Card::make()
                    ->schema([
                Forms\Components\FileUpload::make('upload')
                ->label('Upload Foto Produsen')
                ->enableDownload()
                ->enableOpen(),
                Forms\Components\FileUpload::make('logo')
                ->label('Upload Logo')
                ->placeholder('Format Logo PNG dan Berlatar Transparan')
                ->acceptedFileTypes(['image/png'])
                ->enableDownload()
                ->enableOpen(),
                Forms\Components\FileUpload::make('stempel')
                ->label('Upload Stempel')
                ->placeholder('Format Logo PNG dan Berlatar Transparan')
                ->acceptedFileTypes(['image/png'])
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
                Forms\Components\TextInput::make('latitude')
                    ->required(),
                Forms\Components\TextInput::make('longitude')
                    ->required(),
                    ])
                    ->columns(2);
        }else if(auth()->user()->hasRole("Pelapor") or auth()->user()->hasRole("Produsen Benih")){
        //produsen
            return $form
        ->schema([
                Forms\Components\Select::make('provinces_id')
                    ->label('Provinsi')
                    ->options(Provinces::all()->pluck('name','id')->toArray())
                    ->reactive()
                    ->disabled()
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
                    ->disabled()
                    ->required()
                    ->reactive(),
                Forms\Components\Select::make('lembaga_serti_id')
                    ->label('Lembaga Penjamin Sertifikasi')
                    ->options(function(callable $get){
                        if(!$get('provinces_id')){
                            return null;
                        }
                        return LembagaSertifikasi::where('provinces_id',$get('provinces_id'))
                        ->whereNotIn('jenis_lembaga_id',[2,6])
                        ->pluck('nama_lembaga','id');
                    })
                    ->disabled()
                    ->required(),
                Forms\Components\TextInput::make('nama_lembaga')
                    ->label('Nama Lembaga')
                    ->required(),
                Forms\Components\Select::make('jenis_lembaga_id')
                    ->label('Status Lembaga Produsen/Pengedar')
                    ->disabled()
                    ->required()
                    ->options(JenisLembaga::whereIn('id',[2,6,8])->pluck('nama_jenis','id')->toArray()),
                Forms\Components\Select::make('jenis_produsen_id')
                    ->label('Jenis Produsen/Pengedar')
                    ->disabled()
                    ->required()
                    ->relationship('jenis_produsen','nama_jenis'),
                Forms\Components\Toggle::make('smm')
                    ->label('Bisa Melakukan Sertifikasi Benih Secara Mandiri?'),
                Forms\Components\CheckboxList::make('jenis_kompetensi')
                    ->label('Jenis Kompetensi')
                    ->options([
                        'produsen' => 'Produsen',
                        'pengedar' => 'Pengedar',
                    ]),
                Forms\Components\Textarea::make('alamat')
                    ->label('Alamat')
                    ->required(),
                Forms\Components\TextInput::make('rt')
                    ->label('RT')
                    ->numeric()
                    ->required(),
                Forms\Components\TextInput::make('rw')
                    ->label('RW')
                    ->numeric()
                    ->required(),
                Forms\Components\TextInput::make('kodepos')
                    ->label('Kode Pos')
                    ->numeric()
                    ->required(),
                Forms\Components\TextInput::make('nama_kepala')
                    ->label('Nama Pemilik/Kepala Produsen')
                    ->required(),
                Forms\Components\TextInput::make('no_telp')
                    ->label('No. Telp')
                    ->required()
                    ->tel()
                    ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/'),
                Forms\Components\Card::make()
                    ->schema([
                Forms\Components\FileUpload::make('upload')
                ->label('Upload Foto Produsen')
                ->enableDownload()
                ->enableOpen(),
                Forms\Components\FileUpload::make('logo')
                ->label('Upload Logo')
                ->placeholder('Format Logo PNG dan Berlatar Transparan')
                ->acceptedFileTypes(['image/png'])
                ->enableDownload()
                ->enableOpen(),
                Forms\Components\FileUpload::make('stempel')
                ->label('Upload Stempel')
                ->placeholder('Format Logo PNG dan Berlatar Transparan')
                ->acceptedFileTypes(['image/png'])
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
                Forms\Components\TextInput::make('latitude')
                    ->required(),
                Forms\Components\TextInput::make('longitude')
                    ->required(),
                    ])
                    ->columns(2);
                }else{
                    //pusat
                    return $form
        ->schema([
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
                    ->reactive()
                    ->required(),
                Forms\Components\Select::make('lembaga_serti_id')
                    ->label('Lembaga Penjamin Sertifikasi')
                    ->options(function(callable $get){
                        if(!$get('provinces_id')){
                            return null;
                        }
                        return LembagaSertifikasi::whereNotIn('jenis_lembaga_id',[2,6])
                        ->pluck('nama_lembaga','id');
                    })
					->searchable()
                    ->required(),
                Forms\Components\TextInput::make('nama_lembaga')
                    ->label('Nama Lembaga')
                    ->required(),
                Forms\Components\Select::make('jenis_lembaga_id')
                    ->label('Status Lembaga Produsen/Pengedar')
                    ->options(JenisLembaga::whereIn('id',[2,6,8])->pluck('nama_jenis','id')->toArray())
                    ->required(),
                Forms\Components\Select::make('jenis_produsen_id')
                    ->label('Jenis Produsen/Pengedar')
                    ->relationship('jenis_produsen','nama_jenis')
                    ->required(),
                Forms\Components\Toggle::make('smm')
                    ->label('Bisa Melakukan Sertifikasi Benih Secara Mandiri?'),
                Forms\Components\CheckboxList::make('jenis_kompetensi')
                    ->label('Jenis Kompetensi')
                    ->options([
                        'produsen' => 'Produsen',
                        'pengedar' => 'Pengedar',
                    ]),
                Forms\Components\Textarea::make('alamat')
                    ->label('Alamat')
                    ->required(),
                Forms\Components\TextInput::make('rt')
                    ->label('RT')
                    ->numeric()
                    ->required(),
                Forms\Components\TextInput::make('rw')
                    ->label('RW')
                    ->numeric()
                    ->required(),
                Forms\Components\TextInput::make('kodepos')
                    ->label('Kode Pos')
                    ->numeric()
                    ->required(),
                Forms\Components\TextInput::make('nama_kepala')
                    ->label('Nama Kepala Lembaga')
                    ->required(),
                Forms\Components\TextInput::make('no_telp')
                    ->label('No. Telp')
                    ->required()
                    ->tel()
                    ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/'),
                Forms\Components\Card::make()
                    ->schema([
                Forms\Components\FileUpload::make('upload')
                
                ->label('Upload Foto Produsen')
                ->enableDownload()
                ->enableOpen(),
                Forms\Components\FileUpload::make('logo')
                ->label('Upload Logo')
                ->placeholder('Format Logo PNG dan Berlatar Transparan')
                ->acceptedFileTypes(['image/png'])
                ->enableDownload()
                ->enableOpen(),
                Forms\Components\FileUpload::make('stempel')
                ->label('Upload Stempel')
                ->placeholder('Format Logo PNG dan Berlatar Transparan')
                ->acceptedFileTypes(['image/png'])
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
                Forms\Components\TextInput::make('latitude')
                    ->required(),
                Forms\Components\TextInput::make('longitude')
                    ->required(),
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
                        Tables\Columns\TextColumn::make('kode_produsen')
                            ->label('Kode Produsen')
                            ->sortable()
                            ->searchable()
                            ->getStateUsing( function ($record){
                                $kp = $record->kode_produsen;
                                return "Kode Produsen/Pengedar: ".$kp;
                            }),
                        Tables\Columns\TextColumn::make('nama_lembaga')
                            ->label('Nama Lembaga')
                            ->searchable()
                            ->sortable(),
                        Tables\Columns\TextColumn::make('jenis_lembaga.nama_jenis')
                            ->label('Status Lembaga Produsen/Pengedar')
                            ->sortable()
                            ->searchable()
                            ->size('sm')
                            ->color('secondary')
                            ->alignLeft(),
                        Tables\Columns\TextColumn::make('jenis_produsen.nama_jenis')
                            ->label('Jenis Produsen/Pengedar')
                            ->sortable()
                            ->searchable()
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
                                return "Nama Kepala Lembaga : ";
                        }),
                        Tables\Columns\TextColumn::make('nama_kepala')
                            ->label('Nama Kepala Lembaga')
                            ->alignLeft()
							->searchable()
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
                ->options(JenisProdusen::all()->pluck('nama_jenis','id')->toArray())->multiple(),
                SelectFilter::make('provinces_id')
                ->label('Provinsi')
                ->options(Provinces::all()->pluck('name','id')->toArray())->multiple(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('QRCode')
                    ->url(fn (ProdusenBenih $record): string => route('produsen-benihs', $record))
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\SaranaLembagaRelationManager::class,
            RelationManagers\LokasiProduksiDetailRelationManager::class,
            RelationManagers\SertifikatKompetensiRelationManager::class,
            RelationManagers\LokasiGudangDetailRelationManager::class,
            RelationManagers\AdminProdusenRelationManager::class,
            RelationManagers\AdminPelaporRelationManager::class,
        ];
        
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProdusenBenihs::route('/'),
            'create' => Pages\CreateProdusenBenih::route('/create'),
            'edit' => Pages\EditProdusenBenih::route('/{record}/edit'),
        ];
    }    
    // public static function getWidgets(): array
    // {
    //     return [
    //         Widgets\ProdusenBenihOverview::class,
    //     ];
    // }
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
}
