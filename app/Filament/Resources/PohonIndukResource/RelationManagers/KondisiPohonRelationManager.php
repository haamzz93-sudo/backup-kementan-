<?php

namespace App\Filament\Resources\PohonIndukResource\RelationManagers;

use App\Models\PohonInduk;
use App\Models\NomorRegistrasi;
use App\Models\KondisiPohon;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KondisiPohonRelationManager extends RelationManager
{
    protected static string $relationship = 'KondisiPohon';

    protected static ?string $recordTitleAttribute = 'child_pohon_induk_id';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('child_pohon_induk_id')
                ->default(fn ($livewire) => $livewire->ownerRecord->getKey())
                ->reactive(),
                Forms\Components\DatePicker::make('tanggal_lapor'),
                Forms\Components\Select::make('tambah')
                    ->options([
                    '1' => 'Hidup',
                    '2' => 'Mati',
                    ]),
                Forms\Components\TextInput::make('kapasitas')
                    ->required()
                    ->maxLength(255),
                Forms\Components\FileUpload::make('upload')
                ->enableDownload()
                ->enableOpen(),
                Forms\Components\Card::make()
                    ->schema([
                Forms\Components\Textarea::make('keterangan')
                    ->required(),
                    ])->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tanggal_lapor'),
                Tables\Columns\TextColumn::make('tambah'),
                Tables\Columns\TextColumn::make('kapasitas'),
                Tables\Columns\ImageColumn::make('upload')
                ->size(40),
                Tables\Columns\TextColumn::make('keterangan')->limit(50),
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
