<?php

namespace App\Filament\Resources\ProdusenBenihResource\RelationManagers;

use App\Models\KelKomoditas;
use App\Models\ProdusenBenih;
use App\Models\JenisProdusen;
use App\Models\Komoditas;
use App\Models\Varietas;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SertifikatKompetensiRelationManager extends RelationManager
{
    protected static string $relationship = 'SertifikatKompetensi';

    protected static ?string $recordTitleAttribute = 'lembaga_id';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                
                Forms\Components\Hidden::make('lembaga_id')
                    ->default(fn ($livewire) => $livewire->ownerRecord->getKey())
                    ->reactive(),
                Forms\Components\CheckboxList::make('komkel_id')
                    ->options(KelKomoditas::all()->pluck('nama_kelompok','id')->toArray())
                    ->label('Kelompok Komoditas')
                    ->required(),
                Forms\Components\CheckboxList::make('jenis_kompetensi')
                ->label('Jenis Kompetensi')
                ->options([
                    'produsen' => 'Produsen',
                    'pengedar' => 'Pengedar',
                ])
                ->required(),
                Forms\Components\TextInput::make('no_serti')
                    ->label('No. Sertifikat')
                    ->required(),
                Forms\Components\FileUpload::make('upload')
                    ->enableDownload()
                    ->enableOpen()
                    ->required(),
                Forms\Components\DatePicker::make('tgl_awal')
                    ->label('Tanggal Penetapan Sertifikat')
                    ->required(),
                Forms\Components\DatePicker::make('tgl_akhir')
                    ->label('Tanggal Berakhir Sertifikat')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('no_serti')->label('No. Sertifikat'),
                Tables\Columns\TextColumn::make('produsenbenih.nama_lembaga')->label('Produsen Benih'),
				Tables\Columns\TextColumn::make('tgl_awal')
                ->label('Tanggal Penetapan Sertifikat'),
                Tables\Columns\TextColumn::make('tgl_akhir')
                ->label('Tanggal Berakhir Sertifikat '),
                Tables\Columns\TextColumn::make('tgl_awal1')
                ->label('Tanggal Perpanjangan Sertifikat')
                ->getStateUsing(function($record) {
                    $panjang =  $record->perpanjangansmm->where('child_smm_id',$record->id)->sortByDesc('tgl_perpanjangan')->first();
                    if($panjang){
                    $tglawalp = $panjang->tgl_perpanjangan;
                    
                        return $tglawalp;
                    }else{
                        return "Belum Ada Perpanjangan";
                    }
                }),
                Tables\Columns\TextColumn::make('tgl_akhir1')
                ->label('Tanggal Berakhir Perpanjangan Sertifikat ')
                ->getStateUsing(function($record) {
                    $panjang =  $record->perpanjangansmm->where('child_smm_id',$record->id)->sortByDesc('tgl_perpanjangan')->first();
                    if($panjang){
                    $tglakhirp = $panjang->tgl_berlaku;
                    
                        return $tglakhirp;
                    }else{
                         return "Belum Ada Perpanjangan";
                    }
                }),
                Tables\Columns\TextColumn::make('periksa')
                ->label('Jumlah Perpanjang Sertifikat Kompetensi')
                ->getStateUsing(function($record) {
                    $jumlahpanjang = $record->perpanjangansmm->where('child_smm_id',$record->id)->count();
                return $jumlahpanjang;
            }),
            Tables\Columns\BadgeColumn::make('statuz')
                ->label('Status')
                ->getStateUsing(function($record) {
                    $now = date("Y-m-d");
                    $tgl_akhir = $record->tgl_akhir;
                    $panjang =  $record->perpanjangansmm->where('child_smm_id',$record->id)->sortByDesc('tgl_perpanjangan')->first();
                    if($panjang){
                    $tglakhirp = $panjang->tgl_berlaku;
                    if($now>$tglakhirp){
                        return "Tidak Berlaku";
                    }else{
                        return "Berlaku";
                    }
                    }else{
                        if($now>$tgl_akhir){
                            return "Tidak Berlaku" ;
                        }else{
                            return "Berlaku";
                        }
                    }
                })
                ->colors([
                    'success' => 'Berlaku',
                    'danger' => 'Tidak Berlaku',
                ]),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
            Tables\Actions\Action::make('perpanjang')
            ->label('Perpanjang Masa Berlaku')
            ->url(function($record){ return route('filament.resources.sertifikat-kompetensis.edit',[$record]);}),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }    
}
