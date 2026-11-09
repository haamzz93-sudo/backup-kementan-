<?php

namespace App\Filament\Resources\ProduksiBenihResource\RelationManagers;
use DB;
use App\Filament\Resources\DokumenPemeriksaanAPBNResource;
use App\Models\LaporanBenihPTM;
use App\Models\ProsesPerbanyakanBenih;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LaporanBenihPTMRelationManager extends RelationManager
{
    protected static string $relationship = 'LaporanBenihPTM';

    protected static ?string $recordTitleAttribute = 'target_benih_id';

    protected static ?string $title = 'Permohonan Pemeriksaan Siap Salur';
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
                    ->enableOpen()
                ->label('Upload Foto')
                ->required(),
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
                Tables\Columns\ImageColumn::make('upload')
                ->label('Upload Foto')
                ->size(40),
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
                Tables\Actions\CreateAction::make(),
                Tables\Actions\Action::make('dokumen1a')
                ->label("Lihat Dokumen Pemeriksaan Siap Salur/Di Gudang")
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
                Tables\Actions\Action::make('label')
                ->label('Penentuan Label')
                ->url(function($record){ return route('filament.resources.penentuan-labels.edit',[$record]);})
                ->visible(function ($record){
                    if($record->status=="1" )
                    {return true;}
                    else
                    {return false;}
                }),
                Tables\Actions\EditAction::make()->after(
                    function (RelationManager $livewire) {
                        $idtarget = $livewire->ownerRecord->getKey();
                        $tanggalpanen = LaporanBenihPTM::select('tanggal_panen')->where('target_benih_id',$idtarget)->orderBy('tanggal_panen', 'ASC')->first();
                        $tglnya = $tanggalpanen->tanggal_panen;
                        return DB::table('target_benih')->where('id',$idtarget)->update(['tanggal_r_panen' => $tglnya]);
                    }
                )->visible(function ($record){
                    if($record->status=="0" or $record->status=="1" )
                    {return false;}
                    else
                    {return true;}
                }),
                Tables\Actions\DeleteAction::make()->visible(function ($record){
                    if($record->status=="0" or $record->status=="1" )
                    {return false;}
                    else
                    {return true;}
                }),
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
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }    
}
