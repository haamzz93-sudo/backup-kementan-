<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JenisProdusenResource\Pages;
use App\Filament\Resources\JenisProdusenResource\RelationManagers;
use App\Models\JenisProdusen;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class JenisProdusenResource extends Resource
{
    protected static ?string $model = JenisProdusen::class;
    // protected static bool $shouldRegisterNavigation = false;
    protected static ?string $navigationIcon = 'heroicon-o-clipboard';
    protected static ?string $navigationGroup = 'Master Data';
    protected static ?int $navigationSort = 20;
    protected static ?string $navigationLabel = 'Jenis Produsen';
    

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_jenis')
                    ->label('Jenis Produsen')
                    ->required(),
                Forms\Components\TextInput::make('kode')
                ->label('Kode')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_jenis')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('kode')->sortable()->searchable(),
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
            'index' => Pages\ListJenisProdusens::route('/'),
            'create' => Pages\CreateJenisProdusen::route('/create'),
            'edit' => Pages\EditJenisProdusen::route('/{record}/edit'),
        ];
    }    
}
