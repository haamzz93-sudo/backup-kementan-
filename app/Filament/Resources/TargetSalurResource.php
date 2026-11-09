<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TargetSalurResource\Pages;
use App\Filament\Resources\TargetSalurResource\RelationManagers;
use App\Models\LaporanTargetBenih;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TargetSalurResource extends Resource
{
    protected static ?string $model = LaporanTargetBenih::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';
    protected static bool $shouldRegisterNavigation = false;
    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\Placeholder::make('lembaga_id')
                    ->label(__('Nama Lembaga'))
                    ->content(fn ($record) => $record->lembaga?->nama_lembaga),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tanggal_salur')
                    ->date(),
                Tables\Columns\TextColumn::make('jumlah'),
                Tables\Columns\TextColumn::make('keterangan'),
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
            RelationManagers\TargetSalurRelationManager::class,
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTargetSalurs::route('/'),
            'create' => Pages\CreateTargetSalur::route('/create'),
            'edit' => Pages\EditTargetSalur::route('/{record}/edit'),
        ];
    }    
}
