<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\ProdusenBenih;
use App\Models\User;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Card;
use Closure;
use App\Models\LokasiProduksiDetail;
use App\Models\Provinces;
use App\Models\JenisLembaga;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static bool $shouldRegisterNavigation = true;
    protected static ?string $navigationIcon = 'heroicon-o-collection';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?string $navigationLabel = 'Pengguna';
    protected static ?int $navigationSort = 29;
    
    
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (string $context): bool => $context === 'create'),
                    Forms\Components\Select::make('provinces')
                        ->label('Provinsi')
                        ->options(Provinces::all()->pluck('name','id')->toArray())
                        ->hidden(
                            function(){
                            if (auth()->user()->hasRole("Lembaga Sertifikasi Benih") 
                            or auth()->user()->hasRole("Produsen Benih") 
                            or auth()->user()->hasRole("Pelapor"))
                            {
                                return true;
                            }
                            else
                            {
                                return false;
                            }
                        }
                            )
                        ->reactive(),
                    Forms\Components\Select::make('jenislembaga')
                        ->label('Jenis Lembaga')
                        ->options(JenisLembaga::all()->pluck('nama_jenis','id')->toArray())
                        ->hidden(
                            function(){
                            if (auth()->user()->hasRole("Lembaga Sertifikasi Benih") 
                            or auth()->user()->hasRole("Produsen Benih") 
                            or auth()->user()->hasRole("Pelapor"))
                            {
                                return true;
                            }
                            else
                            {
                                return false;
                            }
                        }
                            )
                        ->reactive(),
                    Forms\Components\Select::make('lembaga_id')
                        ->label('Lembaga')
                        ->options(
                            function(callable $get){
                                if (auth()->user()->hasRole("Lembaga Sertifikasi Benih") 
                            or auth()->user()->hasRole("Produsen Benih") 
                            or auth()->user()->hasRole("Pelapor"))
                            {
                            return ProdusenBenih::where('id',auth()->user()->lembaga_id)->pluck('nama_lembaga','id')->toArray();
                            }else{
                                if(!$get('provinces')){
                                    if(!$get('jenislembaga')){
                                        return ProdusenBenih::all()->pluck('nama_lembaga','id')->toArray();
                                    }else{
                                        return ProdusenBenih::where('jenis_lembaga_id',$get('jenislembaga'))->pluck('nama_lembaga','id')->toArray();
                                    }
                                    
                                   }else{
                                    if(!$get('jenislembaga')){
                                        return ProdusenBenih::where('provinces_id',$get('provinces'))->pluck('nama_lembaga','id')->toArray();
                                    }else{
                                        return ProdusenBenih::where([['provinces_id',$get('provinces')],['jenis_lembaga_id',$get('jenislembaga')]])->pluck('nama_lembaga','id')->toArray();
                                    }
                                    
                                   }
                               
                            }
                               
                            }
                        )    
                        ->preload()                    
                        ->reactive(),
                        Forms\Components\Select::make('lokasi_produksi_detail_id')
                        ->label('Lokasi Produksi')
                            ->options(
                                function(callable $get){
                                    if (auth()->user()->hasRole("Lembaga Sertifikasi Benih")){
                                        return null;
                                    }elseif(auth()->user()->hasRole("Produsen Benih")){
                                        return LokasiProduksiDetail::where('lembaga_id',auth()->user()->lembaga_id)
                                        ->pluck('alamat','id');
                                    }elseif(auth()->user()->hasRole("Pelapor")){
                                        return LokasiProduksiDetail::where('id',auth()->user()->lokasi_produksi_detail_id)
                                        ->pluck('alamat','id');
                                    }else{
                                        if(!$get('lembaga_id')){
                                            return null;
                                        }
                                        return LokasiProduksiDetail::where('lembaga_id',$get('lembaga_id'))
                                        ->pluck('alamat','id');
                                    }
                            }

                            )
                            ->hidden(
                                function(){
                                if (auth()->user()->hasRole("Lembaga Sertifikasi Benih"))
                                {
                                    return true;
                                }
                                else
                                {
                                    return false;
                                }
                            }
                            )
                        ->reactive(),
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
                Forms\Components\Select::make('roles')
                    ->multiple()
					->relationship('roles','name')->preload(),
            ])->columns(2)
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('email')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('roles.name'),
                Tables\Columns\TextColumn::make('produsenbenih.nama_lembaga'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime(),
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
            //
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
    public static function getEloquentQuery(): Builder
    {
        if (auth()->user()->hasRole("Lembaga Sertifikasi Benih") or auth()->user()->hasRole("Produsen Benih") or auth()->user()->hasRole("Pelapor")){
            return parent::getEloquentQuery()->where('lembaga_id',auth()->user()->lembaga_id);
        }else{
            return parent::getEloquentQuery();
        } 
    }  
}
