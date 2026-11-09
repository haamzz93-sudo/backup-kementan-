<?php

namespace App\Filament\Resources\SertifikasiBenihResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use App\Models\DokumenPemeriksaanAPBN;
use App\Filament\Resources\DokumenPemeriksaanAPBNResource;
use DB;
use App\Models\PenerimaanBatangBawah;
use App\Models\Cara;
class BatangbawahRelationManager extends RelationManager
{
    protected static string $relationship = 'batangbawah';
    protected static ?string $title = 'Penerimaan Batang Bawah';
    protected static ?string $recordTitleAttribute = 'tanggal_lapor';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                
               Forms\Components\Hidden::make('target_benih_id')
               ->default(fn ($livewire) => $livewire->ownerRecord->getKey())
               ->reactive(),
                Forms\Components\DatePicker::make('tanggal_lapor')
                ->label('Tanggal Lapor'),
                Forms\Components\Select::make('jenis_ada_id')
                ->label('Jenis Penyediaan')
                    ->options([
                    '1' => 'Beli Batang Bawah',
                    '2' => 'Semai Biji',
                    ]),
                Forms\Components\TextInput::make('jumlah')
                ->label('Jumlah Batang Bawah')
                ->numeric()
                ->required()
                ->maxLength(255),
                Forms\Components\FileUpload::make('upload')
                ->enableDownload()
                ->label('Foto Penyediaan')
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
                ->label('Tanggal Lapor'),
                Tables\Columns\TextColumn::make('jenis_ada_id')
                ->label('Jenis Penyediaan')
                ->enum([
                    '1' => 'Beli Batang Bawah',
                    '2' => 'Semai Biji',
            ])->sortable()->searchable(),
                Tables\Columns\TextColumn::make('jumlah')
                ->label('Jumlah Batang Bawah'),
                Tables\Columns\ImageColumn::make('upload')
                ->label('Foto Penyediaan')
                ->size(40),
                Tables\Columns\TextColumn::make('keterangan')
                ->label('Keterangan'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make()
                // ->modalHeading('Laporan Penerimaan Batang Bawah')
                // ->visible(
                //     function(RelationManager $livewire): bool{
                //         $cekcara = $livewire->ownerRecord->cara_id;
                //         $tes = Cara::where('id',$cekcara)->first();
                //         if(auth()->user()->hasRole("Lembaga Sertifikasi Benih")){
                //             return false;
                //         }
                //         else{
                //             return true;
                //         }
                //         if($tes->btg_bwh==1){
                //             return true;
                //             }else{
                //               return false; 
                //             }
                //     }
                // ),
                Tables\Actions\Action::make('dokumen1')
                ->label("Buat Dokumen Pendahuluan")
                ->url(fn ($livewire) => DokumenPemeriksaanAPBNResource::getUrl('create', ['ownerRecord' => $livewire->ownerRecord->getKey(),'dok1'=>"Dokumen Pemeriksaan Pendahuluan
"]))
				->visible(
				function($livewire){
					if($livewire->ownerRecord->no_induk){
						return true;
					}else{
						return false;
					}
				}
				),
				Tables\Actions\Action::make('dokumen1a')
                ->label("Lihat Dokumen Pendahuluan")
                ->url(fn ($livewire) => DokumenPemeriksaanAPBNResource::getUrl('index', ['ownerRecord' => $livewire->ownerRecord->getKey(),'dok1'=>"Dokumen Pemeriksaan Pendahuluan"]))->visible(
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
                //Tables\Actions\EditAction::make(),
                // Tables\Actions\EditAction::make('dokumen')
                // ->label('Dokumen Pemeriksaan')
                // ->color('warning')
                // ->icon('heroicon-o-check-circle')
                // ->form([
                //     Forms\Components\FileUpload::make('dokumen_pengajuan')
                //     ->label('Dokumen Pemeriksaan')
                // ->enableDownload()
                // ->enableOpen()
                // ->disk('local')
                // ->directory('dokumen_pemeriksaan1')
                // ->visibility('public')
                // ->acceptedFileTypes(['application/pdf']),
                // Forms\Components\Textarea::make('keterangan_dokumen')
                // ->columnSpan('full'),
                // ]),
                //Tables\Actions\DeleteAction::make(),
                
            ])
            ->defaultSort('id', 'desc')
            ->bulkActions([
                //Tables\Actions\DeleteBulkAction::make(),
            ]);
    }   
}
