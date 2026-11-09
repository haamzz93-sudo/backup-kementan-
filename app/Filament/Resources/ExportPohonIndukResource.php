<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExportPohonIndukResource\Pages;
use App\Filament\Resources\ExportPohonIndukResource\RelationManagers;
use App\Models\ExportPohonInduk;
use App\Models\ProdusenBenih;
use App\Models\LembagaSertifikasi;
use App\Models\PohonInduk;
use App\Models\Komoditas;
use App\Models\Varietas;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Layout;
class ExportPohonIndukResource extends Resource
{
    protected static ?string $model = ExportPohonInduk::class;

    protected static ?string $navigationIcon = 'heroicon-o-database';
    protected static ?string $navigationGroup = 'Export';
    protected static ?int $navigationSort = 13;
    protected static ?string $navigationLabel = 'Export Database Tanaman Induk';
    //protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('pohon_induk_id')
                    ->maxLength(255),
                Forms\Components\TextInput::make('pemilik_pohon_id')
                    ->maxLength(255),
                Forms\Components\TextInput::make('lembaga_serti_id')
                    ->maxLength(255),
                Forms\Components\TextInput::make('lembaga_id')
                    ->maxLength(255),
                Forms\Components\TextInput::make('no_registrasi')
                    ->maxLength(255),
                Forms\Components\TextInput::make('jumlah_pohon')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('no_registrasi')->searchable(),
                Tables\Columns\TextColumn::make('pohoninduk.tahun_tanam')->label('Tahun Tanam')->searchable(),
                Tables\Columns\TextColumn::make('pohoninduk.tahun_regis')->label('Tahun Registrasi')->searchable(),
                Tables\Columns\TextColumn::make('pohoninduk.komoditas.nama')->label('Komoditas')->searchable(),
                Tables\Columns\TextColumn::make('pohoninduk.varietas.nama_varietas')->label('Varietas'),
                Tables\Columns\TextColumn::make('pohoninduk.label_induk')->label('Kelas Benih'),
                Tables\Columns\TextColumn::make('pohoninduk.kelasbenih.kelas_benih')->label('Status Tanaman Induk'),
                Tables\Columns\TextColumn::make('pemilikpohon.nama_lembaga')->label('Pemilik')->searchable(),
                Tables\Columns\TextColumn::make('lembagasertifikasi.nama_lembaga')->label('Lembaga Sertifikasi'),
                //Tables\Columns\TextColumn::make('kondisipohon.kapasitas')->label('Taksiran Sumber Perbanyakan'),
                
                ])
            ->filters([
            SelectFilter::make('lembaga_serti_id')
                ->label('Lembaga Sertifikasi')
				->searchable()
                ->options(function () {
					$gruplembaga = ExportPohonInduk::groupBy('lembaga_serti_id')->pluck('lembaga_serti_id');
                    return LembagaSertifikasi::whereIn('id', $gruplembaga)->pluck('nama_lembaga', 'id')->toArray();
                }),
			SelectFilter::make('komoditas')
                ->label('Komoditas')
                ->options(function () {
					$grupkom = PohonInduk::groupBy('komoditas_id')->pluck('komoditas_id');
					$kom = Komoditas::whereIn('id', $grupkom)->get();
					return $kom->pluck('nama', 'id')->toArray();
                })
				->searchable()
				->query(function (Builder $query, array $data) {
				if (!empty($data['value']))
				{
					$query->whereHas(
						'pohoninduk',
						fn (Builder $query) => $query->where('komoditas_id', '=', (int) $data['value'])
					);
				}
			}),
            ],layout: Layout::AboveContent)
            ->actions([
                //Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                //Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    public static function getEloquentQuery(): Builder
    {
 if (auth()->user()->hasRole("Lembaga Sertifikasi Benih")){
            return parent::getEloquentQuery()->has('pohoninduk')->where('lembaga_serti_id',auth()->user()->lembaga_id);
        }else{
            return parent::getEloquentQuery()->has('pohoninduk');
        } 
            
        
		
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
            'index' => Pages\ListExportPohonInduks::route('/'),
            'create' => Pages\CreateExportPohonInduk::route('/create'),
            'edit' => Pages\EditExportPohonInduk::route('/{record}/edit'),
        ];
    }    
}
