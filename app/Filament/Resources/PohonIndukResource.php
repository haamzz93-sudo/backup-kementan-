<?php

namespace App\Filament\Resources;

use DB;
use App\Filament\Resources\PohonIndukResource\Pages;
use App\Filament\Resources\PohonIndukResource\RelationManagers;
use App\Filament\Resources\PohonIndukResource\RelationManagers\NomorRegistrasiRelationManager;
use App\Filament\Resources\PohonIndukResource\RelationManagers\KondisiPohonRelationManager;
use App\Models\JenisPemilik;
use App\Models\KepemilikanPohonInduk;
use App\Models\Provinces;
use App\Models\KelasBenih;
use App\Models\PohonInduk;
use App\Models\ProdusenBenih;
use App\Models\KelKomoditas;
use App\Models\Komoditas;
use App\Models\Varietas;
use App\Models\NomorRegistrasi;
use App\Models\KondisiPohon;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use App\Models\LembagaSertifikasi;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Card;
use Filament\Resources\RelationManagers\RelationManager;
use Heloufir\FilamentLeafLetGeoSearch\Forms\Components\LeafletInput;
use Filament\Tables\Filters\SelectFilter;
use Closure;

class PohonIndukResource extends Resource
{
    protected static ?string $model = PohonInduk::class;

    // protected static bool $shouldRegisterNavigation = false;
    protected static ?string $navigationIcon = 'heroicon-o-cube';
    protected static ?string $navigationGroup = 'Tanaman Induk';
    protected static ?int $navigationSort = 4;
    protected static ?string $navigationLabel = 'Inventaris Tanaman Induk';

    public static function form(Form $form): Form
    {
        if (auth()->user()->hasRole("Lembaga Sertifikasi Benih")){
         return $form
            ->schema([
                Forms\Components\Select::make('lembaga_serti_id')
                    ->label('Lembaga Sertifikasi')
                    ->options(LembagaSertifikasi::where('id', auth()->user()->lembaga_id)->pluck('nama_lembaga','id')->toArray())
                        ->required()
                        ->reactive(),
                Forms\Components\Select::make('pemilik_pohon_id')
                ->label('Pemilik Tanaman Induk') 
                ->options(function(callable $get){
                    if(!$get('lembaga_serti_id')){
                        return null;
                    }else{
                        return KepemilikanPohonInduk::where('lembaga_serti_id',$get('lembaga_serti_id'))->pluck('nama_lembaga','id')->toArray();
                    }
                })
                ->reactive()
                ->required(),
                Forms\Components\Select::make('komkel_id')
                    ->label('Kelompok Komoditas')
                    ->options(KelKomoditas::all()->pluck('nama_kelompok','id')->toArray())
                    ->reactive()
                    ->required(),
                Forms\Components\Select::make('komoditas_id')
                    ->label('Komoditas')
                    ->options(function(callable $get){
                        
                        if(!$get('komkel_id')){
                            return null;
                        }else{
                            return Komoditas::where('komkel_id',$get('komkel_id'))->pluck('nama','id')->toArray();
                        }
                        
                    })
                    ->reactive()
                    ->required(),
                    Forms\Components\Select::make('varietas_id')
                    ->label('Varietas')
                    ->options(function(callable $get){
                        if(!$get('komoditas_id')){
                            return null;
                        }else{
                            return Varietas::where('komoditas_id',$get('komoditas_id'))->pluck('nama_varietas','id')->toArray();
                        }
                        
                    })
                    ->reactive()
                    ->required(),
                    Forms\Components\Select::make('label_induk')
                    ->label('Kelas Benih')
                     ->options([
					 'Label Biru' => 'Label Biru',
                        'Label Kuning' => 'Label Kuning',
                        'Label Ungu' => 'Label Ungu',
                        'Label Putih' => 'Label Putih',
                        ])
                    ->required(),
                    Forms\Components\Select::make('kelas_benih_id')
                    ->label('Status Tanaman Induk')
                    ->options(KelasBenih::where('kel_benih_id', 1)->pluck('kelas_benih','id')->toArray())
                    ->reactive()->required(),
                    Forms\Components\TextInput::make('tahun_tanam')
                        ->label('Tahun Tanam')
                        ->numeric(4)
                        ->required(),
                        Forms\Components\TextInput::make('tahun_regis')
                        ->label('Tahun Registrasi')
                        ->numeric(4)
                        ->required(), Forms\Components\Fieldset::make('Kode Nomor Induk')
                        ->schema([
                            Forms\Components\Card::make()
                                ->schema([
                            Forms\Components\TextInput::make('kode_awal')
                                ->label('Kode Registrasi Awal')
                                ->reactive(),
                                ])->columns(1),
                            Forms\Components\Card::make()
                                ->schema([    
                            Forms\Components\TextInput::make('urut_awal')
                            ->label('Nomor Urut Awal')
                            ->integer()
                            ->required()
                            ->numeric()
                            ->reactive(),
                        Forms\Components\TextInput::make('urut_akhir')
                            ->label('Nomor Urut Akhir')
                            ->integer()
                            ->required() 
                            ->numeric()
                            ->reactive(),
                                ])->columns(2),
                        Forms\Components\Card::make()
                            ->schema([
                        Forms\Components\TextInput::make('kode_akhir')
                                ->label('Kode Registrasi Akhir')
                                ->reactive(),
                            ])->columns(1),
                            ])
                        ->columns(1),
                Forms\Components\Card::make()
                    ->schema([
                    Forms\Components\FileUpload::make('upload')
                        ->required()
                        ->label('Upload Foto Tanaman Induk')
                        ->enableDownload()
                        ->enableOpen(),
                    Forms\Components\FileUpload::make('upload_sk')
                        ->required()
                        ->label('Upload Surat Keterangan')
                        ->enableDownload()
                        ->enableOpen(),
                    ])->columns(1),
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
                    ])->columns(2),
                Forms\Components\TextInput::make('latitude')->required(),
                Forms\Components\TextInput::make('longitude')->required(),
                    ])
                    ->columns(2);
        }else{
        return $form
            ->schema([
                Forms\Components\Select::make('lembaga_serti_id')
                    ->label('Lembaga Sertifikasi')
                    ->options(LembagaSertifikasi::where('jenis_lembaga_id',[1,7])->pluck('nama_lembaga','id')->toArray())
                        ->required()
                        ->reactive(),
                Forms\Components\Select::make('pemilik_pohon_id')
                ->label('Pemilik Tanaman Induk') 
                ->options(function(callable $get){
                    if(!$get('lembaga_serti_id')){
                        return null;
                    }else{
                        return KepemilikanPohonInduk::where('lembaga_serti_id',$get('lembaga_serti_id'))->pluck('nama_lembaga','id')->toArray();
                    }
                })
                ->reactive()
                ->required(),
                Forms\Components\Select::make('komkel_id')
                    ->label('Kelompok Komoditas')
                    ->options(KelKomoditas::all()->pluck('nama_kelompok','id')->toArray())
                    ->reactive()
                    ->required(),
                Forms\Components\Select::make('komoditas_id')
                    ->label('Komoditas')
                    ->options(function(callable $get){
                        
                        if(!$get('komkel_id')){
                            return null;
                        }else{
                            return Komoditas::where('komkel_id',$get('komkel_id'))->pluck('nama','id')->toArray();
                        }
                        
                    })
                    ->reactive()
                    ->required(),
                    Forms\Components\Select::make('varietas_id')
                    ->label('Varietas')
                    ->options(function(callable $get){
                        if(!$get('komoditas_id')){
                            return null;
                        }else{
                            return Varietas::where('komoditas_id',$get('komoditas_id'))->pluck('nama_varietas','id')->toArray();
                        }
                        
                    })
                    ->reactive()->required(),
                    Forms\Components\Select::make('label_induk')
                    ->label('Kelas Benih')
                     ->options([
                        'Label Biru' => 'Label Biru',
                        'Label Kuning' => 'Label Kuning',
                        'Label Ungu' => 'Label Ungu',
                        'Label Putih' => 'Label Putih',
                        ])
                    ->required(),
                    Forms\Components\Select::make('kelas_benih_id')
                    ->label('Status Tanaman Induk')
                    ->options(KelasBenih::where('kel_benih_id', 1)->pluck('kelas_benih','id')->toArray())
                    ->reactive()->required(),
                    Forms\Components\TextInput::make('tahun_tanam')
                        ->label('Tahun Tanam')
                        ->numeric(4)
                        ->required(),
                    Forms\Components\TextInput::make('tahun_regis')
                        ->label('Tahun Registrasi')
                        ->numeric(4)
                        ->required(),
                        Forms\Components\Fieldset::make('Kode Nomor Induk')
                        ->schema([
                            Forms\Components\Card::make()
                                ->schema([
                            Forms\Components\TextInput::make('kode_awal')
                                ->label('Kode Registrasi Awal')
                                ->reactive(),
                                ])->columns(1),
                            Forms\Components\Card::make()
                                ->schema([    
                            Forms\Components\TextInput::make('urut_awal')
                            ->label('Nomor Urut Awal')
                            ->integer()
                            ->required()
                            ->numeric()
                            ->reactive(),
                        Forms\Components\TextInput::make('urut_akhir')
                            ->label('Nomor Urut Akhir')
                            ->integer()
                            ->required() 
                            ->numeric()
                            ->reactive(),
                                ])->columns(2),
                        Forms\Components\Card::make()
                            ->schema([
                        Forms\Components\TextInput::make('kode_akhir')
                                ->label('Kode Registrasi Akhir')
                                ->reactive(),
                            ])->columns(1),
                            ])
                        ->columns(1),
                Forms\Components\Card::make()
                ->schema([
                Forms\Components\FileUpload::make('upload')
                ->required()
                ->label('Upload Foto Tanaman Induk')
                ->enableDownload()
                    ->enableOpen(),
                Forms\Components\FileUpload::make('upload_sk')
                ->required()
                ->label('Upload Surat Keterangan')
                ->enableDownload()
                    ->enableOpen(),
                ])
                ->columns(2),
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
                        Tables\Columns\TextColumn::make('nmr')
                            ->getStateUsing(function($record) {
                                return "Nomor Tanaman Induk : ";
                        }),
                        Tables\Columns\TextColumn::make('nomor_induk')
                            ->label('Nomor Pohon Induk')
                            ->sortable()
                            ->searchable()
                            ->size('sm')
                            ->color('secondary')
                            ->getStateUsing( function ($record){
                                return $record->nomor_induk;
                            }),
                        Tables\Columns\TextColumn::make('pi')
                            ->getStateUsing(function($record) {
                                return "Pemilik Pohon Induk : ";
                        }),
                        Tables\Columns\TextColumn::make('pemilik_pohon.nama_lembaga')
                            ->label('Pemilik')
                            ->sortable()
                            ->searchable()
                            ->size('sm')
                            ->color('secondary')
                            ->getStateUsing( function ($record){
				$pemilik = KepemilikanPohonInduk::where('id',$record->pemilik_pohon_id)->first();
                                return $pemilik->nama_lembaga;
                            }),
                    ]),
                    Tables\Columns\Layout\Stack::make([
                        Tables\Columns\TextColumn::make('kl')
                            ->getStateUsing(function($record) {
                                return "Kelompok Komoditas : ";
                        }),
                        Tables\Columns\TextColumn::make('kel_komoditas.nama_kelompok')
                            ->label('Kelompok Komoditas')
                            ->sortable()
                            ->searchable()
                            ->size('sm')
                            ->color('secondary')
                            ->getStateUsing( function ($record){
				$kelkomoditas = KelKomoditas::where('id',$record->komkel_id)->first();
                                return $kelkomoditas->nama_kelompok;
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
				$komoditas = Komoditas::where('id',$record->komoditas_id)->first();
                                return $komoditas->nama;
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
								if(isset($record->varietas_id)){
									$vr = Varietas::where('id',$record->varietas_id)->first();
                                return $vr->nama_varietas ?? 'Varietas Belum Dipilih' ;
								}else{
									return "Varietas Belum Dipilih";
								}
				
                            }),
                    ]),
                    
                    Tables\Columns\TextColumn::make('lb')
                    ->getStateUsing(function($record) {
                        return "Kelas Benih : ";
                }),
                
                Tables\Columns\TextColumn::make('label_induk')
                ->label('Kelas Benih')
                ->size('sm')
                ->color('secondary'),
                Tables\Columns\TextColumn::make('vr')
                    ->getStateUsing(function($record) {
                        return "Status Tanaman Induk : ";
                }),
                Tables\Columns\TextColumn::make('kelas_benih_id')
                ->label('Status Tanaman Induk')
                ->sortable()
                ->searchable()
                ->size('sm')
                ->color('secondary')
                ->getStateUsing( function ($record){
					
                    $kel = KelasBenih::where('id',$record->kelas_benih_id)->first();
                    return $kel->kelas_benih;
                }),
                    Tables\Columns\Layout\Stack::make([
                        Tables\Columns\TextColumn::make('thn')
                            ->getStateUsing(function($record) {
                                return "Tahun Tanam: ";
                        }),
                        Tables\Columns\TextColumn::make('tahun_tanam')
                        ->label('Tahun Tanam')
                        ->sortable()
                        ->searchable()
                        ->size('sm')
                        ->color('secondary')
                        ->getStateUsing( function ($record){
                            return $record->tahun_tanam;
                        }),
                        Tables\Columns\TextColumn::make('rgs')
                            ->getStateUsing(function($record) {
                                return "Tahun Registrasi: ";
                        }),
                        Tables\Columns\TextColumn::make('tahun_regis')
                        ->label('Tahun Registrasi')
                        ->sortable()
                        ->searchable()
                        ->size('sm')
                        ->color('secondary')
                        ->getStateUsing( function ($record){
                            return $record->tahun_regis;
                        }),
                    ]),
                    Tables\Columns\Layout\Stack::make([
                        Tables\Columns\TextColumn::make('jm')
                            ->getStateUsing(function($record) {
                                return "Jumlah Pohon: ";
                        }),
                        Tables\Columns\TextColumn::make('nomorregistrasipohon.no_registrasi')
                            ->size('sm')
                            ->color('secondary')
                            ->getStateUsing( fn ($record) => $record->nomorregistrasipohon->count()),
                    ]),
                ]),
                
                
                
                
            ])
            ->filters([
                // SelectFilter::make('pemilik_pohon_id')
                // ->label('Pemilik Pohon Induk')
                // ->options(KepemilikanPohonInduk::all()->pluck('nama_lembaga','id')->toArray())->multiple(),
                // SelectFilter::make('komkel_id')
                // ->label('Kelompok Komoditas')
                // ->options(KelKomoditas::all()->pluck('nama_kelompok','id')->toArray())->multiple(),
                SelectFilter::make('komoditas_id')
                ->label('Komoditas')
                ->options(Komoditas::all()->pluck('nama','id')->toArray())->multiple(),
                // SelectFilter::make('varietas_id')
                // ->label('Varietas')
                // ->options(Varietas::all()->pluck('nama_varietas','id')->toArray())->multiple(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                                Tables\Actions\Action::make('QRCode')
                    ->url(fn (PohonInduk $record): string => route('pohon-induks', $record))
                    ->openUrlInNewTab()
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            RelationManagers\NomorRegistrasiPohonRelationManager::class,
        ];
    }
    public static function getEloquentQuery(): Builder
    {
        if (auth()->user()->hasRole("Lembaga Sertifikasi Benih")){
            return parent::getEloquentQuery()->where('lembaga_serti_id',auth()->user()->lembaga_id);
        }elseif (auth()->user()->hasRole("Produsen Benih")){
            return parent::getEloquentQuery()->where('lembaga_id',auth()->user()->lembaga_id);
        }else{
            return parent::getEloquentQuery();
        } 
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPohonInduks::route('/'),
            'create' => Pages\CreatePohonInduk::route('/create'),
            'edit' => Pages\EditPohonInduk::route('/{record}/edit'),
        ];
    }    
}
