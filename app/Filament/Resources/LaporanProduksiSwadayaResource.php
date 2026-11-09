<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LaporanProduksiSwadayaResource\Pages;
use App\Filament\Resources\LaporanProduksiSwadayaResource\RelationManagers;
use App\Models\Cara;
use App\Models\Komoditas;
use App\Models\LaporanProduksiSwadaya;
use App\Models\ChildProduksiSwadaya;
use App\Models\Golongan;
use App\Models\KelasBenih;
use App\Models\Satuan;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LaporanProduksiSwadayaResource extends Resource
{
    protected static ?string $model = LaporanProduksiSwadaya::class;
    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('golongan_id')
                    ->label('Golongan Perbanyakan')
                    ->options(Golongan::all()->pluck('gol_banyak', 'id')->toArray())
                    ->disabled(),
                Forms\Components\Select::make('cara_id')
                    ->label('Metode Perbanyakan')
                    ->options(Cara::all()->pluck('cara_banyak', 'id')->toArray())
                    ->disabled(),
                Forms\Components\Select::make('kelas_benih_id')
                    ->label('Kelas Benih')
                    ->options(KelasBenih::all()->pluck('kelas_benih', 'id')->toArray())
                    ->disabled(),
                Forms\Components\Select::make('komoditas_id')
                    ->label('Komoditas')
                    ->options(Komoditas::all()->pluck('nama', 'id')->toArray())
                    ->disabled(),
                Forms\Components\Select::make('varietas_id')
                    ->label('Varietas')
                    ->options(function (callable $get) {
                        $komoditas = Komoditas::find($get('komoditas_id'));
                        if (!$komoditas) {
                            return null;
                        }
                        return $komoditas->varietas->pluck('nama_varietas', 'id');
                    })
                    ->disabled(),
                Forms\Components\Select::make('satuan_id')
                    ->label('Satuan')
                    ->options(Satuan::all()->pluck('nama_satuan', 'id')->toArray())
                    ->disabled(),
                Forms\Components\CheckboxList::make('sumber_dana')
                    ->label('Jenis Kegiatan')
                    ->options([
                        'apbn' => 'APBN',
                        'apbd' => 'APBD',
                        'mandiri' => 'Mandiri',
                    ])
                    ->disabled(),

                Forms\Components\TextInput::make('nama_dagang')
                    ->label('Merk Dagang')
                    ->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('lembaga_id'),
                Tables\Columns\TextColumn::make('komoditas_id'),
                Tables\Columns\TextColumn::make('varietas_id'),
                Tables\Columns\TextColumn::make('satuan_id'),
                Tables\Columns\TextColumn::make('sumber_dana'),
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
            RelationManagers\ChildProduksiSwadayaRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLaporanProduksiSwadayas::route('/'),
            'create' => Pages\CreateLaporanProduksiSwadaya::route('/create'),
            'edit' => Pages\EditLaporanProduksiSwadaya::route('/{record}/edit'),
        ];
    }
}
