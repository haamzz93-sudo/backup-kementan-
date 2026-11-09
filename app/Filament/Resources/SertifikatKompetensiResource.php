<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SertifikatKompetensiResource\Pages;
use App\Filament\Resources\SertifikatKompetensiResource\RelationManagers;
use App\Models\SertifikatKompetensi;
use App\Models\KelKomoditas;
use App\Models\ProdusenBenih;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SertifikatKompetensiResource extends Resource
{
    protected static ?string $model = SertifikatKompetensi::class;
    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                    Forms\Components\Select::make('lembaga_id')
                        ->options(ProdusenBenih::all()->pluck('nama_lembaga','id')->toArray())
                        ->label('Produsen Benih')
                        ->disabled(),
                    Forms\Components\CheckboxList::make('komkel_id')
                        ->options(KelKomoditas::all()->pluck('nama_kelompok','id')->toArray())
                        ->label('Kelompok Komoditas')
                        ->disabled(),
                    Forms\Components\CheckboxList::make('jenis_kompetensi')
                        ->label('Jenis Kompetensi')
                        ->options([
                            'produsen' => 'Produsen',
                            'pengedar' => 'Pengedar',
                        ])
                        ->disabled(),
                    Forms\Components\TextInput::make('no_serti')
                        ->label('No. Sertifikat')
                        ->disabled(),
                    Forms\Components\FileUpload::make('upload')
                        ->enableDownload()
                        ->enableOpen()
                        ->disabled(),
                    Forms\Components\DatePicker::make('tgl_awal')
                        ->label('Tanggal Penetapan Sertifikat')
                        ->disabled(),
                    Forms\Components\DatePicker::make('tgl_akhir')
                        ->label('Tanggal Berakhir Sertifikat')
                        ->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('lembaga_id'),
                Tables\Columns\TextColumn::make('no_serti'),
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\TextColumn::make('komkel_id'),
                Tables\Columns\TextColumn::make('komoditas_id'),
                Tables\Columns\TextColumn::make('varietas_id'),
                Tables\Columns\TextColumn::make('luas_lahan'),
                Tables\Columns\TextColumn::make('upload'),
                Tables\Columns\TextColumn::make('tgl_awal')
                    ->date(),
                Tables\Columns\TextColumn::make('tgl_akhir')
                    ->date(),
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
            RelationManagers\PerpanjanganSMMRelationManager::class,
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSertifikatKompetensis::route('/'),
            'create' => Pages\CreateSertifikatKompetensi::route('/create'),
            'edit' => Pages\EditSertifikatKompetensi::route('/{record}/edit'),
        ];
    }    
}
