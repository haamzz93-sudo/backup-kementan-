<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KondisiResource\Pages;
use App\Filament\Resources\KondisiResource\RelationManagers;
use App\Models\Kondisi;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KondisiResource extends Resource
{
    protected static ?string $model = Kondisi::class;
    // protected static bool $shouldRegisterNavigation = false;
    protected static ?string $navigationIcon = 'heroicon-o-clipboard';
    protected static ?string $navigationGroup = 'Master Data';
    protected static ?string $navigationLabel = 'Kondisi Sarana Prasarana';
    protected static ?int $navigationSort = 24;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('kondisi_sarpras')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kondisi_sarpras')->sortable()->searchable(),
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
            'index' => Pages\ListKondisis::route('/'),
            'create' => Pages\CreateKondisi::route('/create'),
            'edit' => Pages\EditKondisi::route('/{record}/edit'),
        ];
    }    
}
