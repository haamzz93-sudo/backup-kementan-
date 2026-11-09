<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JenisPemilikResource\Pages;
use App\Filament\Resources\JenisPemilikResource\RelationManagers;
use App\Models\JenisPemilik;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class JenisPemilikResource extends Resource
{
    protected static ?string $model = JenisPemilik::class;
    // protected static bool $shouldRegisterNavigation = false;
    protected static ?string $navigationIcon = 'heroicon-o-clipboard';
    
    protected static ?string $navigationGroup = 'Master Data';
    protected static ?int $navigationSort = 18;
    protected static ?string $navigationLabel = 'Jenis Kepemilikan Pohon Induk';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_jenis')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_jenis')->sortable()->searchable(),
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
            'index' => Pages\ListJenisPemiliks::route('/'),
            'create' => Pages\CreateJenisPemilik::route('/create'),
            'edit' => Pages\EditJenisPemilik::route('/{record}/edit'),
        ];
    }    
}
