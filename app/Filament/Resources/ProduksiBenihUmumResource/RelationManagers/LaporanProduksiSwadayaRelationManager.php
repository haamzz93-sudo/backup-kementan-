<?php

namespace App\Filament\Resources\ProduksiBenihUmumResource\RelationManagers;

use App\Models\Cara;
use App\Models\Golongan;
use App\Models\KelasBenih;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Actions\Position;
use App\Models\ProduksiBenihUmum;
use App\Models\Komoditas;
use App\Models\Varietas;
use App\Models\Satuan;
class LaporanProduksiSwadayaRelationManager extends RelationManager
{
    protected static string $relationship = 'LaporanProduksiSwadaya';

    protected static ?string $title = 'Laporan Produksi';
    protected static ?string $recordTitleAttribute = 'lembaga_id';
    
    protected function getTableActionsPosition(): ?string
    {
        return Position::BeforeCells;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('lembaga_id')
                    ->default(fn ($livewire) => $livewire->ownerRecord->getKey())
                    ->reactive(),
                    Forms\Components\Select::make('golongan_id')
                    ->label('Golongan Perbanyakan')
                    ->options(Golongan::all()->pluck('gol_banyak','id')->toArray())
                    ->reactive()
                    ->required(),
                    Forms\Components\Select::make('cara_id')
                    ->label('Metode Perbanyakan')
                    ->options(function(callable $get){
                        $golongan = Golongan::find($get('golongan_id'));
                        if(!$golongan){
                            return null;
                        }
                        return $golongan->cara->pluck('cara_banyak','id');
                    })
                    ->reactive()
                    ->required(),
                    Forms\Components\Select::make('kelas_benih_id')
                    ->label('Kelas Benih')
                    ->options(KelasBenih::all()->pluck('kelas_benih','id')->toArray())
                    ->reactive()
                    ->required(),
                    Forms\Components\Select::make('komoditas_id')
                    ->label('Komoditas')
                    ->options(Komoditas::all()->pluck('nama','id')->toArray())
                    ->searchable()
                    ->reactive()
                    ->required(),
                    Forms\Components\Select::make('varietas_id')
                    ->label('Varietas')
                    ->options(function(callable $get){
                        $komoditas = Komoditas::find($get('komoditas_id'));
                        if(!$komoditas){
                            return null;
                        }
                        return $komoditas->varietas->pluck('nama_varietas','id');
                    })
                    ->reactive()
                    ->required()
                    ->searchable(),
                    Forms\Components\Select::make('satuan_id')
                    ->label('Satuan')
                    ->options(Satuan::all()->pluck('nama_satuan','id')->toArray())
                    ->reactive()
                    ->required(),
                    Forms\Components\CheckboxList::make('sumber_dana')
                    ->label('Jenis Kegiatan')
                    ->options([
                        'apbn' => 'APBN',
                        'apbd' => 'APBD',
                        'mandiri' => 'Mandiri'
                        ])
                        ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('golongan.gol_banyak')
                ->label('Golongan Perbanyakan'),
                Tables\Columns\TextColumn::make('cara.cara_banyak')
                ->label('Metode Perbanyakan'),
                Tables\Columns\TextColumn::make('kelasbenih.kelas_benih')
                ->label('Kelas Benih'),
                Tables\Columns\TextColumn::make('komoditas.nama')
                ->label('Nama Komoditas'),
                Tables\Columns\TextColumn::make('varietas.nama_varietas')
                ->label('Nama Varietas'),
                Tables\Columns\TextColumn::make('sumber_dana')
                ->label('Jenis Kegiatan'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                ->modalHeading('Laporan Produksi'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('qr')
                ->label('Laporan Produksi')
                ->url(function($record){ return route('filament.resources.laporan-produksi-swadayas.edit',[$record]);})
                
            ])
            ->bulkActions([
                //Tables\Actions\DeleteBulkAction::make(),
            ]);
            
 
    }    
}
