<?php

namespace App\Filament\Resources\SertifikasiBenihResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use App\Models\ProsesPerbanyakanBenih;
use App\Models\LaporanTargetBenih;
use App\Models\Cara;
use App\Models\DokumenPemeriksaanAPBN;
use App\Filament\Resources\DokumenPemeriksaanAPBNResource;

class PerbanyakanbenihRelationManager extends RelationManager
{
    protected static string $relationship = 'perbanyakanbenih';

    protected static ?string $title = 'Proses Perbanyakan Benih';
    protected static ?string $recordTitleAttribute = 'tanggal_tanam';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
               Forms\Components\Hidden::make('target_benih_id')
                    ->default(fn ($livewire) => $livewire->ownerRecord->getKey())
                    ->reactive(),
                Forms\Components\DatePicker::make('tanggal_lapor')
                    ->label('Tanggal Perbanyakan Benih'),
                Forms\Components\TextInput::make('jumlah_entres')
                    ->label('Jumlah Penyediaan Entres')
                    ->numeric()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('pengadaan_benih')
                    ->label('Jumlah Benih yang Diperbanyak')
                    ->numeric()
                    ->required()
                    ->maxLength(255),
                Forms\Components\FileUpload::make('upload')
                ->enableDownload()
                    ->label('Foto Perbanyakan')
                    ->required()
                    ->enableOpen(),
                Forms\Components\Textarea::make('keterangan')
                    ->label('Keterangan')
                //->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tanggal_lapor')
                ->label('Tanggal Perbanyakan Benih'),
                Tables\Columns\TextColumn::make('jumlah_entres')
                ->label('Jumlah Penyediaan Entres'),
                Tables\Columns\TextColumn::make('pengadaan_benih')
                ->label('Jumlah Benih yang Diperbanyak'),
                Tables\Columns\ImageColumn::make('upload')
                ->label('Foto Perbanyakan')
                ->size(40),
                Tables\Columns\TextColumn::make('keterangan')
                ->label('Keterangan'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
Tables\Actions\Action::make('dokumen1')
                ->label("Buat Laporan Pemeriksaan Petanaman (Pemeriksaan 1)")
                ->url(fn ($livewire) => DokumenPemeriksaanAPBNResource::getUrl('create', ['ownerRecord' => $livewire->ownerRecord->getKey(),'dok1'=>"Laporan Pemeriksaan Petanaman (Pemeriksaan 1)"]))->visible(
				function($livewire){
					if($livewire->ownerRecord->no_induk){
						return true;
					}else{
						return false;
					}
				}
				),
                Tables\Actions\Action::make('dokumen1a')
                ->label("Lihat/Ubah Laporan Pemeriksaan Petanaman (Pemeriksaan 1)")
                ->url(fn ($livewire) => DokumenPemeriksaanAPBNResource::getUrl('index', ['ownerRecord' => $livewire->ownerRecord->getKey(),'dok1'=>"Laporan Pemeriksaan Petanaman (Pemeriksaan 1)"]))->visible(
				function($livewire){
					if($livewire->ownerRecord->no_induk){ 
						return true;
					}else{
						return false;
					}
				}
				),
               
            ])
            ->actions([
                //Tables\Actions\EditAction::make(),
                // Tables\Actions\EditAction::make('dokumen')
                //     ->label('Dokumen Pemeriksaan')
                //     ->color('warning')
                //     ->icon('heroicon-o-check-circle')
                //     ->form([
                //         Forms\Components\FileUpload::make('dokumen_pengajuan')
                //         ->label('Dokumen Pemeriksaan')
                //     ->enableDownload()
                //     ->enableOpen()
                //     ->disk('local')
                //     ->directory('dokumen_pengajuan2')
                //     ->visibility('public')
                //     ->acceptedFileTypes(['application/pdf']),
                //     Forms\Components\Textarea::make('keterangan_dokumen')
                //     ->columnSpan('full'),
                //     ]),
               // Tables\Actions\DeleteAction::make(),
            ])
            ->defaultSort('id', 'desc')
            ->bulkActions([
                //Tables\Actions\DeleteBulkAction::make(),
            ]);
    }    
}
