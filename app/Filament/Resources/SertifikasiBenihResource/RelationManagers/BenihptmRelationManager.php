<?php

namespace App\Filament\Resources\SertifikasiBenihResource\RelationManagers;

use App\Filament\Resources\DokumenPemeriksaanAPBNResource;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use App\Models\PemeriksaanTanaman;
use App\Models\ProsesPerbanyakanBenih;
use App\Models\DokumenPemeriksaanAPBN;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use DB;
class BenihptmRelationManager extends RelationManager
{
    protected static string $relationship = 'benihptm';
    protected static ?string $title = 'Sertifikasi Benih';
    protected static ?string $recordTitleAttribute = 'tanggal_panen';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                
               Forms\Components\Hidden::make('target_benih_id')
                ->default(fn ($livewire) => $livewire->ownerRecord->getKey())
                ->reactive(),
                Forms\Components\Select::make('lap_benih_tumbuh_id')
                ->label('Tanggal Perbanyakan Benih')
                ->options(function(callable $livewire){
                    $idtarget = $livewire->ownerRecord->getKey();
                    return ProsesPerbanyakanBenih::where('target_benih_id', $idtarget)->pluck('tanggal_lapor','id')->toArray();
                    })
                ->reactive(),
                Forms\Components\DatePicker::make('tanggal_panen')
                ->label('Tanggal Pelaporan PTM (Pre-Uji)'),
                Forms\Components\TextInput::make('jum_panen')
                ->label('Jumlah Benih PTM (Pre-Uji)')
                ->numeric()
                ->required()
                ->maxLength(255),
                Forms\Components\FileUpload::make('upload')
                ->enableDownload()
                ->label('Upload Foto')
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
               
                Tables\Columns\TextColumn::make('tanggal_panen')
                ->label('Tanggal Pelaporan PTM (Pre-Uji)'),
                Tables\Columns\TextColumn::make('jum_panen')
                ->label('Jumlah Benih PTM (Pre-Uji)'),
                Tables\Columns\TextColumn::make('upload')
                ->label('Upload Foto'),
                Tables\Columns\TextColumn::make('keterangan')
                ->label('Keterangan'),
                
                Tables\Columns\TextColumn::make('status')
                ->label('Pengajuan Pemeriksaan Benih')
                ->enum([
                    '' => 'Belum Diajukan',
                    '0' => 'Diajukan',
                    '1' => 'Sudah Diperiksa',
            ])->sortable()->searchable(),
            
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //Tables\Actions\CreateAction::make(),
               Tables\Actions\Action::make('dokumen1')
                ->label("Buat Dokumen Pemeriksaan Siap Salur/Di Gudang")
                ->url(fn ($livewire) => DokumenPemeriksaanAPBNResource::getUrl('create', ['ownerRecord' => $livewire->ownerRecord->getKey(),'dok1'=>"Dokumen Pemeriksaan Siap Salur"]))->visible(
				function($livewire){
					if($livewire->ownerRecord->no_induk){
						return true;
					}else{
						return false;
					}
				}
				),
                Tables\Actions\Action::make('dokumen1a')
                ->label("Lihat/Ubah Dokumen Pemeriksaan Siap Salur/Di Gudang")
                ->url(fn ($livewire) => DokumenPemeriksaanAPBNResource::getUrl('index', ['ownerRecord' => $livewire->ownerRecord->getKey(),'dok1'=>"Dokumen Pemeriksaan Siap Salur"]))->visible(
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
                Tables\Actions\Action::make('status')
                    ->label('Ajukan Pemeriksaan Benih')
                    ->action(
                        function ($record) {
                            $id = $record->id;
                            return[
                                DB::table('lap_benih_panen')->where('id',$id)->update([
                                    'status' => 0,
                                ])
                            ];
                        }
                )
                ->visible(function ($record){
                    if($record->status=="0" or $record->status=="1" )
                    {return false;}
                    else
                    {return true;}
                }),
                //Tables\Actions\EditAction::make(),
                //Tables\Actions\DeleteAction::make(),
                
                // Tables\Actions\EditAction::make('dokumen')
                // ->label('Dokumen Pemeriksaan')
                // ->color('warning')
                // ->icon('heroicon-o-check-circle')
                // ->form([
                //     Forms\Components\FileUpload::make('dokumen_pengajuan')
                // ->label('Dokumen Pemeriksaan')
                // ->enableDownload()
                // ->enableOpen()
                // ->disk('local')
                // ->directory('dokumen_pengajuan3')
                // ->visibility('public')
                // ->acceptedFileTypes(['application/pdf']),
                // Forms\Components\Textarea::make('keterangan_dokumen')
                // ->columnSpan('full'),
                // ]),
            Tables\Actions\Action::make('pemeriksaan')
                ->label('Hasil Pemeriksaan Pertanaman')
                ->url(function($record){ return route('filament.resources.laporan-benih-p-t-ms.edit',[$record]);})
                ->visible(function ($record){
                    if(!isset($record->status) )
                    {return false;}
                    else
                    {return true;}
                }),
            Tables\Actions\Action::make('label')
                ->label('Penentuan Label')
                ->url(function($record){ return route('filament.resources.penentuan-labels.edit',[$record]);})->visible(function ($record){
                    if(!isset($record->status) )
                    {return false;}
                    else
                    {return true;}
                }),
            ])
            ->defaultSort('id', 'desc')
            ->bulkActions([
                //Tables\Actions\DeleteBulkAction::make(),
            ]);
    }   
}
