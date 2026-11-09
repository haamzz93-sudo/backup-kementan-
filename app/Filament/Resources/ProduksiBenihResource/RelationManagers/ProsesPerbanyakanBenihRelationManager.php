<?php

namespace App\Filament\Resources\ProduksiBenihResource\RelationManagers;
use App\Filament\Resources\DokumenPemeriksaanAPBNResource;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use App\Models\ProsesPerbanyakanBenih;
use App\Models\LaporanTargetBenih;
use App\Models\Cara;
use App\Models\DokumenPemeriksaanAPBN;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProsesPerbanyakanBenihRelationManager extends RelationManager
{
    protected static string $relationship = 'ProsesPerbanyakanBenih';

    protected static ?string $recordTitleAttribute = 'target_benih_id';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
               Forms\Components\Hidden::make('target_benih_id')
                    ->default(fn ($livewire) => $livewire->ownerRecord->getKey())
                    ->reactive(),
                Forms\Components\DatePicker::make('tanggal_lapor')
                    ->label('Tanggal Perbanyakan Benih'),
                Forms\Components\TextInput::make('jumlah_entres')
                    ->label('Jumlah Penyediaan Entres')
                    ->numeric()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('pengadaan_benih')
                    ->label('Jumlah Benih yang Diperbanyak')
                    ->numeric()
                    ->required()
                    ->maxLength(255),
                Forms\Components\FileUpload::make('upload')
                ->enableDownload()
                    ->label('Foto Perbanyakan')
                    ->required()
                    ->enableOpen(),
                Forms\Components\Textarea::make('keterangan')
                    ->label('Keterangan')
                //->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tanggal_lapor')
                ->label('Tanggal Perbanyakan Benih'),
                Tables\Columns\TextColumn::make('jumlah_entres')
                ->label('Jumlah Penyediaan Entres'),
                Tables\Columns\TextColumn::make('pengadaan_benih')
                ->label('Jumlah Benih yang Diperbanyak'),
                Tables\Columns\ImageColumn::make('upload')
                ->label('Foto Perbanyakan')
                ->size(40),
                Tables\Columns\TextColumn::make('keterangan')
                ->label('Keterangan'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                ->modalHeading('Laporan Perbanyakan Benih')
                ->after(
                    function (RelationManager $livewire) {
                        $idtarget = $livewire->ownerRecord->getKey();
                        $tanggaltanam = ProsesPerbanyakanBenih::select('tanggal_lapor')->where('target_benih_id',$idtarget)->orderBy('tanggal_lapor', 'ASC')->first();
                        $tglnya = $tanggaltanam->tanggal_lapor;
                        return DB::table('target_benih')->where('id',$idtarget)->update(['tanggal_r_tanam' => $tglnya]);
                    }
                )
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
                    Tables\Actions\Action::make('dokumen1a')
                ->label("Laporan Pemeriksaan Petanaman (Pemeriksaan 1)")
                ->url(fn ($livewire) => DokumenPemeriksaanAPBNResource::getUrl('index', ['ownerRecord' => $livewire->ownerRecord->getKey(),'dok1'=>"Laporan Pemeriksaan Petanaman (Pemeriksaan 1)"]))->visible(
				function($livewire){
					if($livewire->ownerRecord->no_induk){
						return true;
					}else{
						return false;
					}
				}
				),
            ])
            ->actions([
                Tables\Actions\EditAction::make()                
                ->after(
                    function (RelationManager $livewire) {
                        $idtarget = $livewire->ownerRecord->getKey();
                        $tanggaltanam = ProsesPerbanyakanBenih::select('tanggal_lapor')->where('target_benih_id',$idtarget)->orderBy('tanggal_lapor', 'ASC')->first();
                        $tglnya = $tanggaltanam->tanggal_lapor;
                        return DB::table('target_benih')->where('id',$idtarget)->update(['tanggal_r_tanam' => $tglnya]);
                    }
                ),
                // Tables\Actions\EditAction::make('dokumen')
                //     ->label('Dokumen Pemeriksaan')
                //     ->color('warning')
                //     ->icon('heroicon-o-check-circle')
                //     ->form([
                //         Forms\Components\FileUpload::make('dokumen_pengajuan')
                //         ->label('Dokumen Pemeriksaan')
                //     ->enableDownload()
                //     ->enableOpen()
                //     ->disk('local')
                //     ->directory('dokumen_pengajuan2')
                //     ->visibility('public')
                //     ->acceptedFileTypes(['application/pdf']),
                //     Forms\Components\Textarea::make('keterangan_dokumen')
                //     ->columnSpan('full'),
                //     ]),
                Tables\Actions\DeleteAction::make(),
            ])
            ->defaultSort('id', 'desc')
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }    
}
