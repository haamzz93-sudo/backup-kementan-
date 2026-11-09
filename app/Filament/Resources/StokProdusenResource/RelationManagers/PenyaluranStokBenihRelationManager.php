<?php

namespace App\Filament\Resources\StokProdusenResource\RelationManagers;

use App\Models\LaporanTargetBenih;
use App\Models\PenguranganStokBenih;
use App\Models\Provinces;
use App\Models\Regencies;
use App\Models\Districts;
use App\Models\PenyaluranStokBenih;
use App\Models\Villages;
use App\Models\StokProdusen;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;
use DB;
class PenyaluranStokBenihRelationManager extends RelationManager
{
    protected static string $relationship = 'PenyaluranStokBenih';

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
                Forms\Components\TextInput::make('nama_penerima')
                    ->label('Nama Penerima')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('provinces_id')
                    ->label('Provinsi Penerima')
                    ->options(Provinces::all()->pluck('name','id')->toArray())
                    ->reactive()
                    ->required()
                    ->afterStateUpdated(fn (callable $set) => $set('regencies_id',null)),
                Forms\Components\Select::make('regencies_id')
                    ->label('Kabupaten Penerima')
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
                    ->label('Kecamatan Penerima')
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
                    ->label('Desa Penerima')
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
                        ->label('Alamat Penerima')
                        ->required(),
                        Forms\Components\TextInput::make('jumlah')
                        ->label('Jumlah Penyaluran')
                        ->required()
                        ->numeric()
                    ])->columns('1'),
                    Forms\Components\Card::make()
                    ->schema([
                Forms\Components\FileUpload::make('upload_foto')
                ->label('Upload Foto')
                ->enableDownload()
                    ->enableOpen()
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
                ->label('Provinsi Penerima'),
                Tables\Columns\TextColumn::make('regencies.name')
                ->label('Kabupaten/Kota Penerima'),
                Tables\Columns\TextColumn::make('districts.name')
                ->label('Kecamatan Penerima'),
                Tables\Columns\TextColumn::make('villages.name')
                ->label('Desa Penerima'),
                Tables\Columns\TextColumn::make('alamat')
                ->label('Alamat Penerima'),
                Tables\Columns\TextColumn::make('jumlah')
                ->label('Jumlah Penyaluran'),
                Tables\Columns\ImageColumn::make('upload_foto')
                ->label('Upload Foto')
                ->size(40),
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
                ->after(
                    function (RelationManager $livewire,$record) {
                    $id = $livewire->ownerRecord->getKey();
                    $stok = StokProdusen::where('id',$id)->first();
                        $penyaluran = PenyaluranStokBenih::where('id', $record->id)->first();
                        $jumlahstok = DB::table('lap_penyaluran_stok')
                        ->join('target_benih','target_benih.id','=','lap_penyaluran_stok.target_benih_id')
                        ->where('lap_penyaluran_stok.target_benih_id',$stok->id)
                        ->sum('lap_penyaluran_stok.jumlah');

                        return  DB::table('target_benih')->where('id',$penyaluran->target_benih_id)->update([
                            'tanggal_r_salur' => $penyaluran->tanggal_lapor,
                            'jum_s_salur' => $jumlahstok,
                        ]);
                }
            ),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->after(
                    function (RelationManager $livewire,$record) {
                    $id = $livewire->ownerRecord->getKey();
                    $stok = StokProdusen::where('id',$id)->first();
                        $penyaluran = PenyaluranStokBenih::where('id', $record->id)->first();
                        $jumlahstok = DB::table('lap_penyaluran_stok')
                        ->join('target_benih','target_benih.id','=','lap_penyaluran_stok.target_benih_id')
                        ->where('lap_penyaluran_stok.target_benih_id',$stok->id)
                        ->sum('lap_penyaluran_stok.jumlah');

                        return  DB::table('target_benih')->where('id',$penyaluran->target_benih_id)->update([
                            'jum_s_salur' => $jumlahstok,
                        ]);
                }
            ),
                Tables\Actions\DeleteAction::make()
                ->before(function (RelationManager $livewire, $record) {
                    $id = $livewire->ownerRecord->getKey();
                    $stok = StokProdusen::where('id',$id)->first();
                    $penyaluran = PenyaluranStokBenih::where('id', $record->id)->first();
                    $jumsalur = $stok->jum_s_salur;
                    $jumsem = $penyaluran->jumlah;
                    $totalsisa = $jumsalur-$jumsem;
                    return  DB::table('target_benih')->where('id',$penyaluran->target_benih_id)->update([
                        'jum_s_salur' => $totalsisa,
                    ]);
                }),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }    
}
