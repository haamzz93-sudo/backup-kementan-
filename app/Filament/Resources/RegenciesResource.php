<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RegenciesResource\Pages;
use App\Filament\Resources\RegenciesResource\RelationManagers;
use App\Models\Provinces;
use App\Models\Regencies;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RegenciesResource extends Resource
{
    protected static ?string $model = Regencies::class;
    protected static ?string $title = 'Database Kabupaten/Kota';
    protected static ?string $navigationIcon = 'heroicon-o-globe';
    protected static ?string $navigationGroup = 'Master Wilayah';
    protected static ?int $navigationSort = 26;
    protected static ?string $navigationLabel = 'Kabupaten/Kota';
    // protected static bool $shouldRegisterNavigation = false;
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('id')
                ->label('Kode Kab/Kota')
                    ->required(),
                Forms\Components\Select::make('provinces_id')
                    ->label('Provinsi')
                    ->options(Provinces::all()->pluck('name','id')->toArray())
                    ->reactive()
                    ->afterStateUpdated(fn (callable $set) => $set('regencies_id',null)),
                Forms\Components\TextInput::make('name')
                ->label('Nama Kab/Kota')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('latitude')
                    ->maxLength(15),
                Forms\Components\TextInput::make('longitude')
                    ->maxLength(15),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable()->label('Kode Kab/Kota'),
                Tables\Columns\TextColumn::make('name')->sortable()->searchable()->label('Nama Kab/Kota'),
                Tables\Columns\TextColumn::make('provinces.name')->sortable()->searchable()->label('Nama Provinsi'),
                Tables\Columns\TextColumn::make('latitude'),
                Tables\Columns\TextColumn::make('longitude'),
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
            'index' => Pages\ListRegencies::route('/'),
            'create' => Pages\CreateRegencies::route('/create'),
            'edit' => Pages\EditRegencies::route('/{record}/edit'),
        ];
    }    
}
