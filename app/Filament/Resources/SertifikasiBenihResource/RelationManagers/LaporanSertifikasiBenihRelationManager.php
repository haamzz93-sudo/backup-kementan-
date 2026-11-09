<?php

namespace App\Filament\Resources\SertifikasiBenihResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LaporanSertifikasiBenihRelationManager extends RelationManager
{
    protected static string $relationship = 'LaporanSertifikasiBenih';
    protected static ?string $title = 'Penentuan Label';
    protected static ?string $recordTitleAttribute = 'lap_benih_panen_id';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('lap_benih_panen_id')
                    ->default(fn ($livewire) => $livewire->ownerRecord->getKey())
                    ->reactive(),
                    
                Forms\Components\TextInput::make('no_label1')
                    ->label('No. Induk Sertifikat')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('tgl_periksa_akhir')
                    ->label('Berlaku Mulai')
                    ->required(),
                Forms\Components\DatePicker::make('tgl_berlaku')
                    ->label('Belaku s/d')
                    ->required(),
                Forms\Components\FileUpload::make('upload')
                    ->enableDownload()
                    ->label('Upload Dokumen Sertifikat')
                    ->required()
                    ->enableOpen(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('no_label1')
                ->label('No. Induk Sertifikat'),
                Tables\Columns\TextColumn::make('tgl_periksa_akhir')
                ->label('Berlaku Mulai'),
                Tables\Columns\TextColumn::make('tgl_berlaku')
                ->label('Belaku s/d'),
                Tables\Columns\TextColumn::make('kode')
                ->label('Kode Master Label'),
                Tables\Columns\TextColumn::make('upload')
                ->label('Upload Dokumen Sertifikat'),
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
