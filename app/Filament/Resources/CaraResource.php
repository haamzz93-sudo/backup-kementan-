<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CaraResource\Pages;
use App\Filament\Resources\CaraResource\RelationManagers;
use App\Models\Cara;
use App\Models\Golongan;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CaraResource extends Resource
{
    protected static ?string $model = Cara::class;
    // protected static bool $shouldRegisterNavigation = false;
    protected static ?string $navigationIcon = 'heroicon-o-clipboard';
    protected static ?string $navigationGroup = 'Master Data';
    protected static ?int $navigationSort = 22;
    protected static ?string $navigationLabel = 'Cara Perbanyakan Benih';
    

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('golongan_id')
                    ->label('Golongan Perbanyakan')
                    ->options(Golongan::all()->pluck('gol_banyak','id')->toArray())
                    ->reactive(),

                Forms\Components\TextInput::make('cara_banyak')
                    ->required()
                    ->label('Cara Perbanyakan'),
                Forms\Components\Select::make('btg_bwh')
                    ->label('Menggunakan Batang Bawah?')
                     ->options([
                        '1' => 'Ya',
                        '2' => 'Tidak',
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('golongan.gol_banyak')
                ->sortable()
                ->searchable()
                ->label('Golongan Perbanyakan'),
                Tables\Columns\TextColumn::make('cara_banyak')
                ->sortable()
                ->searchable()
                ->label('Cara Perbanyakan'),
                Tables\Columns\TextColumn::make('btg_bwh')
                ->enum([
                                '1' => 'Ya',
                                '2' => 'Tidak',
                            ])
                ->label('Menggunakan Batang Bawah?'),
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
            'index' => Pages\ListCaras::route('/'),
            'create' => Pages\CreateCara::route('/create'),
            'edit' => Pages\EditCara::route('/{record}/edit'),
        ];
    }    
}
