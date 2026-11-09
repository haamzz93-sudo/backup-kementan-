<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PemohonResource\Pages;
use App\Filament\Resources\PemohonResource\RelationManagers;
use App\Models\Provinces;
use App\Models\Regencies;
use App\Models\Varietas;
use App\Models\VarietasSanggah;
use App\Models\Pemohon;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;


class PemohonResource extends Resource
{
    protected static ?string $model = Pemohon::class;
    // protected static bool $shouldRegisterNavigation = false;
    protected static ?string $navigationIcon = 'heroicon-o-database';
    protected static ?string $navigationGroup = 'Database Varietas';
    protected static ?int $navigationSort = 12;
    protected static ?string $navigationLabel = 'Database Varietas Per Pemohon';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('provinces_id')
                    ->label('Provinsi')
                    ->options(Provinces::all()->pluck('name','id')->toArray())
                    ->reactive()
                    ->required()
                    ->afterStateUpdated(fn (callable $set) => $set('regencies_id',null)),
                Forms\Components\Select::make('regencies_id')
                    ->label('Kabupaten')
                    ->options(function(callable $get){
                        $provinces = Provinces::find($get('provinces_id'));
                        if(!$provinces){
                            return null;
                        }
                        return $provinces->regencies->pluck('name','id');
                    })
                    ->required()
                    ->reactive(),
                Forms\Components\TextInput::make('nama_produsen')
                    ->label('Nama Pemohon')
                    ->maxLength(65535)
                    ->required(),
                Forms\Components\Textarea::make('alamat')
                    ->label('Alamat')
                    ->maxLength(65535)
                    ->required(),
                Forms\Components\TextInput::make('nama_kepala')
                    ->label('Nama Penanggung Jawab')
                    ->maxLength(65535)
                    ->required(),
                Forms\Components\TextInput::make('no_telp')
                ->label('No. Telp')
                ->required()
                ->tel()
                ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\Layout\Split::make([
                    Tables\Columns\Layout\Stack::make([
                        Tables\Columns\TextColumn::make('pr')
                            ->getStateUsing(function($record) {
                                return "Pemohon : ";
                        }),
                        Tables\Columns\TextColumn::make('nama_produsen')
                            ->sortable()
                            ->searchable()
                            ->size('sm')
                            ->color('secondary')
                            ->getStateUsing( function ($record){
                                $pr = $record->nama_produsen;
                                return $pr;
                            }),
                        Tables\Columns\TextColumn::make('kpl')
                            ->getStateUsing(function($record) {
                                return "Penanggung Jawab : ";
                        }),
                        Tables\Columns\TextColumn::make('nama_kepala')
                            ->sortable()
                            ->searchable()
                            ->size('sm')
                            ->color('secondary')
                            ->getStateUsing( function ($record){
                                $pj = $record->nama_kepala;
                                return $pj;
                            }),
                        Tables\Columns\TextColumn::make('tlp')
                            ->getStateUsing(function($record) {
                                return "No. Telepon : ";
                        }),
                        Tables\Columns\TextColumn::make('no_telp')
                            ->size('sm')
                            ->color('secondary')
                            ->getStateUsing( function ($record){
                                $tlp = $record->no_telp;
                                return $tlp;
                            }),
                    ]),
                    
                    Tables\Columns\Layout\Stack::make([
                        Tables\Columns\TextColumn::make('almt')
                            ->getStateUsing(function($record) {
                                return "Alamat : ";
                        }),
                        Tables\Columns\TextColumn::make('alamat')
                            ->size('sm')
                            ->color('secondary')
                            ->getStateUsing( function ($record){
                                $almt = $record->alamat;
                                return $almt;
                            }),
                        Tables\Columns\TextColumn::make('provinces.name')
                            ->size('sm')
                            ->color('secondary')
                            ->sortable()
                            ->searchable(),
                        Tables\Columns\TextColumn::make('regencies.name')  
                            ->size('sm')
                            ->color('secondary')
                            ->sortable(),
                    ]),
                ]),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                ExportBulkAction::make(),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            RelationManagers\VarietasRelationManager::class,
            RelationManagers\VarietasSanggahRelationManager::class,
        ];
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPemohons::route('/'),
            'create' => Pages\CreatePemohon::route('/create'),
            'edit' => Pages\EditPemohon::route('/{record}/edit'),
        ];
    }    
}
