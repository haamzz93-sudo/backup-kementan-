<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProvincesResource\Pages;
use App\Filament\Resources\ProvincesResource\RelationManagers;
use App\Models\Provinces;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Heloufir\FilamentLeafLetGeoSearch\Forms\Components\LeafletInput;
use Filament\Forms\Components\Card;
use Closure;
use Illuminate\Support\Str;

class ProvincesResource extends Resource
{
    protected static ?string $model = Provinces::class;
    // protected static bool $shouldRegisterNavigation = false;
    protected static ?string $navigationIcon = 'heroicon-o-globe';
    protected static ?string $navigationGroup = 'Master Wilayah';
    protected static ?int $navigationSort = 25;
    protected static ?string $navigationLabel = 'Provinsi';
    

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                Forms\Components\TextInput::make('id')
                    ->required()
                    ->maxLength(2),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                    Card::make()
                    ->schema([
                        LeafletInput::make('location')
                        ->setMapHeight(300) // Here you can specify a map height in pixels, by default the height is equal to 200
                        ->setZoomControl(true) // Here you can enable/disable zoom control on the map (default: true)
                        ->setScrollWheelZoom(true)
                        ->setZoomLevel(3) // Here you can change the default zoom level (when the map is loaded for the first time), default value is 10
                        ->required()
                        ->reactive()
						->afterStateUpdated(function ($state, $set) {
                            $result = json_encode($state);
                            $obj = json_decode($result);
                            if(isset($obj->y)){$teslat = $obj->y;}else{$teslat = $obj->lat;};
                            if(isset($obj->x)){$teslng = $obj->x;}else{$teslng = $obj->lng;};
                             $set('latitude', $teslat);
                            $set('longitude', $teslng);
							}),
                    ])->columns(1),
                Forms\Components\TextInput::make('latitude'),
                Forms\Components\TextInput::make('longitude'),
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable()->label('Kode Provinsi'),
                Tables\Columns\TextColumn::make('name')->sortable()->searchable()->label('Nama Provinsi'),
                Tables\Columns\TextColumn::make('latitude'),
                Tables\Columns\TextColumn::make('longitude'),
            ])
            ->filters([
                // Tables\Filters\Filter::make('id')
                //  ->query(fn (Builder $query): Builder => $query),
                //  Tables\Filters\Filter::make('name')
                //  ->query(fn (Builder $query): Builder => $query),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
//     public static function getEloquentQuery(): Builder
// {
//     return parent::getEloquentQuery()->where('id',32);
// }
    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProvinces::route('/'),
            'create' => Pages\CreateProvinces::route('/create'),
            'edit' => Pages\EditProvinces::route('/{record}/edit'),
        ];
    }    
}