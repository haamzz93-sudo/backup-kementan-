<?php

namespace App\Filament\Resources\LembagaSertifikasiResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AkreditasiRelationManager extends RelationManager
{
    protected static string $relationship = 'Akreditasi';

    protected static ?string $recordTitleAttribute = 'lembaga_id';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('lembaga_id')
                ->default(fn ($livewire) => $livewire->ownerRecord->getKey())
                ->reactive(),
                Forms\Components\TextInput::make('no_akre')
                    ->label('No. Akreditasi')
                    ->required()
                    ->maxLength(255),
                    
                
                Forms\Components\DatePicker::make('tanggal_awal')
                    ->label('Tanggal Ditetapkan'),
                Forms\Components\DatePicker::make('tanggal_akhir')
                    ->label('Berlaku Hingga'),
                    Forms\Components\FileUpload::make('upload')
                    ->label('Upload Sertifikat')
                    ->enableDownload()
                    ->enableOpen(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('no_akre')->label('No. Akreditasi'),
                Tables\Columns\TextColumn::make('tanggal_awal')->label('Tanggal Ditetapkan'),
                Tables\Columns\TextColumn::make('tanggal_akhir')->label('Berlaku Hingga'),
                Tables\Columns\TextColumn::make('upload_serti')->label('Upload Sertifikat'),
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
