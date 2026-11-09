<?php

namespace App\Filament\Resources\StokProdusenResource\RelationManagers;

use App\Models\LaporanTargetBenih;
use App\Models\PengadaanStokBenih;
use App\Models\Provinces;
use App\Models\Regencies;
use App\Models\Districts;
use App\Models\Villages;
use App\Models\StokProdusen;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use DB;
class PengadaanStokBenihRelationManager extends RelationManager
{
    protected static string $relationship = 'PengadaanStokBenih';

    protected static ?string $recordTitleAttribute = 'target_benih_id';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('target_benih_id')
                ->default(fn ($livewire) => $livewire->ownerRecord->getKey())
                ->reactive(),
                
                Forms\Components\DatePicker::make('tanggal_lapor')
                    ->label('Tanggal Pengadaan')
                    ->required(),
                Forms\Components\TextInput::make('lembaga_penyedia')
                    ->label('Produsen Penyedia')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('provinces_id')
                    ->label('Provinsi Asal')
                    ->options(Provinces::all()->pluck('name','id')->toArray())
                    ->reactive()
                    ->required()
                    ->afterStateUpdated(fn (callable $set) => $set('regencies_id',null)),
                Forms\Components\Select::make('regencies_id')
                    ->label('Kabupaten Asal')
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
                    ->label('Kecamatan Asal')
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
                    ->label('Desa Asal')
                    ->options(function(callable $get){
                        $districts = Districts::find($get('districts_id'));
                        if(!$districts){
                            return null;
                        }
                        return $districts->villages->pluck('name','id');
                    })
                    ->reactive()
                    ->required(),
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\Textarea::make('alamat')
                        ->label('Alamat Asal')
                        ->required(),
                        Forms\Components\TextInput::make('jumlah')
                        ->label('Jumlah Pengadaan Stok')
                        ->required()
                        ->numeric()
                    ])->columns('1'),
                    Forms\Components\Card::make()
                    ->schema([
                Forms\Components\FileUpload::make('upload_foto')
                ->label('Upload Foto')
                ->enableDownload()
                    ->enableOpen()
                    ->disk('local')
                ->required(),
                Forms\Components\FileUpload::make('upload_dokumen')
                ->enableDownload()
                ->enableOpen()
                ->label('Upload Dokumen')
                ->required(),
                ])->columns('2'),
                Forms\Components\Card::make()
                ->schema([
                    Forms\Components\Textarea::make('keperluan')
                    ->label('Keterangan')
                ])->columns('1'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tanggal_lapor')
                ->label('Tanggal Pengadaan'),
                Tables\Columns\TextColumn::make('provinces.name')
                ->label('Provinsi Asal'),
                Tables\Columns\TextColumn::make('regencies.name')
                ->label('Kabupaten/Kota  Asal'),
                Tables\Columns\TextColumn::make('districts.name')
                ->label('Kecamatan  Asal'),
                Tables\Columns\TextColumn::make('villages.name')
                ->label('Desa Asal'),
                Tables\Columns\TextColumn::make('alamat')
                ->label('Alamat Asal'),
                Tables\Columns\TextColumn::make('jumlah')
                ->label('Jumlah Pengadaan Stok'),
                Tables\Columns\ImageColumn::make('upload_foto')
                ->label('Upload Foto'),
                Tables\Columns\ImageColumn::make('upload_dokumen')
                ->label('Upload Dokumen'),
                Tables\Columns\TextColumn::make('keperluan')
                ->label('Keterangan'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                ->visible(
                        function ($record){
                        if(auth()->user()->hasRole("Lembaga Sertifikasi Benih")){
                            return false;
                            }else{
                            return true;
                            }
                        })
                    ->after(function (RelationManager $livewire, $record) {
                        $id = $livewire->ownerRecord->getKey();
                        $stok = StokProdusen::where('id',$id)->first();
                        $pengadaan = PengadaanStokBenih::where('id', $record->id)->first();
                        $jumlahstok = DB::table('lap_pengadaan_stok')
                        ->join('target_benih','target_benih.id','=','lap_pengadaan_stok.target_benih_id')
                        ->where('lap_pengadaan_stok.target_benih_id',$stok->id)
                        ->sum('lap_pengadaan_stok.jumlah');

                        return  DB::table('target_benih')->where('id',$pengadaan->target_benih_id)->update([
                            'jum_s_ada' => $jumlahstok,
                        ]);
                }
                ),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->after(function (RelationManager $livewire, $record) {
                    $id = $livewire->ownerRecord->getKey();
                    $stok = StokProdusen::where('id',$id)->first();
                    $pengadaan = PengadaanStokBenih::where('id', $record->id)->first();
                    $jumlahstok = DB::table('lap_pengadaan_stok')
                    ->join('target_benih','target_benih.id','=','lap_pengadaan_stok.target_benih_id')
                    ->where('lap_pengadaan_stok.target_benih_id',$stok->id)
                    ->sum('lap_pengadaan_stok.jumlah');

                    return  DB::table('target_benih')->where('id',$pengadaan->target_benih_id)->update([
                        'jum_s_ada' => $jumlahstok,
                    ]);
            }
            ),
                Tables\Actions\DeleteAction::make()
                ->before(function (RelationManager $livewire, $record) {
                    $id = $livewire->ownerRecord->getKey();
                    $stok = StokProdusen::where('id',$id)->first();
                    $pengadaan = PengadaanStokBenih::where('id', $record->id)->first();
                    $jumada = $stok->jum_s_ada;
                    $jumsem = $pengadaan->jumlah;
                    $totalsisa = $jumada-$jumsem;
                    return  DB::table('target_benih')->where('id',$pengadaan->target_benih_id)->update([
                        'jum_s_ada' => $totalsisa,
                    ]);
                }),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }    
}
