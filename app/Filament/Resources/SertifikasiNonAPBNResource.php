<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SertifikasiNonAPBNResource\Pages;
use App\Filament\Resources\SertifikasiNonAPBNResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationGroup;
use App\Models\SertifikasiNonAPBN;
use App\Models\LaporanSertifikasiNonAPBN;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\ProduksiBenihUmum;
use App\Models\Komoditas;
use App\Models\Varietas;
use App\Models\Satuan;
class SertifikasiNonAPBNResource extends Resource
{
    protected static ?string $model = SertifikasiNonAPBN::class;
    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\Hidden::make('lembaga_id')
                ->default(fn ($livewire) => $livewire->ownerRecord->getKey())
                ->reactive()
                ->disabled(),
                Forms\Components\DatePicker::make('tanggal_lapor')
                ->label('Tanggal Lapor')
                ->required()
                ->disabled(),
                Forms\Components\Select::make('komoditas_id')
                ->label('Komoditas')
                ->options(Komoditas::all()->pluck('nama','id')->toArray())
                ->searchable()
                ->reactive()
                ->required()
                ->disabled(),
                Forms\Components\Select::make('varietas_id')
                ->label('Varietas')
                ->options(function(callable $get){
                    $komoditas = Komoditas::find($get('komoditas_id'));
                    if(!$komoditas){
                        return null;
                    }
                    return $komoditas->varietas->pluck('nama_varietas','id');
                })
                ->reactive()
                ->required()
                ->disabled(),
                Forms\Components\Select::make('satuan_id')
                ->label('Satuan')
                ->options(Satuan::all()->pluck('nama_satuan','id')->toArray())
                ->reactive()
                ->required()
                ->disabled(),
                    Forms\Components\Select::make('sumber_dana')
                    ->label("Jenis Kegiatan")
                        ->options([
                        '1' => 'APBD',
                        '2' => 'Madndiri',
                        ])
                ->disabled(),
                Forms\Components\TextInput::make('produksi_benih')
                ->label('Produksi')
                ->required()
                ->numeric()
                ->disabled(),
                Forms\Components\TextInput::make('salur_benih')
                ->label('Penyaluran')
                ->numeric()
                ->required()
                ->disabled(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('lembaga_id'),
                Tables\Columns\TextColumn::make('tanggal_lapor')
                    ->date(),
                Tables\Columns\TextColumn::make('komoditas_id'),
                Tables\Columns\TextColumn::make('varietas_id'),
                Tables\Columns\TextColumn::make('satuan_id'),
                Tables\Columns\TextColumn::make('sumber_dana')
                ->label('Jenis Kegiatan')
                ->getStateUsing( function ($record){
                    $lb = $record->sumber_dana;
                    if($lb=="1"){
                    return "APBD";
                    }elseif($lb=="2"){
                        return "Mandiri";
                        }
                        }),
                Tables\Columns\TextColumn::make('stok_lalu'),
                Tables\Columns\TextColumn::make('produksi_benih'),
                Tables\Columns\TextColumn::make('salur_benih'),
                Tables\Columns\TextColumn::make('stok_benih'),
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
            RelationGroup::make('Label QRcode Non APBN', [
            RelationManagers\QRNonRelationManager::class,
            //RelationManagers\LaporanSertifikasiNonAPBNRelationManager::class,
            ])
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSertifikasiNonAPBNS::route('/'),
            'create' => Pages\CreateSertifikasiNonAPBN::route('/create'),
            'edit' => Pages\EditSertifikasiNonAPBN::route('/{record}/edit'),
        ];
    }    
}
