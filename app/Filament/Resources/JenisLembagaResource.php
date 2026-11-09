<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JenisLembagaResource\Pages;
use App\Filament\Resources\JenisLembagaResource\RelationManagers;
use App\Models\JenisLembaga;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class JenisLembagaResource extends Resource
{
    protected static ?string $model = JenisLembaga::class;
    // protected static bool $shouldRegisterNavigation = false;
    protected static ?string $navigationIcon = 'heroicon-o-clipboard';
    protected static ?string $navigationGroup = 'Master Data';
    protected static ?int $navigationSort = 19;
    protected static ?string $navigationLabel = 'Jenis Lembaga';
    

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
            'index' => Pages\ListJenisLembagas::route('/'),
            'create' => Pages\CreateJenisLembaga::route('/create'),
            'edit' => Pages\EditJenisLembaga::route('/{record}/edit'),
        ];
    }    
}
