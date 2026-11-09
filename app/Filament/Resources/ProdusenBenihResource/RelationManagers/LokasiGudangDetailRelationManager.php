<?php

namespace App\Filament\Resources\ProdusenBenihResource\RelationManagers;

use App\Models\Provinces;
use App\Models\Regencies;
use App\Models\Districts;
use App\Models\JenisPenyimpanan;
use App\Models\Villages;
use App\Models\ProdusenBenih;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LokasiGudangDetailRelationManager extends RelationManager
{
    protected static string $relationship = 'LokasiGudangDetail';

    protected static ?string $title = 'Fasilitas Penyimpanan Hasil Produksi';
    protected static ?string $recordTitleAttribute = 'lembaga_id';

    
        public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('lembaga_id')
                ->default(fn ($livewire) => $livewire->ownerRecord->getKey())
                ->reactive(),
                Forms\Components\Select::make('provinces_id')
                    ->label('Provinsi')
                    ->options(function(callable $get){
                        $lembaganya =  ProdusenBenih::find($get('lembaga_id'));
                        $provid= $lembaganya->provinces_id;
                        $provinces = Provinces::where('id',$provid);
                        if(!$provinces){
                            return null;
                        }
                        return $provinces->pluck('name','id');
                    })
                    ->reactive()
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
                        ->reactive(),
                        Forms\Components\Textarea::make('alamat')
                        ->label('Alamat')
                        ->required()
                        ->maxLength(255),
                        Forms\Components\Select::make('jenis_penyimpanan_id')
                    ->label('Jenis Fasilitas Penyimpanan')
                    ->options(JenisPenyimpanan::all()->pluck('nama_penyimpanan','id')->toArray())
                    ->required()
                    ->reactive(),
                        Forms\Components\TextInput::make('kapasitas')
                        ->label('Kuantitas Gudang')
                        ->required(),
                        Forms\Components\Textarea::make('keterangan')
                        ->label('Keterangan Kapasitas Gudang dan Kondisi'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('provinces.name')->label('Nama Provinsi'),
                Tables\Columns\TextColumn::make('regencies.name')->label('Nama Kabupaten/Kota'),
                Tables\Columns\TextColumn::make('districts.name')->label('Nama Kecamatan'),
                Tables\Columns\TextColumn::make('villages.name')->label('Nama Desa/Kelurahan'),
                Tables\Columns\TextColumn::make('alamat')->label('Alamat'),
                Tables\Columns\TextColumn::make('jenispenyimpanan.nama_penyimpanan')->label('Jenis Fasilitas Penyimpanan'),
                Tables\Columns\TextColumn::make('kapasitas')->label('Kuantitas Gudang'),
                Tables\Columns\TextColumn::make('keterangan')->label('Keterangan Kapasitas Gudang dan Kondisi'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }    
}
