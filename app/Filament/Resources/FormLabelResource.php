<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FormLabelResource\Pages;
use App\Filament\Resources\FormLabelResource\RelationManagers;
use App\Models\FormLabel;
use App\Models\Golongan;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;


class FormLabelResource extends Resource
{
    protected static ?string $model = FormLabel::class;

    
    protected static ?string $title = 'Form Label';
    protected static ?string $navigationIcon = 'heroicon-o-clipboard';
    protected static ?string $navigationGroup = 'Master Data';
    protected static ?int $navigationSort = 26;
    protected static ?string $navigationLabel = 'Form Label';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
            Forms\Components\Card::make()
            ->schema([
                Forms\Components\Select::make('golongan_id')
                ->label('Golongan Perbanyakan')
                ->options(Golongan::all()->pluck('gol_banyak','id')->toArray())
                ->searchable()
                ->reactive()
                ->required(),
                Forms\Components\Select::make('cara_id')
                ->label('Metode Perbanyakan')
                ->options(function(callable $get){
                    $golongan = Golongan::find($get('golongan_id'));
                    if(!$golongan){
                        return null;
                    }
                    return $golongan->cara->pluck('cara_banyak','id');
                })
                ->searchable()
                ->reactive(),
            Forms\Components\Repeater::make('json_form')
            ->label("Form QR")
            ->schema([
                Forms\Components\TextInput::make('key')
                ->required(),
                Forms\Components\Toggle::make('required')
                ->default(1)
                ->required(),
                Forms\Components\Toggle::make('data_label')
                ->label('Data Label')
                ->default(1),
                Forms\Components\TextInput::make('urut')
                ->label('No. Urut')
            ])
            ->createItemButtonLabel('Tambah Form')
            ->columns(1)
            ])
            ->columns(1)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('golongan.gol_banyak'),
                Tables\Columns\TextColumn::make('cara.cara_banyak'),
                Tables\Columns\IconColumn::make('json_form')
                ->label('Form Label')
                ->boolean()
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
            'index' => Pages\ListFormLabels::route('/'),
            'create' => Pages\CreateFormLabel::route('/create'),
            'edit' => Pages\EditFormLabel::route('/{record}/edit'),
        ];
    }    
}
