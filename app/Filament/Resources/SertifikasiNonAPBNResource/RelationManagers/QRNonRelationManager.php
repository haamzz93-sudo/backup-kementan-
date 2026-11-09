<?php

namespace App\Filament\Resources\SertifikasiNonAPBNResource\RelationManagers;

use App\Models\LaporanProduksiSwadaya;
use App\Models\LaporanSertifikasiNonAPBN;
use App\Models\ProduksiBenihUmum;
use App\Models\SertifikasiBenih;
use App\Models\SertifikasiNonAPBN;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\SertifikatKompetensi;

class QRNonRelationManager extends RelationManager
{
    protected static string $relationship = 'QRNon';
    protected static ?string $title = 'QRCode Label';
    protected static ?string $recordTitleAttribute = 'sertifikasi_non_id';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('sertifikasi_non_id')
                ->default(fn ($livewire) => $livewire->ownerRecord->getKey())
                ->reactive(),
                
                Forms\Components\CheckboxList::make('child_smm')
                ->options(function($livewire){
                    $sert = SertifikasiNonAPBN::where('id', $livewire->ownerRecord->id)->first();
                    $lembaga_non = ProduksiBenihUmum::where('id', $sert->lembaga_id)->first();
                    return SertifikatKompetensi::where('lembaga_id',$lembaga_non->id)->pluck('no_serti','no_serti')->toArray();
                })
                ->label('Nomor Sertifikat / No. LSSM')
                ->required(),
                Forms\Components\TextInput::make('no_batch')
                ->label('No. Lot/ No. Batch')
                ->required(),
                Forms\Components\TextInput::make('jumlah_qr')
                ->label('Jumlah QR Code yang Dicetak')
                ->required()
                ->numeric(),
                Forms\Components\KeyValue::make('data')
                ->keyLabel('Deskripsi')
                ->valueLabel('Value')
                ->keyPlaceholder('Deskripsi')
                ->valuePlaceholder('Value')
                ->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('child_smm')
                ->label('Nomor Sertifikat / No. LSSM'),
                Tables\Columns\TextColumn::make('no_batch')
                ->label('No. Lot/ No. Batch'),
                Tables\Columns\TextColumn::make('jumlah_qr')
                ->label('Jumlah QR Code yang Dicetak'),
                // Tables\Columns\TextColumn::make('data'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                ->modalHeading('QRCode Label'),
            ])
            ->actions([
                //Tables\Actions\EditAction::make(),
                //Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('Qr')
                    ->label('Cetak QR')
                    ->action(
                        function (RelationManager $livewire,$record) {
                        $url = route('qrnons', $record);
                        return [ redirect()->intended($url) ];
                        })
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }    
}
