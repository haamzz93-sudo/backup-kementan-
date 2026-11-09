<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RegulasiResource\Pages;
use App\Filament\Resources\RegulasiResource\RelationManagers;
use App\Models\Regulasi;
use App\Models\ProdusenBenih;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RegulasiResource extends Resource
{
    protected static ?string $model = Regulasi::class;
    protected static ?string $navigationIcon = 'heroicon-o-badge-check';
    protected static ?string $navigationGroup = 'Lembaga';
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationLabel = 'Regulasi Lembaga';

    public static function form(Form $form): Form
    {
        if (auth()->user()->lembaga_id){
        return $form
            ->schema([
                Forms\Components\Hidden::make('lembaga_id')
                ->label("Nama Lembaga")
                ->default(function(){
                   return auth()->user()->lembaga_id;
                }
                )
                ->required(),
                Forms\Components\Select::make('lingkup')
                    ->label('Lingkup Regulasi')
                     ->options([
                        '2' => 'Provinsi',
                        '3' => 'Internal Lembaga',
                        ])
                    ->required(),
                Forms\Components\TextInput::make('nama_regulasi')
                    ->label("Judul Regulasi")
                    ->required(),
                    Forms\Components\FileUpload::make('upload')
                    ->label('Upload Regulasi')
                    ->enableDownload()
                    ->enableOpen()
                    ->disk('local')
                    ->required(),
                Forms\Components\Textarea::make('keterangan'),
                ]);
        }else{
            return $form
            ->schema([
                Forms\Components\Select::make('lingkup')
                    ->label('Lingkup Regulasi')
                     ->options([
                        '1' => 'Pusat',
                        '2' => 'Provinsi',
                        '3' => 'Internal Lembaga',
                        ])
                    ->required(),
                Forms\Components\TextInput::make('nama_regulasi')
                    ->label("Judul Regulasi")
                    ->required(),
                    Forms\Components\FileUpload::make('upload')
                    ->label('Upload Regulasi')
                    ->enableDownload()
                    ->enableOpen()
                    ->required(),
                Forms\Components\Textarea::make('keterangan'),
                ]);
            }
    }
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('lembaga.nama_lembaga')
                ->label("Nama Lembaga"),
                Tables\Columns\TextColumn::make('lingkup')
                ->label("Lingkup Regulasi")
                ->getStateUsing( function ($record){
                    $l = $record->lingkup;
                    if($l=="1"){
                    return "Pusat";
                    }elseif($l=="2"){
                        return "Provinsi";
                        }elseif($l=="3"){
                            return "Internal Lembaga";
                            }
                }),
                Tables\Columns\TextColumn::make('nama_regulasi')
                ->label("Judul Regulasi"),
                Tables\Columns\TextColumn::make('upload')
                ->label("Dokumen Regulasi"),
                Tables\Columns\TextColumn::make('keterangan')
                ->label("Keterangan"),
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
            'index' => Pages\ListRegulasis::route('/'),
            'create' => Pages\CreateRegulasi::route('/create'),
            'edit' => Pages\EditRegulasi::route('/{record}/edit'),
        ];
    }
     public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('lembaga_id',auth()->user()->lembaga_id);
        
    }
    
}
