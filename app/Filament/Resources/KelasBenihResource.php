<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KelasBenihResource\Pages;
use App\Filament\Resources\KelasBenihResource\RelationManagers;
use App\Models\KelasBenih;
use App\Models\KelBenih;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KelasBenihResource extends Resource
{
    protected static ?string $model = KelasBenih::class;
    // protected static bool $shouldRegisterNavigation = false;
    protected static ?string $navigationIcon = 'heroicon-o-clipboard';
    protected static ?string $navigationGroup = 'Master Data';
    protected static ?int $navigationSort = 17;
    protected static ?string $navigationLabel = 'Status Tanaman Induk';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('kelas_benih')
                    ->label('Kelas Benih')
                    ->required(),
                Forms\Components\TextInput::make('kode_kel')
                    ->label('Kode')
                    ->required(),
                Forms\Components\Select::make('kel_benih_id')
                ->label('Kelompok Benih')
                ->options(KelBenih::all()->pluck('nama_kelompok','id')->toArray())
                ->reactive(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kelas_benih')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('kode_kel')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('kelbenih.nama_kelompok')->sortable()->searchable(),
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
            'index' => Pages\ListKelasBenihs::route('/'),
            'create' => Pages\CreateKelasBenih::route('/create'),
            'edit' => Pages\EditKelasBenih::route('/{record}/edit'),
        ];
    }    
}
