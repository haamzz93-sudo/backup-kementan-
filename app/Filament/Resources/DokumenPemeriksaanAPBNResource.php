<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DokumenPemeriksaanAPBNResource\Pages;
use App\Filament\Resources\DokumenPemeriksaanAPBNResource\RelationManagers;
use App\Models\DokumenPemeriksaanAPBN;
use App\Models\LaporanTargetBenih;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DokumenPemeriksaanAPBNResource extends Resource
{
    protected static ?string $model = DokumenPemeriksaanAPBN::class;
    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('target_benih_id')
                    ->default(request()->query('ownerRecord'))
                    ->reactive(),
                    
                Forms\Components\FileUpload::make('upload_dokumen')
                    ->enableDownload()
                    ->enableOpen()
                    ->required(),
                Forms\Components\Select::make('no_induk_sertifikasi')
                ->options(
                    function($get){
                    $idtarget = LaporanTargetBenih::where('id',$get('target_benih_id'))->first();
                    $json1 = json_encode($idtarget->no_induk);
                    $json = json_decode($json1);
					
                    foreach($json as $js){
                        $st[$js->nomor] = $js->nomor;
                    }
                    return $st;
                    }
                    ),
                Forms\Components\TextInput::make('jenis_dokumen')
                    ->disabled()
                    ->default(request()->query('dok1')),
                Forms\Components\Textarea::make('keterangan'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //Tables\Columns\TextColumn::make('target_benih_id'),
                Tables\Columns\TextColumn::make('jenis_dokumen'),
				Tables\Columns\TextColumn::make('no_induk_sertifikasi'),
                Tables\Columns\TextColumn::make('upload_dokumen'),
                Tables\Columns\TextColumn::make('keterangan'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                //Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListDokumenPemeriksaanAPBNS::route('/'),
            'create' => Pages\CreateDokumenPemeriksaanAPBN::route('/create'),
            'edit' => Pages\EditDokumenPemeriksaanAPBN::route('/{record}/edit'),
        ];
    }    
    public static function getEloquentQuery(): Builder
    {
        if(isset($_GET['ownerRecord']) and isset($_GET['dok1'])){
            return parent::getEloquentQuery()->where('target_benih_id',$_GET['ownerRecord'])->where('jenis_dokumen',$_GET['dok1']);
        }else{
            return parent::getEloquentQuery();
        }
        
    
    }
}
