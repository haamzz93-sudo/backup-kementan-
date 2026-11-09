<?php

namespace App\Filament\Resources\PenentuanLabelResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use App\Models\LaporanBenihPTM;
use App\Models\LaporanTargetBenih;
use App\Models\ProdusenBenih;
use App\Models\Komoditas;
use App\Models\Varietas;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PenentuanlabelRelationManager extends RelationManager
{
    protected static string $relationship = 'penentuanlabel';
    protected static ?string $title = 'Penentuan Label';
    protected static ?string $recordTitleAttribute = 'tanggal_lapor';                  
    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\Hidden::make('lap_benih_panen_id')
                ->default(fn ($livewire) => $livewire->ownerRecord->id)
                ->reactive(),
                Forms\Components\Select::make('no_serti')
                    ->label('No. Induk Sertifikasi')
                        ->options(function($livewire){
                                $cek = LaporanBenihPTM::where('id',$livewire->ownerRecord->id)->first();
                                $json = $cek->produksibenih->no_induk;
                                $pilih = json_decode($json);
                                $opsiR = [];
                                    foreach($pilih as $opR){
                                        $opsiR[$opR->nomor] = $opR->nomor;
                            }
                                return $opsiR;
                        })
                    ->reactive()
                    ->required(),
            Forms\Components\TextInput::make('no_label1')
                ->label('No. Sertifikat')
                ->required(),
            Forms\Components\DatePicker::make('tgl_periksa_akhir')
                ->label('Berlaku Mulai')
                ->hidden(function($livewire){
                    $ptms = LaporanBenihPTM::where('id',$livewire->ownerRecord->id)->first();
                    $komoditas = $ptms->produksibenih->komoditas_id;
                    $countkomodjer = Komoditas::where('id',$komoditas)->first();
                    $word = "Jeruk";
                    if(strpos($countkomodjer->nama, $word) !== false){
                        return false;
                    }else{
                        return true;
                    }
                }),
            Forms\Components\DatePicker::make('tgl_berlaku')
                ->label('Belaku s/d')
                ->hidden(function($livewire){
                    $ptms = LaporanBenihPTM::where('id',$livewire->ownerRecord->id)->first();
                    $komoditas = $ptms->produksibenih->komoditas_id;
                    $countkomodjer = Komoditas::where('id',$komoditas)->first();
                    $word = "Jeruk";
                    if(strpos($countkomodjer->nama, $word) !== false){
                        return false;
                    }else{
                        return true;
                    }
                }),
            Forms\Components\FileUpload::make('upload')
                ->enableDownload()
                ->label('Upload Dokumen Sertifikat')
                ->required()
                ->enableOpen(),

        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            Tables\Columns\TextColumn::make('no_label1')
            ->label('No. Sertifikat'),
            Tables\Columns\TextColumn::make('tgl_periksa_akhir')
            ->label('Berlaku Mulai'),
            Tables\Columns\TextColumn::make('tgl_berlaku')
            ->label('Belaku s/d'),
            Tables\Columns\TextColumn::make('kode')
            ->label('Kode Master Label'),
            Tables\Columns\TextColumn::make('upload')
            ->label('Upload Dokumen Sertifikat'),
        ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                ->after(
                        function (RelationManager $livewire,$record) {
                        $id = $livewire->ownerRecord->getKey();
                        $rp = LaporanBenihPTM::where('id',$id)->first();
                        $target = LaporanTargetBenih::where('id',$rp->target_benih_id)->first();
                        $lembaga = ProdusenBenih::where('id',$target->lembaga_id)->first();
                        $komoditas = Komoditas::where('id',$target->komoditas_id)->first();
                        $varietas = Varietas::where('id',$target->varietas_id)->first();
                        $year = date('Y', strtotime($rp->tanggal_panen));
                        $kodemstr = $lembaga->kode_produsen.'.'.$komoditas->kdkom.'.'.$varietas->id.'.'.$year.'.'.$record->id;
                        return DB::table('lap_sertifikasi_benih')->where('id',$record->id)->update(['kode' => $kodemstr]);
                    }
                )
                ->hidden(
                    function(){
                        if(auth()->user()->hasRole("Pelapor") or auth()->user()->hasRole("Produsen Benih")){
                            return true;
                        }else{
                            return false;
                        }
                    
                    }),
                Tables\Actions\Action::make('Kembali')
                ->label('Kembali')
                ->url(
                    function($livewire)
                    { 

                        return route('filament.resources.sertifikasi-benihs.edit',[$livewire->ownerRecord->target_benih_id]);
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->after(
                    function (RelationManager $livewire,$record) {
                    $id = $livewire->ownerRecord->getKey();
                    $rp = LaporanBenihPTM::where('id',$id)->first();
                    $target = LaporanTargetBenih::where('id',$rp->target_benih_id)->first();
                    $lembaga = ProdusenBenih::where('id',$target->lembaga_id)->first();
                    $komoditas = Komoditas::where('id',$target->komoditas_id)->first();
                    $varietas = Varietas::where('id',$target->varietas_id)->first();
                    $year = date('Y', strtotime($rp->tanggal_panen));
                    $kodemstr = $lembaga->kode_produsen.'.'.$komoditas->kdkom.'.'.$varietas->id.'.'.$year.'.'.$record->id;
                    return DB::table('lap_sertifikasi_benih')->where('id',$record->id)->update(['kode' => $kodemstr]);
                }
            )->hidden(
                    function(){
                        if(auth()->user()->hasRole("Pelapor") or auth()->user()->hasRole("Produsen Benih")){
                            return true;
                        }else{
                            return false;
                        }
                    
                    }),
                Tables\Actions\DeleteAction::make()->hidden(
                    function(){
                        if(auth()->user()->hasRole("Pelapor") or auth()->user()->hasRole("Produsen Benih")){
                            return true;
                        }else{
                            return false;
                        }
                    
                    }),
                // Tables\Actions\Action::make('label')
                // ->label('Label')
                // ->url(function($record){ return route('filament.resources.penentuan-labels.edit',[$record]);}),
                Tables\Actions\Action::make('label')
                ->label('Label Benih')
                ->url(function($record){ return route('filament.resources.laporan-sertifikasi-benihs.edit',[$record]);}),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }    
}
