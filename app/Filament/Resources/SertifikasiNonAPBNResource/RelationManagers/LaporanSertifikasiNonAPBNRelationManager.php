<?php

namespace App\Filament\Resources\SertifikasiNonAPBNResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LaporanSertifikasiNonAPBNRelationManager extends RelationManager
{
    protected static string $relationship = 'LaporanSertifikasiNonAPBN';

    protected static ?string $recordTitleAttribute = 'lap_produksi_swadaya_id';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('lap_produksi_swadaya_id')
                ->default(fn ($livewire) => $livewire->ownerRecord->getKey())
                ->reactive(),
                    Forms\Components\DatePicker::make('tanggal_lapor')                    
                    ->required(),
                    Forms\Components\Select::make('jenis_dokumen')
                        ->options([
                        'pengajuan sertifikasi' => 'Pengajuan Sertifikasi',
                        'pemeriksaan 1' => 'Pemeriksaan 1',
                        'pemeriksaan 2' => 'Pemeriksaan 2',
                        'pemeriksaan 3' => 'Pemeriksaan 3',
                        'labeling' => 'Labeling',
                        'upload sertifikat' => 'Upload Sertifikat',
                        'upload dokumen penyaluran' => 'Upload Dokumen Penyaluran',
                        
                        ])
                        ->required(),
                    Forms\Components\FileUpload::make('upload_dokumen')
                    ->enableDownload()
                    ->enableOpen()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tanggal_lapor')
                ->date(),
                Tables\Columns\TextColumn::make('jenis_dokumen')
                ->getStateUsing( function ($record){
                    $lb = $record->jenis_dokumen;
                    if($lb=="pengajuan sertifikasi"){
                    return "Pengajuan Sertifikasi";
                    }elseif($lb=="pemeriksaan 1"){
                        return "Pemeriksaan 1";
                        }elseif($lb=="pemeriksaan 2"){
                            return "Pemeriksaan 2";
                            }elseif($lb=="pemeriksaan 3"){
                                return "Pemeriksaan 3";
                                }elseif($lb=="labeling"){
                                    return "Labeling";
                                }elseif($lb=="upload sertifikat"){
                                    return "Upload Sertifikat";
                                }elseif($lb=="upload dokumen penyaluran"){
                                    return "Upload Dokumen Penyaluran";
                                }
                }),
                Tables\Columns\TextColumn::make('upload_dokumen')
                ->label("Dokumen Sertifikat"),
                
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }    
}
