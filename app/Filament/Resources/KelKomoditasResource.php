<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KelKomoditasResource\Pages;
use App\Filament\Resources\KelKomoditasResource\RelationManagers;
use App\Models\KelKomoditas;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KelKomoditasResource extends Resource
{
    protected static ?string $model = KelKomoditas::class;
    // protected static bool $shouldRegisterNavigation = false;
    protected static ?string $navigationIcon = 'heroicon-o-clipboard';
    protected static ?string $navigationGroup = 'Master Data';
    protected static ?int $navigationSort = 14;
    protected static ?string $navigationLabel = 'Kelompok Komoditas';
    

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\TextInput::make('nama_kelompok')
                ->required()
                ->maxLength(255),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            Tables\Columns\TextColumn::make('id')->sortable()->label('ID'),
            Tables\Columns\TextColumn::make('nama_kelompok')->sortable()->searchable()->label('Nama Kelompok'),
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
            //
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKelKomoditas::route('/'),
            'create' => Pages\CreateKelKomoditas::route('/create'),
            'edit' => Pages\EditKelKomoditas::route('/{record}/edit'),
        ];
    }    
}
