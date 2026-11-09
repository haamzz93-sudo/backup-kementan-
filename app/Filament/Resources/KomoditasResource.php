<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KomoditasResource\Pages;
use App\Filament\Resources\KomoditasResource\RelationManagers;
use App\Models\Komoditas;
use App\Models\KelKomoditas;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KomoditasResource extends Resource
{
    protected static ?string $model = Komoditas::class;
    // protected static bool $shouldRegisterNavigation = false;
    protected static ?string $navigationIcon = 'heroicon-o-clipboard';
    protected static ?string $navigationGroup = 'Master Data';
    protected static ?int $navigationSort = 15;
    protected static ?string $navigationLabel = 'Komoditas';
    

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('komkel_id')
                ->label('Kelompok Komoditas')
                ->options(KelKomoditas::all()->pluck('nama_kelompok','id')->toArray())
                ->reactive(),
            Forms\Components\TextInput::make('nama')
                ->maxLength(65535),
            Forms\Components\TextInput::make('masa_dormansi')
                ->required()
                ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kelkomoditas.nama_kelompok')->label('Kelompok Komoditas')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('nama')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('masa_dormansi')->sortable()->searchable(),
            ])
            ->filters([
                //
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
           
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKomoditas::route('/'),
            'create' => Pages\CreateKomoditas::route('/create'),
            'edit' => Pages\EditKomoditas::route('/{record}/edit'),
        ];
    }    
}
