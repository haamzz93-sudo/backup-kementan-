<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VillagesResource\Pages;
use App\Filament\Resources\VillagesResource\RelationManagers;
use App\Models\Provinces;
use App\Models\Regencies;
use App\Models\Districts;
use App\Models\Villages;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VillagesResource extends Resource
{
    protected static ?string $model = Villages::class;
    protected static ?string $title = 'Database Desa';
    protected static ?string $navigationIcon = 'heroicon-o-globe';
    protected static ?string $navigationGroup = 'Master Wilayah';
    protected static ?int $navigationSort = 28;
    protected static ?string $navigationLabel = 'Desa';
    // protected static bool $shouldRegisterNavigation = false;
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('id')
                ->label('Kode Desa')
                    ->required(),
                Forms\Components\Select::make('provinces_id')
                    ->label('Provinsi')
                    ->options(Provinces::all()->pluck('name','id')->toArray())
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
                    ->afterStateUpdated(fn (callable $set) => $set('districts_id',null))
                    ,
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
                    ->afterStateUpdated(fn (callable $set) => $set('villages_id',null))
                    ,
                Forms\Components\TextInput::make('name')
                ->label('Nama Desa')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable()->label('Kode Desa'),
                Tables\Columns\TextColumn::make('name')->sortable()->searchable()->label('Nama Desa'),
                Tables\Columns\TextColumn::make('provinces.name')->sortable()->searchable()->label('Nama Provinsi'),
                Tables\Columns\TextColumn::make('regencies.name')->sortable()->searchable()->label('Nama Kab/Kota'),
                Tables\Columns\TextColumn::make('districts.name')->sortable()->searchable()->label('Nama Kecamatan'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVillages::route('/'),
            'create' => Pages\CreateVillages::route('/create'),
            'edit' => Pages\EditVillages::route('/{record}/edit'),
        ];
    }    
}
