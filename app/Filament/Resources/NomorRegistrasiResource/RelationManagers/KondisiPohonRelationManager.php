<?php

namespace App\Filament\Resources\NomorRegistrasiResource\RelationManagers;

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
    protected static ?string $title = 'Kondisi Tanaman Induk';
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
                ->label('Kondisi')
                    ->options([
                    '1' => 'Hidup',
                    '2' => 'Mati',
                    ]),
                    
                Forms\Components\Card::make()
                ->schema([
                    Forms\Components\Repeater::make('taksiran_perbanyakan')
                    ->label('Taksiran Sumber Perbanyakan')
                    ->required()
                    ->schema([
                    Forms\Components\TextInput::make('jumlah_taksiran')
                    ->label('Jumlah')
                    ->required(),
                    Forms\Components\TextInput::make('satuan')
                    ->label('Satuan')
                    ->required(),
                        ])->columns(2),
                    ])->columns(1),
                Forms\Components\Card::make()
                    ->schema([
                Forms\Components\Textarea::make('keterangan'),
                    ])->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tanggal_lapor')
                ->label('Tanggal Lapor'),
                Tables\Columns\TextColumn::make('tambah')
                ->label('Kondisi Terakhir')
                ->enum([
                    '1' => 'Hidup',
                    '2' => 'Mati',
                ]),
                Tables\Columns\TextColumn::make('keterangan')->limit(50),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                ->modalHeading('Buat Laporan Kondisi Tanaman Induk'),
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
