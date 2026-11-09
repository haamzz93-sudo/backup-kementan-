<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DataVarietasResource\Pages;
use App\Filament\Resources\DataVarietasResource\RelationManagers;
use App\Models\DataVarietas;
use App\Models\KelKomoditas;
use App\Models\Komoditas;
use App\Models\Pemohon;
use App\Models\Varietas;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Filters\Layout;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DataVarietasResource extends Resource
{
    protected static ?string $model = DataVarietas::class;

    protected static ?string $navigationIcon = 'heroicon-o-database';
    protected static ?string $navigationGroup = 'Database Varietas';
    protected static ?int $navigationSort = 13;
    protected static ?string $navigationLabel = 'Data Varietas';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('produsen_id')
                    ->label('Nama Pemohon')
                    ->options(Pemohon::all()->pluck('nama_produsen','id')->toArray())
                    ->reactive()
                    ->required(),
                Forms\Components\Select::make('komkel_id')
                    ->label('Kelompok Komoditas')
                    ->options(KelKomoditas::all()->pluck('nama_kelompok','id')->toArray())
                    ->reactive()
                    ->required(),
                Forms\Components\Select::make('komoditas_id')
                    ->label('Komoditas')
                    ->options(function(callable $get){
                        $komkel = KelKomoditas::find($get('komkel_id'));
                        if(!$komkel){
                            return null;
                        }
                        return $komkel->komoditas->pluck('nama','id');
                    })
                    ->required(),
                    Forms\Components\TextInput::make('nama_varietas')
                    ->label('Varietas')
                    ->required(),
                    Forms\Components\TextInput::make('kode')
                    ->label('Kode Varietas'),
                    Forms\Components\TextInput::make('tahun_daftar')
                    ->label('Tahun Pendaftaran')
                    ->numeric()
                    ->required(),
                    
                    Forms\Components\TextInput::make('no_sk')
                    ->label('No. SK')
                    ->required(),
                    Forms\Components\Card::make()
                    ->schema([
                    Forms\Components\CheckboxList::make('wil_adaptasi')
                    ->label('Wilayah Adaptasi')
                    ->options([
                        '1' => 'Dataran Rendah',
                        '2' => 'Dataran Menengah',
                        '3' => 'Dataran Tinggi',
                    ]),
                    Forms\Components\CheckboxList::make('iklim')
                    ->label('Jenis Musim')
                    ->options([
                        '1' => 'Musim Hujan',
                        '2' => 'Musim Kemarau',
                    ]),
                    Forms\Components\Select::make('asal')
                    ->label('Asal Varietas')
                    ->options([
                        '1' => 'Introduksi',
                        '2' => 'Dalam Negeri',
                    ])->required(),
                    ])->columns(3),
                    Forms\Components\Card::make()
                    ->schema([
                    Forms\Components\FileUpload::make('upload_produk')
                    ->enableDownload()
                    ->enableOpen()
                    ->label('Upload Produk')
                    ->acceptedFileTypes(['image/jpeg']),
                    Forms\Components\FileUpload::make('upload_penciri')
                    ->enableDownload()
                    ->label('Upload Penciri')
                    ->enableOpen()
                    ->acceptedFileTypes(['image/jpeg']),
                    Forms\Components\FileUpload::make('upload_deskripsi')
                    ->enableDownload()                    
                    ->enableOpen()
                    ->label('Upload Deskripsi')
                    ->acceptedFileTypes(['application/pdf'])
                    ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kode')
               ->label('Kode Varietas'),
               Tables\Columns\TextColumn::make('pemohon.nama_produsen')
              ->label('Nama Produsen'),
           Tables\Columns\TextColumn::make('no_sk')->label('No. SK'),
           Tables\Columns\TextColumn::make('kelkomoditas.nama_kelompok')
               ->label('Kelompok Komoditas')
               ->searchable(),
           Tables\Columns\TextColumn::make('komoditas.nama')
               ->label('Komoditas')
               ->searchable(),
           Tables\Columns\TextColumn::make('nama_varietas')
               ->label('Nama Varietas')
               ->searchable(),
           Tables\Columns\TextColumn::make('pemohon.nama_produsen')
               ->label('Nama Pemohon')
               ->searchable(),
           Tables\Columns\TextColumn::make('tahun_daftar')
               ->label('Tahun Daftar')
               ->searchable(),
           Tables\Columns\TextColumn::make('upload_produk')
               ->label('Produk')
               ->url(function ($record) {
                   return url('/storage') . "/" . $record->upload_produk;
               })
               ->getStateUsing(function () {
                   return "Klik Disini";
               }),
           Tables\Columns\TextColumn::make('upload_penciri')
               ->label('Penciri')
               ->url(function ($record) {
                   return url('/storage') . "/" . $record->upload_penciri;
               })
               ->getStateUsing(function () {
                   return "Klik Disini";
               }),
           Tables\Columns\TextColumn::make('upload_deskripsi')
               ->label('Deskripsi')
               ->url(function ($record) {
                   return url('/storage') . "/" . $record->upload_deskripsi;
               })
               ->getStateUsing(function () {
                   return "Klik Disini";
               }),
           Tables\Columns\TextColumn::make('wil_adaptasi')
               ->label('WIlayah Adaptasi')
               ->getStateUsing(function ($record) {
                   $tes = $record->wil_adaptasi;
                   if ($tes) {
                       foreach ($tes as $data) {
                           if ($data == "1") {
                               $dd[] = "Dataran Rendah";
                           } elseif ($data == "2") {
                               $dd[] = "Dataran Menengah";
                           } elseif ($data == "3") {
                               $dd[] = "Dataran Tinggi";
                           }
                       }
                       return $dd;
                   } else {
                       return "Belum Diisi";
                   }
               }),
           Tables\Columns\TextColumn::make('iklim')
               ->label('Iklim')
               ->getStateUsing(function ($record) {
                   $iklim = $record->iklim;
                   if ($iklim) {
                       foreach ($iklim as $ik) {
                           if ($ik == "1") {
                               $k[] = "Musim Hujan";
                           } elseif ($ik == "2") {
                               $k[] = "Musim Kemarau";
                           }
                       }
                       return $k;
                   } else {
                       return "Belum Diisi";
                   }
               }),
           Tables\Columns\TextColumn::make('asal')
               ->label('Asal')
               ->enum([
                   '' => 'Belum Diisi',
                   '1' => 'Introduksi',
                   '2' => 'Dalam Negeri',
               ])
            ])
            ->filters([
                SelectFilter::make('komkel_id')
                ->label('Kelompok Komoditas')
				->searchable()
                ->options(function () {
                    return KelKomoditas::all()->pluck('nama_kelompok', 'id')->toArray();
                }), // Set the selected value
            SelectFilter::make('komoditas_id')
                ->label('Komoditas')
				->searchable()
                ->options(function () {
                    return Komoditas::all()->pluck('nama', 'id')->toArray();
                }), // Set the selected value
            SelectFilter::make('tahun_daftar')
                ->label('Tahun Daftar')
				->searchable()
                ->options(function () {
                    return DataVarietas::groupBy('tahun_daftar')->pluck('tahun_daftar', 'tahun_daftar')->toArray();
                }), // Set the selected value
            SelectFilter::make('wil_adaptasi')
                ->label('Wilayah Adaptasi')
				->searchable()
                ->options(function () {
                    return ['["1"]' => 'Dataran Rendah', '["2"]' => 'Dataran Menengah', '["3"]' => 'Dataran Tinggi'];
                }), // Set the selected value
            SelectFilter::make('iklim')
                ->label('Iklim')
				->searchable()
                ->options(function () {
                    return ['["1"]' => 'Musim Hujan', '["2"]' => 'Musim Kemarau'];
                }), // Set the selected value
            SelectFilter::make('asal')
                ->label('Asal')
				->searchable()
                ->options(function () {
                    return ['1' => 'Introduksi', '2' => 'Dalam Negeri'];
                }), // Set the selected value
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
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDataVarietas::route('/'),
            'create' => Pages\CreateDataVarietas::route('/create'),
            'edit' => Pages\EditDataVarietas::route('/{record}/edit'),
        ];
    }    
	public static function canViewAny(): bool
{
    $user = auth()->user();

    // Role yang tidak boleh melihat
    if ($user && $user->hasAnyRole(['Pelapor', 'Lembaga Sertifikasi Benih', 'Produsen Benih'])) {
        return false;
    }

    return true;
}

public static function canView($record): bool
{
    $user = auth()->user();

    if ($user && $user->hasAnyRole(['Pelapor', 'Lembaga Sertifikasi Benih', 'Produsen Benih'])) {
        return false;
    }

    return true;
}

public static function canCreate(): bool
{
    $user = auth()->user();

    if ($user && $user->hasAnyRole(['Pelapor', 'Lembaga Sertifikasi Benih', 'Produsen Benih'])) {
        return false;
    }

    return true;
}

public static function canEdit($record): bool
{
    $user = auth()->user();

    if ($user && $user->hasAnyRole(['Pelapor', 'Lembaga Sertifikasi Benih', 'Produsen Benih'])) {
        return false;
    }

    return true;
}

public static function canDelete($record): bool
{
    $user = auth()->user();

    if ($user && $user->hasAnyRole(['Pelapor', 'Lembaga Sertifikasi Benih', 'Produsen Benih'])) {
        return false;
    }

    return true;
}

}
