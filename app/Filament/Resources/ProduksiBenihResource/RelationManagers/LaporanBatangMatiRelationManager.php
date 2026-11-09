<?php

namespace App\Filament\Resources\ProduksiBenihResource\RelationManagers;

use App\Models\LaporanBatangMati;
use App\Models\Cara;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LaporanBatangMatiRelationManager extends RelationManager
{
    protected static string $relationship = 'LaporanBatangMati';
    protected static ?string $title = 'Laporan Kegagalan Pada Batang Bawah';
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
                Forms\Components\TextInput::make('jumlah')
                ->label('Jumlah Benih Gagal Setelah Sambung')
                ->numeric()
                ->required(),
                Forms\Components\TextInput::make('btgbwh_mati')
                ->label('Jumlah Batang Bawah Mati')
                ->numeric()
                ->required(),
                Forms\Components\FileUpload::make('upload')
                ->enableDownload()
                ->label('Upload Bukti')
                ->required()
                ->enableOpen(),
                Forms\Components\Textarea::make('keterangan')
                ->label('Keterangan')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tanggal_lapor')
                ->label('Tanggal Lapor'),
                Tables\Columns\TextColumn::make('jumlah')
                ->label('Jumlah Benih Gagal Setelah Sambung'),
                Tables\Columns\TextColumn::make('btgbwh_mati')
                ->label('Jumlah Batang Bawah Mati'),
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
                ->modalHeading('Laporan Kematian Pada Batang Bawah')
                ->visible(
                    function(RelationManager $livewire): bool{
                        $cekcara = $livewire->ownerRecord->cara_id;
                        $tes = Cara::where('id',$cekcara)->first();
                            if(auth()->user()->hasRole("Lembaga Sertifikasi Benih")){ 
                                return false;
                            }
                            else{
                                return true;
                            }
                            if($tes->btg_bwh==1){
                                return true;
                            }else{
                               return false; 
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
