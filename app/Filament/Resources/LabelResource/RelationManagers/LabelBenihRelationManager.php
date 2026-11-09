<?php

namespace App\Filament\Resources\LabelResource\RelationManagers;

use App\Models\Komoditas;
use App\Models\Label;
use App\Models\LaporanBenihPTM;
use App\Models\LaporanSertifikasiBenih;
use App\Models\LaporanTargetBenih;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Satuan;
use Closure;
use App\Models\SertifikasiBenih;
use App\Models\TargetBenih;
use App\Models\Varietas;
use DB;
use Livewire\Component as LivewireComponent;

class LabelBenihRelationManager extends RelationManager
{
    protected static string $relationship = 'label';
    protected static ?string $title = 'Label Benih';
    protected static ?string $recordTitleAttribute = 'lap_sertifikasi_benih_id';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('lap_sertifikasi_benih_id')
                    ->default(fn ($livewire) => $livewire->ownerRecord->getKey())
                    ->reactive(),
                Forms\Components\TextInput::make('lot')
                    ->label('No. Kelompok Benih')
                    ->required(),
                    Forms\Components\Select::make('varietas_id')
                        ->label('Varietas Batang Bawah')
                        ->options(Varietas::whereHas('komoditas', function($q) {
                            $q->where('jenis_label_id', '1');
                        })->pluck('nama_varietas','id')->toArray())
                        ->reactive()
                        ->required(function ($livewire){
                            $sertifikasiid = $livewire->ownerRecord->getKey();
                            $serid = LaporanSertifikasiBenih::where('id',$sertifikasiid)->first();
                            $panenid = $serid->lap_benih_panen_id;
                            $targetid = LaporanBenihPTM::where('id',$panenid)->first();
                            $target = LaporanTargetBenih::where('id',$targetid->target_benih_id)->first();
                            $komoditas = Komoditas::where('id', $target->komoditas_id)->first();
                            $jenislabel = $komoditas->jenis_label_id;
                            if($jenislabel==1){
                                return true;
                            }else{
                                return false;
                            }
                        })
                        ->hidden(function ($livewire){
                            $sertifikasiid = $livewire->ownerRecord->getKey();
                            $serid = LaporanSertifikasiBenih::where('id',$sertifikasiid)->first();
                            $panenid = $serid->lap_benih_panen_id;
                            $targetid = LaporanBenihPTM::where('id',$panenid)->first();
                            $target = LaporanTargetBenih::where('id',$targetid->target_benih_id)->first();
                            $komoditas = Komoditas::where('id', $target->komoditas_id)->first();
                            $jenislabel = $komoditas->jenis_label_id;
                            if( $jenislabel!=1 ){
                                return true;
                            }else{
                                return false;
                            }
                        }),
                Forms\Components\TextInput::make('terima_label')
                    ->label('Benih Yang Diterima')
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function (Closure $set, $state,$get) {
                        if($get('satuan_label')>0){
                        $set('jumlah_label',$state/$get('satuan_label'));
                        }
                    })
                    ->numeric(),
                Forms\Components\Select::make('satuan_id')
                    ->label('Satuan Benih')
                    ->options(Satuan::all()->pluck('nama_satuan','id')->toArray())
                    ->reactive()
                    ->required(),
                Forms\Components\TextInput::make('satuan_label')
                    ->label('Jumlah Benih Per Satu Label')
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function (Closure $set, $state,$get) {
                        if($get('terima_label')>0){
                        $set('jumlah_label',$get('terima_label')/$state);
                        }
                    })
                    ->numeric(),
                Forms\Components\TextInput::make('jumlah_label')
                ->label('Jumlah Label')
                ->disabled()
                ->required()
                ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('lot')
                    ->label('No. Kelompok Benih'),
                Tables\Columns\TextColumn::make('terima_label')
                    ->label('Benih Yang Diterima'),
                Tables\Columns\TextColumn::make('satuan.nama_satuan')
                    ->label('Satuan Benih'),
                Tables\Columns\TextColumn::make('satuan_label')
                    ->label('Jumlah Benih Per Satu Label'),
                Tables\Columns\TextColumn::make('jumlah_label')
                    ->label('Jumlah Label'),
                    
                Tables\Columns\TextColumn::make('status_cetak')
                ->label('Status Cetak Label')
                ->enum([
                    '1' => 'Sudah Cetak Label',
                ]),
                Tables\Columns\TextColumn::make('status_labeling')
                    ->label('Status Label')
                    ->enum([
                        '1' => 'Sudah Labeling',
                    ]),
                    Tables\Columns\TextColumn::make('tes')
                    ->label('Tercetak Oleh')
                    ->getStateUsing(function($record) {
                        $tes1 = auth()->user()->name;
                         return $tes1;
                     }),
                Tables\Columns\TextColumn::make('tanggal_cetak')
                    ->label('Tanggal Cetak Label')
                    ->date(),
                    Tables\Columns\TextColumn::make('tes2')
                    ->label('Disematkan Label Oleh')
                    ->getStateUsing(function($record) {
                        $tes2 = auth()->user()->name;
                         return $tes2;
                     }),
                Tables\Columns\TextColumn::make('tanggal_labeling')
                    ->label('Tanggal Labeling')
                    ->date(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                ->hidden(
                    function(){
                        if(auth()->user()->hasRole("Pelapor") or auth()->user()->hasRole("Produsen Benih")){
                            return true;
                        }else{
                            return false;
                        }
                    }
                    ),
                Tables\Actions\Action::make('Kembali')
                ->label('Kembali')
                ->url(
                    function($livewire)
                    { 
                        return route('filament.resources.penentuan-labels.edit',[$livewire->ownerRecord->lap_benih_panen_id]);
                    }),
                    
            ])
            ->actions([
                Tables\Actions\EditAction::make()->hidden(
                    function(){
                        if(auth()->user()->hasRole("Pelapor") or auth()->user()->hasRole("Produsen Benih")){
                            return true;
                        }else{
                            return false;
                        }
                    }
                    ),
                Tables\Actions\DeleteAction::make()->hidden(
                    function(){
                        if(auth()->user()->hasRole("Pelapor") or auth()->user()->hasRole("Produsen Benih")){
                            return true;
                        }else{
                            return false;
                        }
                    }
                    ),
                // Tables\Actions\Action::make('LabelBenih')
                //     ->label('Cetak Label')
                //     ->action(
                //         function (RelationManager $livewire,$record) {
                //         $url = route('labels', $record);
                //         $id = $livewire->ownerRecord->getKey();
                //         $rp = LaporanSertifikasiBenih::where('id',$id)->orderBy('tgl_periksa_akhir','DESC')->first();
                //         $rr = LaporanBenihPTM::where('id',$rp->lap_benih_panen_id)->first();
                //         $jumlahbenih = DB::table('label')
                //         ->join('lap_sertifikasi_benih','lap_sertifikasi_benih.id','=','label.lap_sertifikasi_benih_id')
                //         ->join('lap_benih_panen','lap_benih_panen.id','=','lap_sertifikasi_benih.lap_benih_panen_id')
                //         ->where('lap_benih_panen.target_benih_id',$rr->target_benih_id)
                //         ->sum('label.terima_label');
                //         $rd = LaporanTargetBenih::where('id',$rr->target_benih_id)->first();
                //         $datetime = date("Y-m-d");
                //         $user = auth()->user()->id;
                //         return [
                //             DB::table('target_benih')->where('id',$rr->target_benih_id)->update([
                //                 'tanggal_r_salur' => $rp->tgl_periksa_akhir,
                //                 'jum_s_benih' => $jumlahbenih,
                //             ]),
                //             DB::table('label')->where('id',$record->id)->update([
                //                 'status_cetak' => 1,
                //                 'status_labeling' => 1,
                //                 'status' => 1,
                //                 'tanggal_cetak' => $datetime,
                //                 'tanggal_labeling' => $datetime,
                //                 'cms_users_id' => $user,
                //                 'cms_users2_id' => $user,
                //             ]),
                //             redirect()->intended($url),
                //         ];
                        
                       
                //     }
                // ),
                // Tables\Actions\Action::make('Qr')
                //     ->label('Cetak QR')
                //     ->action(
                //         function (RelationManager $livewire,$record) {
                //         $url = route('qrlabels', $record);
                //         $id = $livewire->ownerRecord->getKey();
                //         $rp = LaporanSertifikasiBenih::where('id',$id)->orderBy('tgl_periksa_akhir','DESC')->first();
                //         $rr = LaporanBenihPTM::where('id',$rp->lap_benih_panen_id)->first();
                //         $jumlahbenih = DB::table('label')
                //         ->join('lap_sertifikasi_benih','lap_sertifikasi_benih.id','=','label.lap_sertifikasi_benih_id')
                //         ->join('lap_benih_panen','lap_benih_panen.id','=','lap_sertifikasi_benih.lap_benih_panen_id')
                //         ->where('lap_benih_panen.target_benih_id',$rr->target_benih_id)
                //         ->sum('label.terima_label');
                //         $rd = LaporanTargetBenih::where('id',$rr->target_benih_id)->first();
                //         $datetime = date("Y-m-d");
                //         $user = auth()->user()->id;
                //         return [
                //             DB::table('target_benih')->where('id',$rr->target_benih_id)->update([
                //                 'tanggal_r_salur' => $rp->tgl_periksa_akhir,
                //                 'jum_s_benih' => $jumlahbenih,
                //             ]),
                //             DB::table('label')->where('id',$record->id)->update([
                //                 'status_cetak' => 1,
                //                 'status_labeling' => 1,
                //                 'status' => 1,
                //                 'tanggal_cetak' => $datetime,
                //                 'tanggal_labeling' => $datetime,
                //                 'cms_users_id' => $user,
                //                 'cms_users2_id' => $user,
                //             ]),
                //             redirect()->intended($url),
                //         ];
                        
                       
                //     }
                // ),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }    
}
