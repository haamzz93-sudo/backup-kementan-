<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProvincesSebaranResource\Pages;
use App\Filament\Resources\ProvincesSebaranResource\RelationManagers;
use App\Models\ProvincesSebaran;
use App\Models\Regencies;
use App\Models\Komoditas;
use App\Models\LembagaSertifikasi;
use App\Models\VarietasSebar;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProvincesSebaranResource extends Resource
{
    protected static ?string $model = ProvincesSebaran::class;
    // protected static bool $shouldRegisterNavigation = false;
    protected static ?string $navigationIcon = 'heroicon-o-database';
    protected static ?string $navigationGroup = 'Database Varietas';
    protected static ?int $navigationSort = 13;
    protected static ?string $navigationLabel = 'Sebaran Varietas';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                ->label('Nama Provinsi')
                ->disabled()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Nama Provinsi')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('varietassebar.varietas_id')
                ->label('Jumlah Sebaran Varietas')
                ->getStateUsing( fn ($record) => $record->varietassebar->groupBy('varietas_id')->count()
                )
            ])
            ->filters([
                //
            ])
            ->actions([
                 Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    
    public static function getEloquentQuery(): Builder
    {
        if (auth()->user()->hasRole("Lembaga Sertifikasi Benih")){
            $saya = auth()->user()->lembaga_id;
            $lembaga = LembagaSertifikasi::where('id',$saya)->first();
            $lemprov = $lembaga->provinces_id;
            $lemid = $lembaga->id;
            return parent::getEloquentQuery()->where('id',$lemprov);
        }else{
            return parent::getEloquentQuery();
        } 
    }
    public static function getRelations(): array
    {
        return [
            RelationManagers\VarietasSebarRelationManager::class,
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProvincesSebarans::route('/'),
            'create' => Pages\CreateProvincesSebaran::route('/create'),
            'edit' => Pages\EditProvincesSebaran::route('/{record}/edit'),
        ];
    }    
}
