<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExportProduksiNonAPBNResource\Pages;
use App\Filament\Resources\ExportProduksiNonAPBNResource\RelationManagers;
use App\Models\ExportProduksiNonAPBN;
use App\Models\Provinces;
use App\Models\Komoditas;
use App\Models\Varietas;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Layout;
class ExportProduksiNonAPBNResource extends Resource
{
    protected static ?string $model = ExportProduksiNonAPBN::class;

    protected static ?string $navigationIcon = 'heroicon-o-database';
    protected static ?string $navigationGroup = 'Export';
    protected static ?int $navigationSort = 15;
    protected static ?string $navigationLabel = 'Export Database Produksi Non APBN';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
            ]);
    }

    public static function table(Table $table): Table
    {   
        return $table
            ->columns([
			Tables\Columns\TextColumn::make('produksiumum.kode_produsen')
                ->label("Kode Produsen"),
				 Tables\Columns\TextColumn::make('produksiumum.jenis_produsen.nama_jenis')
                ->label("Jenis Produsen"),
                Tables\Columns\TextColumn::make('produksiumum.nama_lembaga')
                ->label("Nama Produsen"),
				Tables\Columns\TextColumn::make('produksiumum.provinces.name')
                ->label("Nama Provinsi"),
				Tables\Columns\TextColumn::make('produksiumum.regencies.name')
                ->label("Nama Kab/Kota"),
				Tables\Columns\TextColumn::make('produksiumum.districts.name')
                ->label("Nama Kecamatan"),
				Tables\Columns\TextColumn::make('produksiumum.villages.name')
                ->label("Nama Desa"),
				 Tables\Columns\TextColumn::make('produksiumum.alamat')
                ->label("Alamat Produsen"),
                Tables\Columns\TextColumn::make('komoditas.nama')
                ->label("Nama Komoditas"),
                Tables\Columns\TextColumn::make('varietas.nama_varietas')
                ->label("Nama Varietas"),
                Tables\Columns\TextColumn::make('satuan.nama_satuan')
                ->label("Satuan"),
				 Tables\Columns\TextColumn::make('produksi')
                ->label("Jumlah Produksi")
				->getStateUsing(function($record){
					return number_format(($record->childproduksiswadaya->sum('produksi_benih')),0,",",".");
				}),
				 Tables\Columns\TextColumn::make('salur')
                ->label("Jumlah Penyaluran")
				->getStateUsing(function($record){
					return number_format(($record->childproduksiswadaya->sum('salur_benih')),0,",",".");
				}),
				 Tables\Columns\TextColumn::make('stok')
                ->label("Stok Saat Ini")
				->getStateUsing(function($record){
					return number_format(($record->childproduksiswadaya->sum('produksi_benih')-$record->childproduksiswadaya->sum('salur_benih')),0,",",".");
				}),
                Tables\Columns\TextColumn::make('sumber_dana')
                ->label("Sumber Dana"),
            ])
             ->filters([
            SelectFilter::make('provinsi')
                ->label('Provinsi')
				->searchable()
                ->options(function () {
                    return Provinces::all()->pluck('name', 'id')->toArray();
                })
				->query(function (Builder $query, array $data) {
				if (!empty($data['value']))
				{
					$query->whereHas(
						'produksiumum',
						fn (Builder $query) => $query->where('provinces_id', '=', (int) $data['value'])
					);
				}
			}),
			SelectFilter::make('komoditas_id')
                ->label('Komoditas')
                ->options(function () {
                    return Komoditas::all()->pluck('nama', 'id')->toArray();
                })
				->searchable()
				,
            ],layout: Layout::AboveContent)
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
    public static function canEdit(Model $record): bool
    {
        return false;
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListExportProduksiNonAPBNS::route('/'),
            'create' => Pages\CreateExportProduksiNonAPBN::route('/create'),
            'edit' => Pages\EditExportProduksiNonAPBN::route('/{record}/edit'),
        ];
    }    
}
