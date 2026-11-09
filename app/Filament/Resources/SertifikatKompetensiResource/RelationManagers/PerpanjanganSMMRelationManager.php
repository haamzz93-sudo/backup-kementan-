<?php

namespace App\Filament\Resources\SertifikatKompetensiResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PerpanjanganSMMRelationManager extends RelationManager
{
    protected static string $relationship = 'PerpanjanganSMM';

    protected static ?string $title = 'Perpanjangan Sertifikat Kompetensi';
    protected static ?string $recordTitleAttribute = 'child_smm_id';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('child_smm_id')
                ->default(fn ($livewire) => $livewire->ownerRecord->getKey())
                ->reactive(),
                
                Forms\Components\TextInput::make('no_perpanjangan')
                    ->label('Nomor Perpanjangan Sertifikat Kompetensi')
                    ->required(),
                Forms\Components\DatePicker::make('tgl_perpanjangan')
                    ->label('Tanggal Perpanjangan Sertifikat Kompetensi')
                    ->required(),
                Forms\Components\DatePicker::make('tgl_berlaku')
                    ->label('Berlaku s/d')
                    ->required(),
                Forms\Components\FileUpload::make('upload_perpanjangan')
                    ->label('Upload Dokumen Perpanjangan')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('no_perpanjangan')
                ->label('Nomor Perpanjangan Sertifikat Kompetensi'),
                Tables\Columns\TextColumn::make('tgl_perpanjangan')
                ->label('Tanggal Perpanjangan Sertifikat Kompetensi'),
                Tables\Columns\TextColumn::make('tgl_berlaku')
                ->label('Berlaku s/d'),
                Tables\Columns\TextColumn::make('upload_perpanjangan')
                ->label('Upload Dokumen Perpanjangan'),
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
