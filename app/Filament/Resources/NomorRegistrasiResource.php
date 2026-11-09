<?php

namespace App\Filament\Resources;
use DB;
use App\Filament\Resources\NomorRegistrasiResource\Pages;
use App\Filament\Resources\NomorRegistrasiResource\RelationManagers;
use App\Models\Komoditas;
use App\Models\NomorRegistrasi;
use App\Models\PohonInduk;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class NomorRegistrasiResource extends Resource
{
    protected static ?string $model = NomorRegistrasi::class;
    // protected static bool $shouldRegisterNavigation = false;
    protected static ?string $navigationIcon = 'heroicon-o-cube';
    protected static ?string $navigationGroup = 'Tanaman Induk';
    protected static ?int $navigationSort = 5;
    protected static ?string $navigationLabel = 'Laporan Kondisi Tanaman Induk';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Placeholder::make('no_registrasi')
                        ->label(__('No. Registrasi'))
                        ->content(fn ($record) => $record->no_registrasi)
                        ->hiddenOn('create'),
                //Forms\Components\TextInput::make('no_registrasi')
                //->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('no_registrasi')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('pemilikpohon.nama_lembaga')->label('Pemilik')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('lembagasertifikasi.nama_lembaga')->label('Lembaga Sertifikasi')->sortable()->searchable(),
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
            RelationManagers\KondisiPohonRelationManager::class,
        ];
    }
    
    public static function getEloquentQuery(): Builder
    {
        if (auth()->user()->hasRole("Lembaga Sertifikasi Benih")){
            return parent::getEloquentQuery()->where('lembaga_serti_id',auth()->user()->lembaga_id);
        }elseif (auth()->user()->hasRole("Produsen Benih") or auth()->user()->hasRole("Pelapor")){
            return parent::getEloquentQuery()->where('lembaga_id',auth()->user()->lembaga_id);
        }else{
            return parent::getEloquentQuery();
        } 
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNomorRegistrasis::route('/'),
            'create' => Pages\CreateNomorRegistrasi::route('/create'),
            'edit' => Pages\EditNomorRegistrasi::route('/{record}/edit'),
        ];
    }    
}
