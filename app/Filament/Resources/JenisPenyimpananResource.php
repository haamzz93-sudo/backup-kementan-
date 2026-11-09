<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JenisPenyimpananResource\Pages;
use App\Filament\Resources\JenisPenyimpananResource\RelationManagers;
use App\Models\JenisPenyimpanan;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class JenisPenyimpananResource extends Resource
{
    protected static ?string $model = JenisPenyimpanan::class;

    
    protected static ?string $navigationIcon = 'heroicon-o-clipboard';
    protected static ?string $navigationGroup = 'Master Data';
    protected static ?int $navigationSort = 22;
    protected static ?string $navigationLabel = 'Jenis Penyimpanan Hasil Produksi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_penyimpanan')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_penyimpanan'),
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
            'index' => Pages\ListJenisPenyimpanans::route('/'),
            'create' => Pages\CreateJenisPenyimpanan::route('/create'),
            'edit' => Pages\EditJenisPenyimpanan::route('/{record}/edit'),
        ];
    }    
}
