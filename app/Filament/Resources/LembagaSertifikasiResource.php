<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LembagaSertifikasiResource\Pages;
use App\Filament\Resources\LembagaSertifikasiResource\RelationManagers;
use App\Models\Provinces;
use App\Models\Regencies;
use App\Models\Districts;
use App\Models\Villages;
use App\Models\JenisLembaga;
use App\Models\JenisProdusen;
use App\Models\LembagaSertifikasi;
use App\Models\SaranaLembaga;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\SelectFilter;
use Heloufir\FilamentLeafLetGeoSearch\Forms\Components\LeafletInput;

class LembagaSertifikasiResource extends Resource
{
    // protected static bool $shouldRegisterNavigation = false;
    protected static ?string $model = LembagaSertifikasi::class;
    protected static ?string $navigationIcon = 'heroicon-o-badge-check';
    protected static ?string $navigationGroup = 'Lembaga';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationLabel = 'Lembaga Sertifikasi';


    public static function form(Form $form): Form
    {
        if (isset(auth()->user()->lembaga_id)) {
            $saya = auth()->user()->lembaga_id;
            $lembaga = LembagaSertifikasi::where('id', $saya)->first();
            $lemprov = $lembaga->provinces_id;
            $lemid = $lembaga->id;
        }
        if (auth()->user()->hasRole("Lembaga Sertifikasi Benih")) {
            return $form
                ->schema([
                    Forms\Components\Select::make('provinces_id')
                        ->label('Provinsi')
                        ->options(Provinces::where('id', $lemprov)->pluck('name', 'id')->toArray())
                        ->reactive()
                        ->required()
                        ->afterStateUpdated(fn (callable $set) => $set('regencies_id', null)),
                    Forms\Components\Select::make('regencies_id')
                        ->label('Kabupaten')
                        ->options(function (callable $get) {
                            $provinces = Provinces::find($get('provinces_id'));
                            if (!$provinces) {
                                return null;
                            }
                            return $provinces->regencies->pluck('name', 'id');
                        })
                        ->reactive()
                        ->required()
                        ->afterStateUpdated(fn (callable $set) => $set('districts_id', null)),
                    Forms\Components\Select::make('districts_id')
                        ->label('Kecamatan')
                        ->required()
                        ->options(function (callable $get) {
                            $regencies = Regencies::find($get('regencies_id'));
                            if (!$regencies) {
                                return null;
                            }
                            return $regencies->districts->pluck('name', 'id');
                        })
                        ->reactive()
                        ->afterStateUpdated(fn (callable $set) => $set('villages_id', null)),
                    Forms\Components\Select::make('villages_id')
                        ->label('Desa')
                        ->options(function (callable $get) {
                            $districts = Districts::find($get('districts_id'));
                            if (!$districts) {
                                return null;
                            }
                            return $districts->villages->pluck('name', 'id');
                        })
                        ->reactive()
                        ->required(),

                    Forms\Components\TextInput::make('nama_lembaga')
                        ->label('Nama Lembaga')
                        ->required(),

                    Forms\Components\Select::make('jenis_lembaga_id')
                        ->label('Jenis Lembaga')
                        ->options(JenisLembaga::whereIn('id', [1, 7])->pluck('nama_jenis', 'id')->toArray())
                        ->required(),


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
                    Forms\Components\FileUpload::make('upload')
                        ->label('Upload Foto Lembaga')
                        ->enableDownload()
                        ->enableOpen(),
                    Forms\Components\FileUpload::make('logo')
                        ->label('Upload Logo')
                        ->placeholder('Format Logo PNG dan Berlatar Transparan')
                        ->acceptedFileTypes(['image/png'])
                        ->enableDownload()
                        ->enableOpen(),
                    Forms\Components\FileUpload::make('stempel')
                        ->label('Upload Stempel BPSB')
                        ->placeholder('Format Logo PNG dan Berlatar Transparan')
                        ->acceptedFileTypes(['image/png'])
                        ->enableDownload()
                        ->enableOpen(),
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
                                    if (isset($obj->y)) {
                                        $set('latitude', $obj->y);
                                        $set('longitude', $obj->x);
                                    } else {
                                        $set('latitude', $state['lat']);
                                        $set('longitude', $state['lng']);
                                    }
                                }),
                        ])->columns(1),
                    Forms\Components\TextInput::make('latitude')
                        ->required(),
                    Forms\Components\TextInput::make('longitude')
                        ->required(),
                ]);
        } else {
            return $form
                ->schema([
                    Forms\Components\Select::make('provinces_id')
                        ->label('Provinsi')
                        ->options(Provinces::pluck('name', 'id')->toArray())
                        ->reactive()
                        ->required()
                        ->afterStateUpdated(fn (callable $set) => $set('regencies_id', null)),
                    Forms\Components\Select::make('regencies_id')
                        ->label('Kabupaten')
                        ->options(function (callable $get) {
                            $provinces = Provinces::find($get('provinces_id'));
                            if (!$provinces) {
                                return null;
                            }
                            return $provinces->regencies->pluck('name', 'id');
                        })
                        ->required()
                        ->reactive()
                        ->afterStateUpdated(fn (callable $set) => $set('districts_id', null)),
                    Forms\Components\Select::make('districts_id')
                        ->label('Kecamatan')
                        ->options(function (callable $get) {
                            $regencies = Regencies::find($get('regencies_id'));
                            if (!$regencies) {
                                return null;
                            }
                            return $regencies->districts->pluck('name', 'id');
                        })
                        ->required()
                        ->reactive()
                        ->afterStateUpdated(fn (callable $set) => $set('villages_id', null)),
                    Forms\Components\Select::make('villages_id')
                        ->label('Desa')
                        ->options(function (callable $get) {
                            $districts = Districts::find($get('districts_id'));
                            if (!$districts) {
                                return null;
                            }
                            return $districts->villages->pluck('name', 'id');
                        })
                        ->required()
                        ->reactive(),

                    Forms\Components\TextInput::make('nama_lembaga')
                        ->label('Nama Lembaga')
                        ->required(),

                    Forms\Components\Select::make('jenis_lembaga_id')
                        ->label('Jenis Lembaga')
                        ->options(JenisLembaga::whereIn('id', [1, 7])->pluck('nama_jenis', 'id')->toArray())
                        ->required(),


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
                        ->label('Nama Kepala Lembaga')
                        ->required(),
                    Forms\Components\TextInput::make('no_telp')
                        ->label('No. Telp')
                        ->required()
                        ->tel()
                        ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/'),
                    Forms\Components\FileUpload::make('upload')
                        ->label('Upload Foto Lembaga')
                        ->enableDownload()
                        ->enableOpen(),
                    Forms\Components\FileUpload::make('logo')
                        ->label('Upload Logo')
                        ->placeholder('Format Logo PNG dan Berlatar Transparan')
                        ->acceptedFileTypes(['image/png'])
                        ->enableDownload()
                        ->enableOpen(),
                    Forms\Components\FileUpload::make('stempel')
                        ->label('Upload Stempel BPSB')
                        ->placeholder('Format Logo PNG dan Berlatar Transparan')
                        ->acceptedFileTypes(['image/png'])
                        ->enableDownload()
                        ->enableOpen(),
                    Forms\Components\Card::make()
                        ->schema([
                            LeafletInput::make('location')
                                ->setMapHeight(300) // Here you can specify a map height in pixels, by default the height is equal to 200
                                ->setZoomControl(true) // Here you can enable/disable zoom control on the map (default: true)
                                ->setScrollWheelZoom(true)
                                ->setZoomLevel(3) // Here you can change the default zoom level (when the map is loaded for the first time), default value is 10
                                ->reactive()
                                ->required()
                                ->afterStateUpdated(function ($state, $set) {
                                    $result = json_encode($state);
                                    $obj = json_decode($result);
                                    if (isset($obj->y)) {
                                        $set('latitude', $obj->y);
                                        $set('longitude', $obj->x);
                                    } else {
                                        $set('latitude', $state['lat']);
                                        $set('longitude', $state['lng']);
                                    }
                                }),
                        ])->columns(1),
                    Forms\Components\TextInput::make('latitude')
                        ->required(),
                    Forms\Components\TextInput::make('longitude')
                        ->required(),
                ]);
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
                        Tables\Columns\TextColumn::make('jenis_lembaga.nama_jenis')
                            ->label('Jenis Lembaga')
                            ->sortable()
                            ->searchable()
                            ->size('sm')
                            ->color('secondary')
                            ->alignLeft(),
                        Tables\Columns\TextColumn::make('jenis_produsen.nama_jenis')
                            ->label('Jenis Produsen')
                            ->sortable()
                            ->searchable()
                            ->size('sm')
                            ->color('secondary')
                            ->alignLeft(),

                    ]),
                    Tables\Columns\Layout\Stack::make([
                        Tables\Columns\TextColumn::make('provinces.name')
                            ->label('Nama Provinsi')
                            ->sortable()
                            ->searchable(),
                        Tables\Columns\TextColumn::make('regencies.name')
                            ->label('Nama Kabupaten/Kota')
                            ->sortable()
                            ->searchable()
                            ->size('sm')
                            ->color('secondary')
                            ->alignLeft(),
                        Tables\Columns\TextColumn::make('districts.name')
                            ->label('Nama Kecamatan')
                            ->sortable()
                            ->searchable()
                            ->size('sm')
                            ->color('secondary')
                            ->alignLeft(),
                        Tables\Columns\TextColumn::make('villages.name')
                            ->label('Nama Desa/Kelurahan')
                            ->sortable()
                            ->searchable()
                            ->size('sm')
                            ->color('secondary')
                            ->alignLeft(),

                    ]),
                    Tables\Columns\Layout\Stack::make([
                        Tables\Columns\TextColumn::make('tes')
                            ->getStateUsing(function ($record) {
                                return "Nama Kepala Lembaga : ";
                            }),
                        Tables\Columns\TextColumn::make('nama_kepala')
                            ->label('Nama Kepala Lembaga')
                            ->alignLeft()
                            ->getStateUsing(function ($record) {
                                $kepala = $record->nama_kepala;
                                return $kepala;
                            }),
                        Tables\Columns\TextColumn::make('no_telp')
                            ->label('No. Telepon')
                            ->size('sm')
                            ->color('secondary')
                            ->alignLeft()
                            ->getStateUsing(function ($record) {
                                $tel = $record->no_telp;
                                return "No. Telepon: " . $tel;
                            }),
                        Tables\Columns\TextColumn::make('alamat')
                            ->label('Alamat')
                            ->size('sm')
                            ->color('secondary')
                            ->alignLeft()
                            ->getStateUsing(function ($record) {
                                $alamat = $record->alamat;
                                return "Alamat: " . $alamat;
                            }),
                        Tables\Columns\TextColumn::make('rt')
                            ->label('RT')
                            ->size('sm')
                            ->color('secondary')
                            ->alignLeft()
                            ->getStateUsing(function ($record) {
                                $rt = $record->rt;
                                return "RT: " . $rt;
                            }),
                        Tables\Columns\TextColumn::make('rw')
                            ->label('RW')
                            ->size('sm')
                            ->color('secondary')
                            ->alignLeft()
                            ->getStateUsing(function ($record) {
                                $rw = $record->rw;
                                return "RW: " . $rw;
                            }),
                        Tables\Columns\TextColumn::make('kodepos')
                            ->label('Kode Pos')
                            ->size('sm')
                            ->color('secondary')
                            ->alignLeft()
                            ->getStateUsing(function ($record) {
                                $pos = $record->kodepos;
                                return "Kode Pos: " . $pos;
                            }),

                    ]),
                ]),

            ])
            ->filters([
                SelectFilter::make('provinces_id')
                    ->label('Provinsi')
                    ->options(Provinces::all()->pluck('name', 'id')->toArray())->multiple(),
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
            RelationManagers\SaranaLembagaRelationManager::class,
            RelationManagers\AkreditasiRelationManager::class,
            RelationManagers\AdminSertifikasiRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLembagaSertifikasis::route('/'),
            'create' => Pages\CreateLembagaSertifikasi::route('/create'),
            'edit' => Pages\EditLembagaSertifikasi::route('/{record}/edit'),
        ];
    }
    public static function getEloquentQuery(): Builder
    {
        if (auth()->user()->hasRole("Lembaga Sertifikasi Benih")) {
            return parent::getEloquentQuery()->where('id', auth()->user()->lembaga_id);
        } else {
            return parent::getEloquentQuery()->whereIn('jenis_lembaga_id', ['1', '7']);
        }
    }
}
