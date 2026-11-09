<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExportSebaranVarietasResource\Pages;
use App\Filament\Resources\ExportSebaranVarietasResource\RelationManagers;
use App\Models\ExportSebaranVarietas;
use App\Models\ProvincesSebaran;
use App\Models\Regencies;
use App\Models\KelKomoditas;
use App\Models\Komoditas;
use App\Models\Varietas;
use DB;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Layout;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
class ExportSebaranVarietasResource extends Resource
{
	protected static ?string $model;
	   public function __construct()
	{
		self::$model = ExportSebaranVarietas::groupByVarietas()->get();
	}

    protected static ?string $navigationIcon = 'heroicon-o-database';
    protected static ?string $navigationGroup = 'Export';
    protected static ?int $navigationSort = 17;
    protected static ?string $navigationLabel = 'Export Database Sebaran Varietas';
    //protected static bool $shouldRegisterNavigation = false;

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
             Tables\Columns\TextColumn::make('provinces.name')->label('Provinsi'),
            Tables\Columns\TextColumn::make('regencies.name')->label('Kabupaten/Kota')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('kelkomoditas.nama_kelompok')->label('Nama Kelompok Komoditas')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('komoditas.nama')->label('Nama Komoditas')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('varietas.nama_varietas')->label('Nama Varietas')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('tanggal_lapor_sebar')->label('Tanggal Lapor Terakhir')
            ->getStateUsing(function($record){
                $results = DB::table('varietas_sebar')
                    ->select(DB::raw('MAX(tanggal_lapor_sebar) as max'))
                    ->where([['varietas_id', $record->varietas_id],['regencies_id', $record->regencies_id]])
                    ->first();
                    return $results->max;
            }),
            Tables\Columns\TextColumn::make('luas_sebar')->label('Luas Sebaran')
            ->getStateUsing(function($record){
                $jumlah = DB::table('varietas_sebar')
                    ->select(DB::raw('SUM(luas_sebar) as total_luas_sebar'))
                    ->where([['varietas_id', $record->varietas_id],['regencies_id', $record->regencies_id]])
                    ->whereIn('tanggal_lapor_sebar', function ($query) use ($record) {
                        $query->select(DB::raw('MAX(tanggal_lapor_sebar) as max_tanggal'))
                            ->from('varietas_sebar')
                            ->where([['varietas_id', $record->varietas_id],['regencies_id', $record->regencies_id]]);
                    })
                    ->first();
                return $jumlah->total_luas_sebar." Ha";
                
            }),
            ])
            ->filters([
                 SelectFilter::make('komkel_id')
                ->label('Kelompok Komoditas')
                ->options(function () {
                    return KelKomoditas::all()->pluck('nama_kelompok', 'id')->toArray();
                }), // Set the selected value
            SelectFilter::make('komoditas_id')
                ->label('Komoditas')
                ->options(function () {
                    return Komoditas::all()->pluck('nama', 'id')->toArray();
                }), // Set the selected value
            SelectFilter::make('provinces_id')
                ->label('Provinsi')
                ->options(function () {
                    return ProvincesSebaran::all()->pluck('name', 'id')->toArray();
                }), // Set the selected value
             SelectFilter::make('regencies_id')
                ->label('Kabupaten/Kota')
                ->options(function () {
                    return Regencies::all()->pluck('name', 'id')->toArray();
                }), // Set the selected value
            ],layout: Layout::AboveContent)
            ->actions([
                //Tables\Actions\EditAction::make(),
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
    public static function canEdit(Model $record): bool
    {
        return false;
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListExportSebaranVarietas::route('/'),
            'create' => Pages\CreateExportSebaranVarietas::route('/create'),
            'edit' => Pages\EditExportSebaranVarietas::route('/{record}/edit'),
        ];
    }    
}
