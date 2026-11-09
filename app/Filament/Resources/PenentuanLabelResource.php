<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PenentuanLabelResource\Pages;
use App\Filament\Resources\PenentuanLabelResource\RelationManagers;
use App\Models\LaporanBenihPTM;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PenentuanLabelResource extends Resource
{
    protected static ?string $model = LaporanBenihPTM::class;
    protected static ?string $slug = 'penentuan-labels';
    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $navigationLabel = 'Penentuan Label (hide)';
    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
                
            Forms\Components\Hidden::make('target_benih_id'),

             Forms\Components\DatePicker::make('tanggal_panen')
             ->label('Tanggal Pelaporan PTM (Pre-Uji)')
             ->disabled(),
             Forms\Components\TextInput::make('jum_panen')
             ->label('Jumlah Benih PTM (Pre-Uji)')
             ->numeric()
             ->required()
             ->disabled(),
             Forms\Components\FileUpload::make('upload')
             ->enableDownload()
                 ->enableOpen()
             ->label('Upload Foto')
             ->required()
             ->disabled(),
             Forms\Components\Textarea::make('keterangan')
             ->label('Keterangan')
             ->disabled(),
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
            Tables\Columns\TextColumn::make('upload')
            ->label('Upload Foto'),
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
            RelationManagers\PenentuanlabelRelationManager::class,
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPenentuanLabels::route('/'),
            'create' => Pages\CreatePenentuanLabel::route('/create'),
            'edit' => Pages\EditPenentuanLabel::route('/{record}/edit'),
        ];
    }    
}
