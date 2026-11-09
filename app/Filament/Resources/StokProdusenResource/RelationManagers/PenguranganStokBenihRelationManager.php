<?php

namespace App\Filament\Resources\StokProdusenResource\RelationManagers;

use App\Models\LaporanTargetBenih;
use App\Models\PenguranganStokBenih;
use App\Models\StokProdusen;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use DB;


class PenguranganStokBenihRelationManager extends RelationManager
{
    protected static string $relationship = 'PenguranganStokBenih';

    protected static ?string $recordTitleAttribute = 'target_benih_id';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('target_benih_id')
                ->default(fn ($livewire) => $livewire->ownerRecord->getKey())
                ->reactive(),
                
                Forms\Components\DatePicker::make('tanggal_lapor')
                    ->label('Tanggal Lapor')
                    ->required(),
                    
                Forms\Components\TextInput::make('jumlah')
                    ->label('Jumlah Terdampak')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Card::make()
                    ->schema([
                Forms\Components\Textarea::make('keterangan')
                        ->label('Penyebab')
                        ->required()
                        ->maxLength(255),
                Forms\Components\Textarea::make('solusi')
                        ->label('Alternatif Solusi')
                        ->required()
                        ->maxLength(255),
                Forms\Components\FileUpload::make('upload_foto')
                    ->label('Upload bukti')
                    ->enableDownload()
                        ->enableOpen()
                    ->required(),
                ])->columns('1'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tanggal_lapor')
                ->label('Tanggal Lapor'),
                Tables\Columns\TextColumn::make('jumlah')
                ->label('Jumlah Terdampak'),
                Tables\Columns\TextColumn::make('keterangan')
                ->label('Penyebab'),
                Tables\Columns\TextColumn::make('solusi')
                ->label('Alternatif Solusi'),
                Tables\Columns\ImageColumn::make('upload_foto')
                ->label('Upload bukti'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                ->visible(
                        function ($record){
                        if(auth()->user()->hasRole("Lembaga Sertifikasi Benih")){
                            return false;
                            }else{
                            return true;
                            }
                        })
                ->after(
                    function (RelationManager $livewire,$record) {
                    $id = $livewire->ownerRecord->getKey();
                    $stok = StokProdusen::where('id',$id)->first();
                        $pengurangan = PenguranganStokBenih::where('id', $record->id)->first();
                        $jumlahstok = DB::table('lap_pengurangan_stok')
                        ->join('target_benih','target_benih.id','=','lap_pengurangan_stok.target_benih_id')
                        ->where('lap_pengurangan_stok.target_benih_id',$stok->id)
                        ->sum('lap_pengurangan_stok.jumlah');

                        return  DB::table('target_benih')->where('id',$pengurangan->target_benih_id)->update([
                            'jum_s_mati' => $jumlahstok,
                        ]);
                }
            ),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->after(
                    function (RelationManager $livewire,$record) {
                    $id = $livewire->ownerRecord->getKey();
                    $stok = StokProdusen::where('id',$id)->first();
                        $pengurangan = PenguranganStokBenih::where('id', $record->id)->first();
                        $jumlahstok = DB::table('lap_pengurangan_stok')
                        ->join('target_benih','target_benih.id','=','lap_pengurangan_stok.target_benih_id')
                        ->where('lap_pengurangan_stok.target_benih_id',$stok->id)
                        ->sum('lap_pengurangan_stok.jumlah');

                        return  DB::table('target_benih')->where('id',$pengurangan->target_benih_id)->update([
                            'jum_s_mati' => $jumlahstok,
                        ]);
                }
            ),
                Tables\Actions\DeleteAction::make()
                ->before(function (RelationManager $livewire, $record) {
                    $id = $livewire->ownerRecord->getKey();
                    $stok = StokProdusen::where('id',$id)->first();
                    $pengurangan = PenguranganStokBenih::where('id', $record->id)->first();
                    $jumkurang = $stok->jum_s_mati;
                    $jumsem = $pengurangan->jumlah;
                    $totalsisa = $jumkurang-$jumsem;
                    return  DB::table('target_benih')->where('id',$pengurangan->target_benih_id)->update([
                        'jum_s_mati' => $totalsisa,
                    ]);
                }),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }    
}
