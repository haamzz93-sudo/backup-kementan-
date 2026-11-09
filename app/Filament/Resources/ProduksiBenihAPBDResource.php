<?php

namespace App\Filament\Resources;

use DB;
use App\Filament\Resources\ProduksiBenihAPBDResource\Pages;
use App\Filament\Resources\ProduksiBenihAPBDResource\RelationManagers;
use App\Models\Provinces;
use App\Models\Regencies;
use App\Models\Districts;
use App\Models\Villages;
use App\Models\JenisLembaga;
use App\Models\JenisProdusen;
use App\Models\ProduksiBenihAPBD;
use App\Models\LaporanBenihPTM;
use App\Models\ProsesPerbanyakanBenih;
use App\Models\ProdusenBenih;
use App\Models\KelKomoditas;
use App\Models\Komoditas;
use App\Models\Varietas;
use App\Models\KelasBenih;
use App\Models\Golongan;
use App\Models\Cara;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProduksiBenihAPBDResource extends Resource
{
    protected static ?string $model = ProduksiBenihAPBD::class;
    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $navigationIcon = 'heroicon-o-collection';
    protected static ?string $navigationGroup = 'Laporan';
    
    protected static ?int $navigationSort = 8;
    protected static ?string $navigationLabel = 'Laporan Produksi Benih APBD';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Textarea::make('nomor_induk')
                    ->maxLength(16777215),
                Forms\Components\DatePicker::make('tanggal_lapor'),
                Forms\Components\TextInput::make('lembaga_id')
                    ->maxLength(255),
                Forms\Components\TextInput::make('komoditas_id')
                    ->maxLength(255),
                Forms\Components\TextInput::make('varietas_id')
                    ->maxLength(255),
                Forms\Components\TextInput::make('kelas_benih_id')
                    ->maxLength(255),
                Forms\Components\TextInput::make('jum_target'),
                Forms\Components\TextInput::make('komkel_id')
                    ->maxLength(255),
                Forms\Components\TextInput::make('cara_id')
                    ->maxLength(255),
                Forms\Components\TextInput::make('golongan_id')
                    ->maxLength(255),
                Forms\Components\Textarea::make('lokasi_produksi_detail_id')
                    ->maxLength(16777215),
                Forms\Components\TextInput::make('tahun')
                    ->maxLength(255),
                Forms\Components\TextInput::make('upload_ubah')
                    ->maxLength(255),
                Forms\Components\Textarea::make('status')
                    ->maxLength(16777215),
                Forms\Components\DatePicker::make('tanggal_lapor_tanam'),
                Forms\Components\DatePicker::make('tanggal_lapor_panen'),
                Forms\Components\DatePicker::make('tanggal_lapor_salur'),
                Forms\Components\Textarea::make('satuan_id')
                    ->maxLength(16777215),
                Forms\Components\Textarea::make('luas_tanam')
                    ->maxLength(16777215),
                Forms\Components\DatePicker::make('tanggal_r_tanam'),
                Forms\Components\DatePicker::make('tanggal_r_panen'),
                Forms\Components\DatePicker::make('tanggal_r_salur'),
                Forms\Components\Textarea::make('jum_s_benih')
                    ->maxLength(16777215),
                Forms\Components\Textarea::make('jum_s_ada')
                    ->maxLength(16777215),
                Forms\Components\Textarea::make('jum_s_mati')
                    ->maxLength(16777215),
                Forms\Components\Textarea::make('jum_s_salur')
                    ->maxLength(16777215),
                Forms\Components\Textarea::make('keterangan')
                    ->maxLength(65535),
                Forms\Components\Textarea::make('sumber_dana')
                    ->maxLength(65535),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nomor_induk'),
                Tables\Columns\TextColumn::make('tanggal_lapor')
                    ->date(),
                Tables\Columns\TextColumn::make('lembaga_id'),
                Tables\Columns\TextColumn::make('komoditas_id'),
                Tables\Columns\TextColumn::make('varietas_id'),
                Tables\Columns\TextColumn::make('kelas_benih_id'),
                Tables\Columns\TextColumn::make('jum_target'),
                Tables\Columns\TextColumn::make('komkel_id'),
                Tables\Columns\TextColumn::make('cara_id'),
                Tables\Columns\TextColumn::make('golongan_id'),
                Tables\Columns\TextColumn::make('lokasi_produksi_detail_id'),
                Tables\Columns\TextColumn::make('tahun'),
                Tables\Columns\TextColumn::make('upload_ubah'),
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\TextColumn::make('tanggal_lapor_tanam')
                    ->date(),
                Tables\Columns\TextColumn::make('tanggal_lapor_panen')
                    ->date(),
                Tables\Columns\TextColumn::make('tanggal_lapor_salur')
                    ->date(),
                Tables\Columns\TextColumn::make('satuan_id'),
                Tables\Columns\TextColumn::make('luas_tanam'),
                Tables\Columns\TextColumn::make('tanggal_r_tanam')
                    ->date(),
                Tables\Columns\TextColumn::make('tanggal_r_panen')
                    ->date(),
                Tables\Columns\TextColumn::make('tanggal_r_salur')
                    ->date(),
                Tables\Columns\TextColumn::make('jum_s_benih'),
                Tables\Columns\TextColumn::make('jum_s_ada'),
                Tables\Columns\TextColumn::make('jum_s_mati'),
                Tables\Columns\TextColumn::make('jum_s_salur'),
                Tables\Columns\TextColumn::make('keterangan'),
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
            //
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProduksiBenihAPBDS::route('/'),
            'create' => Pages\CreateProduksiBenihAPBD::route('/create'),
            'edit' => Pages\EditProduksiBenihAPBD::route('/{record}/edit'),
        ];
    }    
}
