<?php

namespace App\Filament\Resources\ProduksiBenihResource\RelationManagers;

use App\Models\LaporanProduksiMati;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LaporanProduksiMatiRelationManager extends RelationManager
{
    protected static string $relationship = 'LaporanProduksiMati';
    protected static ?string $title = 'Laporan Kegagalan Saat Produksi';
    protected static ?string $recordTitleAttribute = 'target_benih_id';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                
               Forms\Components\Hidden::make('target_benih_id')
               ->default(fn ($livewire) => $livewire->ownerRecord->getKey())
               ->reactive(),
               Forms\Components\DatePicker::make('tanggal_lapor')
               ->label('Tanggal Pelaporan Kegagalan'),
               Forms\Components\TextInput::make('produksi_mati')
               ->label('Jumlah Benih Gagal Saat Produksi')
               ->numeric()
               ->required(),
               Forms\Components\FileUpload::make('upload')
               ->enableDownload()
               ->label('Upload Bukti')
               ->required()
               ->enableOpen(),
               Forms\Components\Textarea::make('keterangan')
               ->label('Keterangan'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
           ->columns([
                Tables\Columns\TextColumn::make('tanggal_lapor')
                ->label('Tanggal Lapor'),
                Tables\Columns\TextColumn::make('produksi_mati')
                ->label('Jumlah Benih Gagal Saat Produksi'),
                Tables\Columns\TextColumn::make('upload')
                ->label('Foto Bukti'),
                Tables\Columns\TextColumn::make('keterangan')
                ->label('Keterangan'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                ->modalHeading('Laporan Kematian Saat Produksi')
                ->visible(
                    function(){
                            if(auth()->user()->hasRole("Lembaga Sertifikasi Benih")){ 
                                return false;
                            }
                            else{
                                return true;
                            }
                        }
                    ),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->defaultSort('id', 'desc')
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }    
}
