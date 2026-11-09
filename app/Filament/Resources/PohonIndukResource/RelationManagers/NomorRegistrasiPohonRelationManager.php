<?php

namespace App\Filament\Resources\PohonIndukResource\RelationManagers;

use App\Models\PohonInduk;
use App\Models\NomorRegistrasi;
use App\Models\KondisiPohon;
use App\Models\KepemilikanPohonInduk;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Heloufir\FilamentLeafLetGeoSearch\Forms\Components\LeafletInput;

class NomorRegistrasiPohonRelationManager extends RelationManager
{
    protected static string $relationship = 'NomorRegistrasiPohon';

    protected static ?string $recordTitleAttribute = 'pohon_induk_id';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                
                Forms\Components\Hidden::make('pohon_induk_id')
                ->default(fn ($livewire) => $livewire->ownerRecord->getKey())
                ->reactive(),
                Forms\Components\Hidden::make('pemilik_pohon_id')
                ->label('Pemilik Pohon')
                ->default(function(callable $get){
                    $pho = PohonInduk::find($get('pohon_induk_id'));
                    return $pho->pemilik_pohon_id;
                }),
                Forms\Components\Hidden::make('lembaga_serti_id')
                ->label('Lembaga Sertifikasi')
                ->default(function(callable $get){
                    $pho1 = PohonInduk::find($get('pohon_induk_id'));
                    return $pho1->lembaga_serti_id;
                }),
                Forms\Components\Hidden::make('lembaga_id')
                ->label('Lembaga Produsen')
                ->default(function(callable $get){
                    $pho1 = PohonInduk::find($get('pohon_induk_id'));
                    $pho2 = KepemilikanPohonInduk::where('id',$pho1->pemilik_pohon_id)->first();
                    return $pho2->lembaga_id;
                }),
                Forms\Components\TextInput::make('no_registrasi')
                ->label('No. Registrasi')
                    ->required()
                    ->maxLength(255),
                ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('no_registrasi')
                ->label('No. Registrasi'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),

            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }    
}
