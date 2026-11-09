<?php

namespace App\Filament\Resources\PemeriksaanPertanamanResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Satuan;
use DB;

class PemeriksaanpertanamanRelationManager extends RelationManager
{
    protected static string $relationship = 'pemeriksaanpertanaman';
    protected static ?string $title = 'Pemeriksaan Pertanaman';
    protected static ?string $recordTitleAttribute = 'tanggal_lapor';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('lap_benih_panen_id')
                ->default(fn ($livewire) => $livewire->ownerRecord->getKey())
                ->reactive(),
                Forms\Components\Card::make()
                    ->schema([
                Forms\Components\DatePicker::make('tanggal_lapor')
                    ->label('Tanggal Periksa')
                    ->required(),
                    ])->columns('1'),
                    
                Forms\Components\Card::make()
                ->schema([
                    Forms\Components\TextInput::make('jumlah_lanjut')
                    ->label('Jumlah Benih yang dapat disalurkan')
                    ->required()
                    ->maxLength(255),
                    Forms\Components\TextInput::make('jumlah_tunda')
                    ->label('Jumlah Benih yang dapat dilakukan sertifikasi ulang')
                    ->required()
                    ->maxLength(255),
                    Forms\Components\TextInput::make('jumlah_gagal')
                    ->label('Jumlah Benih yang tidak dapat dilanjutkan Sertifikasi')
                    ->required()
                    ->maxLength(255), 
                    ])->columns('3'),
                    
                Forms\Components\Card::make()
                ->schema([
                Forms\Components\Select::make('satuan_id')
                ->label('Satuan Benih')
                ->options(Satuan::all()->pluck('nama_satuan','id')->toArray())
                ->reactive()
                ->required(),
                    Forms\Components\FileUpload::make('upload')
                    ->enableDownload()
                    ->enableOpen()
                    ->label('Upload Laporan Pemeriksaan Tanaman'),

                ])->columns('2'),
                Forms\Components\Card::make()
                ->schema([
                    Forms\Components\Textarea::make('keterangan')
                    ->label('Keterangan')
                ])->columns('1'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            Tables\Columns\TextColumn::make('tanggal_lapor')
            ->label('Tanggal Periksa'),
            Tables\Columns\TextColumn::make('jumlah_lanjut')
            ->label('Jumlah Benih yang dapat disalurkan'),
            Tables\Columns\TextColumn::make('jumlah_gagal')
            ->label('Jumlah Benih yang tidak dapat dilanjutkan Sertifikasi'),
            Tables\Columns\TextColumn::make('jumlah_tunda')
            ->label('Jumlah Benih yang dapat dilakukan sertifikasi ulang'),
            Tables\Columns\TextColumn::make('upload')
            ->label('Upload Laporan Pemeriksaan Tanaman'),
            Tables\Columns\TextColumn::make('keterangan')->label('Keterangan'),
        ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                ->after(
                    function (RelationManager $livewire) {
                        $id = $livewire->ownerRecord->getKey();
                        return DB::table('lap_benih_panen')->where('id',$id)->update(['status' => 1]);
                    }
                ),
                Tables\Actions\Action::make('Kembali')
                ->label('Kembali')
                ->url(
                    function($livewire)
                    { 

                        return route('filament.resources.sertifikasi-benihs.edit',[$livewire->ownerRecord->target_benih_id]);
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }    
}
