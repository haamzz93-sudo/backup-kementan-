<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExportVarietasMasaSanggahResource\Pages;
use App\Filament\Resources\ExportVarietasMasaSanggahResource\RelationManagers;
use App\Models\ExportVarietasMasaSanggah;
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
use App\Models\VarietasSanggah;
use App\Models\KelKomoditas;
use App\Models\Komoditas;
class ExportVarietasMasaSanggahResource extends Resource
{
    protected static ?string $model = ExportVarietasMasaSanggah::class;

    protected static ?string $navigationIcon = 'heroicon-o-database';
    protected static ?string $navigationGroup = 'Export';
    protected static ?int $navigationSort = 19;
    protected static ?string $navigationLabel = 'Export Database Varietas Masa Sanggah';

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
            Tables\Columns\TextColumn::make('tanggal_entri')->label('Tanggal Lapor'),
            Tables\Columns\TextColumn::make('kelkomoditas.nama_kelompok')->label('Kelompok Komoditas')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('komoditas.nama')->label('Nama Komoditas')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('nama_varietas')->label('Nama Varietas')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('pemulia')->label('Pemulia')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('peneliti')->label('Peneliti')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('verifikasi')
                ->getStateUsing(
                    function ($record) {
                        $now = date("Y-m-d");
                        $time = strtotime($record->tanggal_entri);
                        $final = date("Y-m-d", strtotime("+1 month", $time));
                        if ($record->verifikasi == 2) {
                            return "Tersanggah";
                        } else {
                            if ($final <= $now) {
                                return "Terverifikasi";
                            } else {
                                return "Diajukan";
                            }
                        }
                    }
                )->sortable()->searchable(),
            ])
            ->filters([
                 SelectFilter::make('komkel_id')
                ->label('Kelompok Komoditas')
				->searchable()
                ->options(function () {
                    return KelKomoditas::all()->pluck('nama_kelompok', 'id')->toArray();
                }), // Set the selected value
            SelectFilter::make('komoditas_id')
                ->label('Komoditas')
				->searchable()
                ->options(function () {
                    return Komoditas::all()->pluck('nama', 'id')->toArray();
                }), // Set the selected value
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
            'index' => Pages\ListExportVarietasMasaSanggahs::route('/'),
            'create' => Pages\CreateExportVarietasMasaSanggah::route('/create'),
            'edit' => Pages\EditExportVarietasMasaSanggah::route('/{record}/edit'),
        ];
    }    
}
