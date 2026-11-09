<?php

namespace App\Filament\Resources\PemohonResource\RelationManagers;

use App\Models\Komoditas;
use App\Models\KelKomoditas;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VarietasSanggahRelationManager extends RelationManager
{
    protected static string $relationship = 'VarietasSanggah';

    protected static ?string $recordTitleAttribute = 'komoditas_id';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
               Forms\Components\Hidden::make('produsen_id')
                ->default(fn ($livewire) => $livewire->ownerRecord->getKey())
                ->reactive(),
                
                Forms\Components\Card::make()
                    ->schema([
                Forms\Components\DatePicker::make('tanggal_entri')
                    ->label('Tanggal Upload')
                    ->required(),
                Forms\Components\Select::make('komkel_id')
                    ->label('Kelompok Komoditas')
                    ->options(KelKomoditas::all()->pluck('nama_kelompok','id')->toArray())
                    ->reactive()
                    ->required(),
                Forms\Components\Select::make('komoditas_id')
                    ->label('Komoditas')
                    ->options(function(callable $get){
                        $komkel = KelKomoditas::find($get('komkel_id'));
                        if(!$komkel){
                            return null;
                        }
                        return $komkel->komoditas->pluck('nama','id');
                    })
                    ->required(),
                    Forms\Components\TextInput::make('nama_varietas')
                    ->label('Varietas')
                    ->required()
                    ->maxLength(255),
                ])->columns(3),
                Forms\Components\Card::make()
                    ->schema([
                Forms\Components\TextInput::make('pemulia')
                    ->label('Pemulia')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('peneliti')
                    ->label('Peneliti')
                    ->required()
                    ->maxLength(255),
                    ])->columns(2),
                Forms\Components\Card::make()
                    ->schema([
                    Forms\Components\FileUpload::make('upload_deskripsi')
                    ->enableDownload()
                    ->enableOpen()
                    ->label('Upload Deskripsi')
                    ->required(),
                    ])->columns(1),
                    
                
                    
                    
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
                    function($record){
                        $now = date("Y-m-d");
                        $time = strtotime($record->tanggal_entri);
                        $final = date("Y-m-d", strtotime("+1 month", $time));
                        if($record->verifikasi==2){
                            return "Tersanggah";
                        }else{
                            if($final <= $now){
                                return "Terverifikasi";
                            }else{
                                return "Diajukan";
                            }
                        }
                        
                    })->sortable()->searchable(),
                    
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                ->modalHeading('Varietas Masa Sanggah'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\EditAction::make('verifikasi')
                    ->label('Verifikasi')
                    ->color('warning')
                    ->icon('heroicon-o-check-circle')
                    ->form([
                    Forms\Components\Select::make('verifikasi')
                    ->label('Verifikasi')
                    ->options([
                        '1' => 'Kembalikan Status',
                        '2' => 'Tersanggah',
                    ])->required(),
                    ])
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }   
}
