<?php

namespace App\Filament\Resources\ProvincesSebaranResource\RelationManagers;

use App\Models\ProvincesSebaran;
use App\Models\Regencies;
use App\Models\Varietas;
use App\Models\Komoditas;
use App\Models\KelKomoditas;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VarietasSebarRelationManager extends RelationManager
{
    protected static string $relationship = 'VarietasSebar';
    protected static ?string $title = 'Sebaran Varietas';
    protected static ?string $recordTitleAttribute = 'provinces_id';

    public static function form(Form $form): Form
    
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('provinces_id')
                ->default(fn ($livewire) => $livewire->ownerRecord->getKey())
                ->reactive(),
                Forms\Components\DatePicker::make('tanggal_lapor_sebar')
                ->label('Tanggal Lapor Sebaran')->required(),
                Forms\Components\Select::make('regencies_id')
                    ->label('Kabupaten')
					->searchable()
                    ->options(function(callable $get){
                            if(!$get('provinces_id')){
                                return null;
                            }
                            return Regencies::where('provinces_id',$get('provinces_id'))
                            ->pluck('name','id');
                        })
                    ->required()
                    ->reactive(),
                  Forms\Components\Select::make('komkel_id')
                    ->label('Kelompok Komoditas')
                    ->options(KelKomoditas::all()->pluck('nama_kelompok','id')->toArray())
                    ->reactive()->required(),
                Forms\Components\Select::make('komoditas_id')
                    ->label('Komoditas')
					->searchable()
                    ->options(function(callable $get){
                        $komkel = KelKomoditas::find($get('komkel_id'));
                        if(!$komkel){
                            return null;
                        }
                        return $komkel->komoditas->pluck('nama','id');
                    })
                    ->reactive()->required(),
                    Forms\Components\Select::make('varietas_id')
                    ->label('Varietas')
					->searchable()
                    ->options(function(callable $get){
                        $komoditas = Komoditas::find($get('komoditas_id'));
                        if(!$komoditas){
                            return null;
                        }
                        return $komoditas->varietas->pluck('nama_varietas','id');
                    })
                    ->reactive()->required(),
                        
                Forms\Components\TextInput::make('luas_sebar')
                ->label('Luas Sebaran (ha)')
                ->numeric()
                ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('regencies.name')
                ->label('Nama Kabupaten')->sortable(),
                Tables\Columns\TextColumn::make('kelkomoditas.nama_kelompok')
                ->label('Kelompok Komoditas')->sortable(),
                Tables\Columns\TextColumn::make('komoditas.nama')
                ->label('Nama Komoditas')->sortable(),
                Tables\Columns\TextColumn::make('varietas.nama_varietas')
                ->label('Nama Varietas')->sortable(),
                Tables\Columns\TextColumn::make('tanggal_lapor_sebar')
                ->label('Bulan Lapor')
                ->date('m-Y')->sortable(),
                Tables\Columns\TextColumn::make('luas_sebar')
                ->label('Luas Sebaran (ha)')->sortable(),
            
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                ->modalHeading('Buat Sebaran Varietas'),
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
