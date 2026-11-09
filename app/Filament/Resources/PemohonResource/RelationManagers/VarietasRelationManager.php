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

class VarietasRelationManager extends RelationManager
{
    protected static string $relationship = 'Varietas';
    protected static ?string $title = 'Varietas';
    protected static ?string $recordTitleAttribute = 'komoditas_id';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                
                Forms\Components\Hidden::make('produsen_id')
                ->default(fn ($livewire) => $livewire->ownerRecord->getKey())
                ->reactive(),
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
                    ->required(),
                    Forms\Components\TextInput::make('kode')
                    ->label('Kode Varietas'),
                    Forms\Components\TextInput::make('tahun_daftar')
                    ->label('Tahun Pendaftaran')
                    ->numeric()
                    ->required(),
                    
                    Forms\Components\TextInput::make('no_sk')
                    ->label('No. SK')
                    ->required(),
                    Forms\Components\Card::make()
                    ->schema([
                    Forms\Components\CheckboxList::make('wil_adaptasi')
                    ->label('Wilayah Adaptasi')
                    ->options([
                        '1' => 'Dataran Rendah',
                        '2' => 'Dataran Menengah',
                        '3' => 'Dataran Tinggi',
                    ])->required(),
                    Forms\Components\CheckboxList::make('iklim')
                    ->label('Jenis Musim')
                    ->options([
                        '1' => 'Musim Hujan',
                        '2' => 'Musim Kemarau',
                    ])->required(),
                    Forms\Components\Select::make('asal')
                    ->label('Asal Varietas')
                    ->options([
                        '1' => 'Introduksi',
                        '2' => 'Dalam Negeri',
                    ])->required(),
                    ])->columns(3),
                    Forms\Components\Card::make()
                    ->schema([
                    Forms\Components\FileUpload::make('upload_produk')
                    ->enableDownload()
                    ->enableOpen()
                    ->label('Upload Produk')
                    ->required(),
                    Forms\Components\FileUpload::make('upload_penciri')
                    ->enableDownload()
                    ->label('Upload Penciri')
                    ->enableOpen()
                    ->required(),
                    Forms\Components\FileUpload::make('upload_deskripsi')
                    ->enableDownload()                    
                    ->enableOpen()
                    ->label('Upload Deskripsi')
                    ->required()
                    ])->columns(3),
                    
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kelkomoditas.nama_kelompok')->label('Kelompok Komoditas'),
                Tables\Columns\TextColumn::make('komoditas.nama')->label('Nama Komoditas'),
                Tables\Columns\TextColumn::make('nama_varietas')->label('Nama Varietas'),
                Tables\Columns\TextColumn::make('kode')->label('Kode Varietas'),
                Tables\Columns\TextColumn::make('tahun_daftar')->label('Tahun Daftar'),
                Tables\Columns\TextColumn::make('no_sk')->label('No. SK'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                ->modalHeading('Varietas'),
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
