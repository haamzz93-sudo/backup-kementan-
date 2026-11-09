<?php

namespace App\Filament\Resources\LembagaSertifikasiResource\RelationManagers;

use App\Models\SaranaLembaga;
use App\Models\Kondisi;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SaranaLembagaRelationManager extends RelationManager
{
    protected static string $relationship = 'SaranaLembaga';

    protected static ?string $recordTitleAttribute = 'lembaga_id';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('lembaga_id')
                ->default(fn ($livewire) => $livewire->ownerRecord->getKey())
                ->reactive(),
                Forms\Components\TextInput::make('sarpras_lembaga')
                ->label('Nama Sarana')
                ->required()
                ->maxLength(255),
                Forms\Components\Select::make('kondisi_id')
                    ->label('Kondisi Sarpras')
                    ->options(Kondisi::all()->pluck('kondisi_sarpras','id')->toArray())
                    ->reactive(),
                    
                Forms\Components\DatePicker::make('tahun_pengadaan')
                ->label('Tahun Pengadaan'),
                Forms\Components\TextInput::make('sumber_dana')
                ->label('Sumber Dana')
                ->required()
                ->maxLength(255),
                Forms\Components\TextInput::make('qty')
                ->label('Kuantitas')
                ->required()
                ->maxLength(10),
                Forms\Components\FileUpload::make('upload')
                ->label('Upload Foto Sarana Lembaga')
                ->enableDownload()
                ->enableOpen(),
                Forms\Components\Textarea::make('keterangan')
                ->label('Keterangan')
                ->required(),
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('sarpras_lembaga')->label('Sarana Lembaga'),
                Tables\Columns\TextColumn::make('kondisi.kondisi_sarpras')->label('Kondisi Sarana'),
                Tables\Columns\TextColumn::make('tahun_pengadaan')->label('Tahun Pengadaan'),
                Tables\Columns\TextColumn::make('sumber_dana')->label('Sumber Dana'),
                Tables\Columns\TextColumn::make('qty')->label('Kuantitas'),
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
