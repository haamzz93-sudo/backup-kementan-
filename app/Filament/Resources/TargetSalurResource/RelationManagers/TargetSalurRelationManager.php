<?php

namespace App\Filament\Resources\TargetSalurResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use App\Models\TargetSalur;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TargetSalurRelationManager extends RelationManager
{
    protected static string $relationship = 'TargetSalur';

    protected static ?string $recordTitleAttribute = 'target_benih_id';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('target_benih_id')
                ->default(fn ($livewire) => $livewire->ownerRecord->getKey())
                ->reactive(),
                Forms\Components\DatePicker::make('tanggal_salur')
                    ->label('Tanggal Target Penyaluran'),
                Forms\Components\TextInput::make('jumlah')
                ->label('Jumlah Penyaluran')
                ->required()
                ->numeric(),
                Forms\Components\Textarea::make('keterangan')
                ->label('Keterangan'),
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tanggal_salur')
                ->date(),
                Tables\Columns\TextColumn::make('jumlah'),
                Tables\Columns\TextColumn::make('keterangan'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
                Tables\Actions\Action::make('Kembali')
                ->label('Kembali')
                ->url(
                    function($livewire)
                    { 
                        return route('filament.resources.target-benihs.edit',[$livewire->ownerRecord->lembaga_id]);
                    }),
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
