<?php

namespace App\Filament\Resources\TargetBenihResource\RelationManagers;

use App\Models\Golongan;
use DB;
use Closure;
use App\Models\KelasBenih;
use App\Models\ProdusenBenih;
use App\Models\KelKomoditas;
use App\Models\Komoditas;
use App\Models\LokasiProduksiDetail;
use App\Models\LaporanTargetBenih;
use App\Models\TargetSalur;
use App\Models\Cara;
use App\Models\Satuan;
use App\Models\Varietas;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\SelectFilter;
class LaporanTargetBenihRelationManager extends RelationManager
{
    protected static string $relationship = 'LaporanTargetBenih';

    protected static ?string $recordTitleAttribute = 'lembaga_id';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('status')
                ->hidden()
                ->reactive(),
                Forms\Components\Placeholder::make('Keterangan:')
                        ->content(
                            function ($get){
                                if($get('status')=="active"){
                                 return 'Anda tidak dapat merubah data, jika sudah terverifikasi!';   
                                }else{
                                 return 'Silahkan Isi data target!';
                                }
                                
                        })
                        ,
                Forms\Components\Hidden::make('lembaga_id')
                ->default(fn ($livewire) => $livewire->ownerRecord->getKey())
                ->reactive(),
                Forms\Components\Card::make()
                    ->schema([
                Forms\Components\DatePicker::make('tanggal_lapor')
                ->label('Tanggal Penentuan Target')
                     ->disabled(
                            function ($get){
                                if($get('status')=="active"){
                                 return true;   
                                }
                                
                        })
                ->required()
                ->afterStateUpdated(function (Closure $set, $state) {
                    $set('tahun', date('Y', strtotime($state)));
                })
                ->reactive(),
                Forms\Components\Hidden::make('tahun')
                ->label('Tahun Penentuan Target')
                ->required(),
                Forms\Components\TextInput::make('sumber_dana')
                ->default('APBN')
                ->label('Sumber Dana')
                ->disabled()
                ->required(),
                ])->columns(2),
                Forms\Components\Card::make()
                    ->schema([
                Forms\Components\Select::make('lokasi_produksi_detail_id')
                    ->label('Lokasi Produksi')
                    ->disabled(
                            function ($get){
                                if($get('status')=="active"){
                                 return true;   
                                }
                                
                        })
                        ->options(function(callable $get){
                            if(!$get('lembaga_id')){
                                return null;
                            }
                            return LokasiProduksiDetail::where('lembaga_id',$get('lembaga_id'))
                            ->pluck('alamat','id');
                        })
                    ->reactive()
                    ->required(),

                Forms\Components\TextInput::make('luas_tanam')
                    ->label('Luas Tempat Perbanyakan(meter persegi)')
                   ->disabled(
                            function ($get){
                                if($get('status')=="active"){
                                 return true;   
                                }
                                
                        })
                    ->required()
                    ->numeric()
                    ->maxLength(255),
                    ])->columns(2),
                Forms\Components\Card::make()
                    ->schema([
                Forms\Components\Select::make('komkel_id')
                ->label('Kelompok Komoditas')
                   ->disabled(
                            function ($get){
                                if($get('status')=="active"){
                                 return true;   
                                }
                                
                        })
                ->options(KelKomoditas::all()->pluck('nama_kelompok','id')->toArray())
                ->reactive()
                ->required(),
                Forms\Components\Select::make('komoditas_id')
                ->label('Komoditas')
                   ->disabled(
                            function ($get){
                                if($get('status')=="active"){
                                 return true;   
                                }
                                
                        })
                ->options(function(callable $get){
                    $komkel = KelKomoditas::find($get('komkel_id'));
                    if(!$komkel){
                        return null;
                    }
                    return $komkel->komoditas->pluck('nama','id');
                })
                ->reactive()
                ->searchable()
                ->required(),
                Forms\Components\Select::make('varietas_id')
                ->label('Varietas')
                   ->disabled(
                            function ($get){
                                if($get('status')=="active"){
                                 return true;   
                                }
                                
                        })
                ->options(function(callable $get){
                    $komoditas = Komoditas::find($get('komoditas_id'));
                    if(!$komoditas){
                        return null;
                    }
                    return $komoditas->varietas->pluck('nama_varietas','id');
                })
                ->reactive()
                ->searchable()
                ->required(),
                ])->columns(3),
                
                Forms\Components\Card::make()
                    ->schema([
                Forms\Components\Select::make('kelas_benih_id')
                ->label('Kelas Benih')
                   ->disabled(
                            function ($get){
                                if($get('status')=="active"){
                                 return true;   
                                }
                                
                        })
                ->options(KelasBenih::select( DB::raw("kelas_benih AS name"),'id')
                ->where('kel_benih_id', 2)
                ->pluck('name','id')->toArray())
                ->reactive()
                ->required(),
                Forms\Components\Select::make('golongan_id')
                    ->label('Golongan Perbanyakan')
                   ->disabled(
                            function ($get){
                                if($get('status')=="active"){
                                 return true;   
                                }
                                
                        })
                    ->options(Golongan::all()->pluck('gol_banyak','id')->toArray())
                    ->reactive()
                    ->required(),
                    
                Forms\Components\Select::make('cara_id')
                ->label('Metode Perbanyakan')
                   ->disabled(
                            function ($get){
                                if($get('status')=="active"){
                                 return true;   
                                }
                                
                        })
                ->options(function(callable $get){
                    $golongan = Golongan::find($get('golongan_id'));
                    if(!$golongan){
                        return null;
                    }
                    return $golongan->cara->pluck('cara_banyak','id');
                })
                ->reactive()
                ->required(),
                ])->columns(3),
                Forms\Components\Card::make()
                    ->schema([
                Forms\Components\DatePicker::make('tanggal_lapor_tanam')
                ->label('Tanggal Target Perbanyakan Benih')
                   ->disabled(
                            function ($get){
                                if($get('status')=="active"){
                                 return true;   
                                }
                                
                        })
                ->required(),
                Forms\Components\DatePicker::make('tanggal_lapor_panen')
                ->label('Tanggal Target PTM')
                   ->disabled(
                            function ($get){
                                if($get('status')=="active"){
                                 return true;   
                                }
                                
                        })
                ->required(),
                Forms\Components\DatePicker::make('tanggal_lapor_salur')
                ->label('Tanggal Target Siap Salur')
                   ->disabled(
                            function ($get){
                                if($get('status')=="active"){
                                 return true;   
                                }
                                
                        })
                ->required(),
                ])->columns(3),
                Forms\Components\Card::make()
                    ->schema([
                Forms\Components\TextInput::make('jum_target')
                    ->label('Jumlah Target Siap Salur')
                   ->disabled(
                            function ($get){
                                if($get('status')=="active"){
                                 return true;   
                                }
                                
                        })
                    ->required(),

                Forms\Components\Select::make('satuan_id')
                    ->label('Satuan')
                   ->disabled(
                            function ($get){
                                if($get('status')=="active"){
                                 return true;   
                                }
                                
                        })
                    ->options(Satuan::all()->pluck('nama_satuan','id')->toArray())
                    ->reactive()
                    ->required(),
                    
                ])->columns(2),
                Forms\Components\FileUpload::make('upload_ubah')
                    ->label('Upload Dokumen Pengajuan'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\Layout\Split::make([
                    Tables\Columns\Layout\Stack::make([
                        Tables\Columns\TextColumn::make('test0')
                        ->getStateUsing(function($record) {
                            return "Lokasi Produksi : ";
                        }),
                        Tables\Columns\TextColumn::make('lokasiproduksidetail.alamat')
                            ->size('sm')
                            ->color('secondary')
                            ->label('Lokasi Produksi'),
                        Tables\Columns\TextColumn::make('luas_tanam')
                            ->label('Luas Tanam')  
                            ->size('sm')
                            ->color('secondary')
                            ->alignLeft()
                            ->getStateUsing(function($record) {
                                $luas = $record->luas_tanam;
                                    return "Luas Tanam : ".$luas. " m2";
                        }),
                        Tables\Columns\TextColumn::make('kl')
                        ->getStateUsing(function($record) {
                            return "Kelompok Komoditas : ";
                        }),
                        Tables\Columns\TextColumn::make('kelkomoditas.nama_kelompok')
                            ->label('Kelompok Komoditas')
                            ->size('sm')
                            ->color('secondary')
                            ->alignLeft(),
                        Tables\Columns\TextColumn::make('km')
                        ->getStateUsing(function($record) {
                            return "Komoditas : ";
                        }),
                        Tables\Columns\TextColumn::make('komoditas.nama')
                            ->label('Komoditas')
                            ->size('sm')
                            ->color('secondary')
                            ->alignLeft(),
                        Tables\Columns\TextColumn::make('vr')
                            ->getStateUsing(function($record) {
                            return "Varietas : ";
                        }),
                        Tables\Columns\TextColumn::make('varietas.nama_varietas')
                            ->label('Varietas')
                            ->size('sm')
                            ->color('secondary')
                            ->alignLeft(),
                        Tables\Columns\TextColumn::make('kb')
                            ->getStateUsing(function($record) {
                            return "Kelas Benih : ";
                        }),
                        Tables\Columns\TextColumn::make('kelasbenih.kelas_benih')
                            ->label('Kelas Benih')
                            ->size('sm')
                            ->color('secondary')
                            ->alignLeft(),
                        Tables\Columns\TextColumn::make('gl')
                            ->getStateUsing(function($record) {
                                return "Golongan Perbanyakan : ";
                            }),
                        Tables\Columns\TextColumn::make('golongan.gol_banyak')
                            ->label('Golongan Perbanyakan')
                            ->size('sm')
                            ->color('secondary')
                            ->alignLeft(),
                        Tables\Columns\TextColumn::make('mp')
                            ->getStateUsing(function($record) {
                            return "Metode Perbanyakan : ";
                        }),
                        Tables\Columns\TextColumn::make('cara.cara_banyak')
                            ->label('Metode Perbanyakan')
                            ->size('sm')
                            ->color('secondary')
                            ->alignLeft(),
                    ]),
                
                    Tables\Columns\Layout\Stack::make([
                         Tables\Columns\TextColumn::make('tes')
                            ->getStateUsing(function($record) {
                                return "Tahun Target : ";
                        }),
                        Tables\Columns\TextColumn::make('tahun')
                            ->size('sm')
                            ->color('secondary')
                            ->getStateUsing(function($record) {
                                return $record->tahun;
                        })
                        ->sortable()
                        ->searchable(),
                        
                        Tables\Columns\TextColumn::make('tes2')
                            ->getStateUsing(function($record) {
                                return "Sumber Dana : ";
                        }),
                        Tables\Columns\TextColumn::make('sumber_dana')
                            ->size('sm')
                            ->color('secondary')
                            ->enum([
                                'apbn' => 'APBN',
                                'apbd' => 'APBD',
                                'swadaya' => 'Swadaya',
                            ]),
                        Tables\Columns\TextColumn::make('jt')
                            ->getStateUsing(function($record) {
                                return "Jumlah Target : ";
                        }),
                        Tables\Columns\TextColumn::make('jum_target')
                            ->label('Jumlah Target Benih')
                            ->size('sm')
                            ->color('secondary')
                            ->getStateUsing( function ($record){
                                $target = $record->jum_target;
                                $satuan = $record->satuan->nama_satuan;
                                return $target ." ". "$satuan";
                            }),   
                        
                    ]),
                    Tables\Columns\Layout\Stack::make([
                        Tables\Columns\TextColumn::make('verif')
                            ->getStateUsing(function($record) {
                                return "Status Verifikasi: ";
                        }),
                        Tables\Columns\TextColumn::make('status')
                        ->size('sm')
                            ->color('secondary')
                            ->alignLeft()
                        ->enum([
                            '' => 'Belum Terverifikasi',
                            'reactive' => 'Diajukan Ulang',
                            'active' => 'Terverifikasi',
                            'tolak' => 'Ditolak',
                            'selesai' =>'Selesai',
                        ])
                        ->sortable()
                        ->searchable(),
                        Tables\Columns\TextColumn::make('keterangan')
                            ->size('sm')
                            ->color('secondary')
                            ->alignLeft()
                            ->getStateUsing(function($record) {
                                    return "Keterangan : ".$record->keterangan;
                            }),
                            Tables\Columns\TextColumn::make('sl')
                            ->getStateUsing(function($record) {
                                return "Status BPSB : ";
                        }),
                        Tables\Columns\TextColumn::make('mengetahui')
                        ->label('Status BPSB')
                        ->size('sm')
                            ->color('secondary')
                            ->alignLeft()
                        ->enum([
                            '' => 'Belum Diketahui Lembaga Sertifikasi',
                            'mengetahui' => 'Diketahui Lembaga Sertifikasi',
                        ])
                        ->sortable()
                        ->searchable(),
                    ]),
                ]),
                
            ])
            ->filters([
                SelectFilter::make('status')
                ->label('Status')
                ->options([
                    '' => 'Belum Terverifikasi',
                    'reactive' => 'Diajukan Ulang',
                    'active' => 'Terverifikasi',
                    'tolak' => 'Ditolak',
                    'selesai' =>'Selesai',
                ])->multiple(),
                SelectFilter::make('tahun')
                ->label('Tahun Target')
                ->options(
                    function ($livewire){ 
                    return LaporanTargetBenih::groupBy('tahun')
                    ->where('lembaga_id',$livewire->ownerRecord->getKey())
                    ->pluck('tahun','tahun')->toArray();
                    }
                ),
                // SelectFilter::make('provinces_id')
                // ->label('Provinsi')
                // ->options(Provinces::all()->pluck('name','id')->toArray())->multiple(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                
                Tables\Actions\Action::make('salur')
                ->label('Target Penyaluran')
                ->url(function($record){ return route('filament.resources.laporan-target-benihs.edit',[$record]);})
                ->visible(function ($record){
                    if($record->status=="active" )
                    {return true;}
                    else
                    {return true;}
                }),
                Tables\Actions\EditAction::make()
                ->visible(function ($record){
	if(auth()->user()->hasRole("Lembaga Sertifikasi Benih")){
		return false;}
	else{
		if($record->status=="active")
                    {return false;}
                    else
                    {return true;}
		}
                })
                ->mutateFormDataUsing(function (array $data): array {
                    $data['status'] = "reactive";
                    return $data;
                }),
                Tables\Actions\DeleteAction::make()
                ->visible(function ($record){
                    if($record->status=="active")
                    {return false;}
                    else
                    {return true;}
                }),
                Tables\Actions\EditAction::make('verifikasi')
                    ->label('Status Verifikasi')
                    ->visible(
                        function ($record){
                        if(auth()->user()->hasRole("Pelapor") or auth()->user()->hasRole("Produsen Benih") or auth()->user()->hasRole("Lembaga Sertifikasi Benih")){
                            return false;
                            }else{
                                // $htng = TargetSalur::where('target_benih_id',$record->id)->count();
                                // if($htng>0){
                                //     return true;
                                // }else{
                                // }
                                return true;
                            
                            }
                        })
                    ->color('warning')
                    ->icon('heroicon-o-check-circle')
                    ->form([
                    Forms\Components\Select::make('status')
                    ->label('Verifikasi')
                    ->options([
                        'tolak' => 'Ditolak',
                        'active' => 'Terverifikasi',
                    ])
                    ->reactive(),
                    Forms\Components\Textarea::make('keterangan')
                    ->hidden(
                        function ($get){
                        if($get('status')=="active"){
                         return true;   
                        }
                        }
                    )
                    ->columnSpan('full'),
                    ]),
                    Tables\Actions\EditAction::make('mengetahui')
                        ->label('Verifikasi BPSB')
                        ->mountUsing(fn (Forms\ComponentContainer $form,$record) => $form->fill([
                            'mengetahui' => "Diketahui Oleh BPSB",
                            'no_induk' => $record->no_induk,
                        ]))
                        ->color('warning')
			->visible(
                             function (){
                            if(auth()->user()->hasRole("Lembaga Sertifikasi Benih")){
                               return true;
                                 }else{
                                return false;
                                 }
                            })	
                        ->icon('heroicon-o-check-circle')
                        ->form([
                        Forms\Components\Hidden::make('mengetahui')
                        ->label('Verifikasi BPSB')
                        ->default("mengetahui"),
                            Forms\Components\Repeater::make('no_induk')
                            ->label('Proses Sertifikasi')
                            ->required()
                            ->schema([
                            Forms\Components\TextInput::make('nomor')
                            ->label('No. Induk Sertifikasi')
                            ->required(),
                            Forms\Components\TextInput::make('jumlah')
                            ->label('Jumlah Benih Sertifikasi')
                            ->required(),
                            Forms\Components\FileUpload::make('file')
                            ->label('Upload Dokumen Pendukung No. Induk Sertifikasi dan atau Dokumen Permohonan Produsen')
				->enableDownload()
                    		->enableOpen(),
                        ]),
                    ]),
                        
                    
            ])
            ->defaultSort('id', 'desc')
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
           
    }    
}
