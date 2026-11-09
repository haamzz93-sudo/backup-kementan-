<?php

namespace App\Filament\Resources\ProdusenBenihResource\RelationManagers;

use App\Models\User;
use App\Models\ProdusenBenih;
use App\Models\LokasiProduksiDetail;
use Filament\Forms;
use Filament\Resources\Form;
use Closure;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;

class AdminPelaporRelationManager extends RelationManager
{
    protected static string $relationship = 'User';

    protected static ?string $title = 'Admin Pelapor';
    protected static ?string $recordTitleAttribute = 'lembaga_id';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('lembaga_id')
                ->default(fn ($livewire) => $livewire->ownerRecord->getKey())
                ->reactive(),
                Forms\Components\Select::make('lokasi_produksi_detail_id')
                    ->label('Lokasi Produksi')
                    ->options(function(callable $get){
                        if(!$get('lembaga_id')){
                            return null;
                        }
                        return LokasiProduksiDetail::where('lembaga_id',$get('lembaga_id'))
                        ->pluck('alamat','id');
                    })
                    ->reactive()
                    ->required(),
                Forms\Components\TextInput::make('name')
                ->label('Nama')
                ->required()
                ->maxLength(255),
                Forms\Components\TextInput::make('email')
                ->email()
                ->required()
                ->unique(ignoreRecord: true)
                ->maxLength(255),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->required()
                    ->maxLength(50)
                    ->minLength(8)
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state)),
                Forms\Components\TextInput::make('no_hp')
                ->label('No. Telp')
                ->required()
                ->tel()
                ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/'),
                Forms\Components\Toggle::make('dapat_hp')->label('Menggunakan Android Horti?')
                ->reactive()
                ->requiredWith('username')
                ->afterStateUpdated(
                    fn ($state, callable $set) => $state ? $set('username', null) : $set('username', 'hidden')
                ),
                Forms\Components\TextInput::make('username')
                ->requiredWith('dapat_hp')
                ->label('Kode Android')
                ->hidden(
                    fn (Closure $get): bool => $get('dapat_hp') == false
                ),
                Forms\Components\CheckboxList::make('roles')
					->relationship('roles','name',fn(Builder $query)=> $query->where('id',6))
					->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                ->label('Nama')
                ->searchable()
                ->sortable(),
                Tables\Columns\TextColumn::make('roles.name')
                ->label('Roles'),
                Tables\Columns\TextColumn::make('email')
                ->label('Email')
                ->searchable()
                ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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
