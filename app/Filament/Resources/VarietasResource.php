<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VarietasResource\Pages;
use App\Filament\Resources\VarietasResource\RelationManagers;
use App\Models\Varietas;
use App\Models\KelKomoditas;
use App\Models\Komoditas;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Layout;
class VarietasResource extends Resource
{
    protected static ?string $model = Varietas::class;

    protected static ?string $navigationIcon = 'heroicon-o-database';
    protected static ?string $navigationGroup = 'Export';
    protected static ?int $navigationSort = 18;
    protected static ?string $navigationLabel = 'Export Database Varietas Terdaftar';

    protected static bool $shouldRegisterNavigation = true;
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('komkel_id')
                    ->maxLength(255),
                Forms\Components\TextInput::make('komoditas_id')
                    ->maxLength(255),
                Forms\Components\TextInput::make('nama_varietas')
                    ->maxLength(255),
                Forms\Components\Textarea::make('kode')
                    ->maxLength(65535),
                Forms\Components\TextInput::make('produsen_id')
                    ->maxLength(255),
                Forms\Components\Textarea::make('no_sk')
                    ->maxLength(16777215),
                Forms\Components\Textarea::make('tahun_daftar')
                    ->maxLength(16777215),
                Forms\Components\Textarea::make('upload_produk')
                    ->maxLength(16777215),
                Forms\Components\Textarea::make('upload_penciri')
                    ->maxLength(16777215),
                Forms\Components\Textarea::make('upload_deskripsi')
                    ->maxLength(16777215),
                Forms\Components\Textarea::make('no_reg')
                    ->maxLength(16777215),
                Forms\Components\Textarea::make('wil_adaptasi'),
                Forms\Components\Textarea::make('iklim'),
                Forms\Components\Textarea::make('asal')
                    ->maxLength(16777215),
                Forms\Components\TextInput::make('varietas_sanggah_id')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                 Tables\Columns\TextColumn::make('kode')
                ->label('Kode Varietas'),
            Tables\Columns\TextColumn::make('no_sk')->label('No. SK'),
            Tables\Columns\TextColumn::make('kelkomoditas.nama_kelompok')
                ->label('Kelompok Komoditas')
                ->searchable(),
            Tables\Columns\TextColumn::make('komoditas.nama')
                ->label('Komoditas'),
            Tables\Columns\TextColumn::make('nama_varietas')
                ->label('Nama Varietas'),
            Tables\Columns\TextColumn::make('pemohon.nama_produsen')
                ->label('Nama Pemohon'),
            Tables\Columns\TextColumn::make('tahun_daftar')
                ->label('Tahun Daftar'),
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
                    return Varietas::groupBy('tahun_daftar')->pluck('tahun_daftar', 'tahun_daftar')->toArray();
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
                //Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                //Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    public static function canEdit(Model $record): bool
    {
        return false;
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVarietas::route('/'),
            'create' => Pages\CreateVarietas::route('/create'),
            'edit' => Pages\EditVarietas::route('/{record}/edit'),
        ];
    }    
}
