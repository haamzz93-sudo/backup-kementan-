<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExportSertifikatKompetensiResource\Pages;
use App\Filament\Resources\ExportSertifikatKompetensiResource\RelationManagers;
use App\Models\ExportSertifikatKompetensi;
use App\Models\Provinces;
use App\Models\ProdusenBenih;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\Model;
use DB;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Layout;
class ExportSertifikatKompetensiResource extends Resource
{
    protected static ?string $model = ExportSertifikatKompetensi::class;

    protected static ?string $navigationIcon = 'heroicon-o-database';
    protected static ?string $navigationGroup = 'Export';
    protected static ?int $navigationSort = 16;
    protected static ?string $navigationLabel = 'Export Database Sertifikat Kompetensi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('lembaga_id')
                    ->maxLength(255),
                Forms\Components\TextInput::make('no_serti')
                    ->maxLength(255),
                Forms\Components\Textarea::make('status')
                    ->maxLength(16777215),
                Forms\Components\Textarea::make('komkel_id'),
                Forms\Components\Textarea::make('komoditas_id')
                    ->maxLength(16777215),
                Forms\Components\Textarea::make('varietas_id')
                    ->maxLength(16777215),
                Forms\Components\Textarea::make('jenis_kompetensi'),
                Forms\Components\Textarea::make('luas_lahan')
                    ->maxLength(16777215),
                Forms\Components\Textarea::make('upload')
                    ->maxLength(16777215),
                Forms\Components\DatePicker::make('tgl_awal'),
                Forms\Components\DatePicker::make('tgl_akhir'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('no_serti')
            ->label('Nomor Sertifikat')
            ->searchable(),
            Tables\Columns\TextColumn::make('produsenbenih.nama_lembaga')->label('Nama Lembaga'),
            Tables\Columns\TextColumn::make('produsenbenih.provinces.name')->label('Provinsi'),
            Tables\Columns\TextColumn::make('produsenbenih.alamat')->label('Alamat'),
            Tables\Columns\TextColumn::make('jenis')
            ->label('Jenis Kompetensi')
            ->getStateUsing(function($record){
                $col = collect($record->jenis_kompetensi);
                $array = $col->toArray();
                $string = implode(', ', $array);
                return $string;
            }),
            Tables\Columns\TextColumn::make('tgl_awal')->label('Tanggal Awal Berlaku Sertifikat'),
            Tables\Columns\TextColumn::make('akhir')
            ->label('Tanggal Berakhir Berlaku Sertifikat')
            ->getStateUsing(function($record){
                $tgl_akhir = $record->tgl_akhir;
                $panjang =  $record->perpanjangansmm->where('child_smm_id',$record->id)->sortByDesc('tgl_perpanjangan')->first();
                if($panjang){
                $tglakhirp = $panjang->tgl_berlaku;
                    return $tglakhirp;
                }else{
                    return $tgl_akhir;
                }
            }),
            Tables\Columns\TextColumn::make('panjang')
            ->label('Banyaknya Perpanjangan Sertifikat')
            ->getStateUsing(function($record){
                if($record->perpanjangansmm->count()>0){
                    return $record->perpanjangansmm->count()." Kali";
                }else{
                    return "Belum Pernah Diperpanjang";
                }
                
            }),
            Tables\Columns\TextColumn::make('stat')
            ->label('Status')
            ->getStateUsing(function($record){
                $now = date("Y-m-d");
                $tgl_akhir = $record->tgl_akhir;
                $panjang =  $record->perpanjangansmm->where('child_smm_id',$record->id)->sortByDesc('tgl_perpanjangan')->first();
                if($panjang){
                $tglakhirp = $panjang->tgl_berlaku;
                    $akhir=$tglakhirp;
                }else{
                    $akhir=$tgl_akhir;
                }
                if($now>$akhir){
                    return "Tidak Berlaku";
                }else{
                    return "Berlaku";
                }
                
            }),
            ])
            ->filters([
                SelectFilter::make('provinces_id')
                ->label('Provinsi')
                ->options(function () {
                    return Provinces::all()->pluck('name', 'id')->toArray();
                })
                ->query(function (Builder $query, array $data) {
                    if (!empty($data['value']))
                    {
                        $query->whereHas(
                            'produsenbenih',fn (Builder $query) => $query->where('provinces_id', '=', (int) $data['value'])
                            );
                    }
                }),
            ],layout: Layout::AboveContent)
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            //
        ];
    }
     public static function getEloquentQuery(): Builder
    {
 if (auth()->user()->hasRole("Lembaga Sertifikasi Benih")){
            return parent::getEloquentQuery()->with('produsenbenih','perpanjangansmm');
        }else{
            return parent::getEloquentQuery()->with('produsenbenih','perpanjangansmm');
        } 
            
        
		
    }
    public static function canEdit(Model $record): bool
    {
        return false;
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListExportSertifikatKompetensis::route('/'),
            'create' => Pages\CreateExportSertifikatKompetensi::route('/create'),
            'edit' => Pages\EditExportSertifikatKompetensi::route('/{record}/edit'),
        ];
    }    
}
