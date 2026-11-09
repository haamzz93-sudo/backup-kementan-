<?php

namespace App\Filament\Resources\LaporanProduksiSwadayaResource\RelationManagers;

use App\Models\FormLabel;
use App\Models\KepemilikanPohonInduk;
use App\Models\LaporanProduksiSwadaya;
use App\Models\NomorRegistrasi;
use App\Models\PohonInduk;
use App\Models\ProduksiBenihUmum;
use App\Models\User;
use App\Models\SertifikatKompetensi;
use Closure;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use DB;
use Illuminate\Support\Str;
use Filament\Tables\Actions\Position;

class ChildProduksiSwadayaRelationManager extends RelationManager
{
    protected static string $relationship = 'ChildProduksiSwadaya';

    protected static ?string $title = 'Laporan Produksi';
    protected static ?string $recordTitleAttribute = 'laporan_produksi_swadaya_id';
    protected function getTableActionsPosition(): ?string
    {
        return Position::BeforeCells;
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('laporan_produksi_swadaya_id')
                    ->default(fn ($livewire) => $livewire->ownerRecord->getKey())
                    ->reactive(),
                Forms\Components\DatePicker::make('tanggal_lapor')
                    ->label('Tanggal Pengajuan Label')
                    ->required(),
                Forms\Components\TextInput::make('produksi_benih')
                    ->label('Jumlah Pengajuan Label')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('salur_benih')
                    ->label('Jumlah Label yang Dicetak')
                    ->numeric()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tanggal_lapor')
                    ->label("Tanggal Pengajuan Label"),
                Tables\Columns\TextColumn::make('produksi_benih')
                    ->label("Jumlah Pengajuan Label")
                    ->getStateUsing(function ($livewire, $record) {
                        return $record->produksi_benih . " " . $livewire->ownerRecord->satuan->nama_satuan;
                    }),
                Tables\Columns\TextColumn::make('salur_benih')
                    ->label("Jumlah Label yang Dicetak")
                    ->getStateUsing(function ($livewire, $record) {
                        return $record->salur_benih . " " . $livewire->ownerRecord->satuan->nama_satuan;
                    }),
                // Tables\Columns\TextColumn::make('dicetak_oleh1')
                //     ->label('Tercetak Oleh')
                //     ->default(function ($record) {
                //         if (null !== $record->dicetak_oleh) {
                //             $user = User::where('id', $record->dicetak_oleh)->first();
                //             return $user->name;
                //         } else {
                //             return "Belum Didownload";
                //         }
                //     }),
                Tables\Columns\TextColumn::make('jumlah_download')
                    ->label('Jumlah Download QRCode')
                    ->default(0),
                Tables\Columns\TextColumn::make('jumlah_label_download')
                    ->label('Jumlah Download Label')
                    ->default(0),
                Tables\Columns\TextColumn::make('jumlah_generate_excel')
                    ->label('Jumlah Download Excel')
                    ->default(0),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->modalHeading('Laporan Produksi'),
                Tables\Actions\Action::make('Kembali')
                    ->label('Kembali')
                    ->url(
                        function ($livewire) {
                            return route('filament.resources.produksi-benih-umums.edit', [$livewire->ownerRecord->lembaga_id]);
                        }
                    ),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\EditAction::make('generate')
                    ->label('Data QRCode')
                    ->visible(
                        function ($record) {
                            if ($record->produksi_benih > 0) {
                                return true;
                            } else {
                                return false;
                            }
                        }
                    )
                    ->color('success')
                    ->button()
                    ->form([
                        Forms\Components\CheckboxList::make('child_smm')
                            ->options(function ($livewire) {
                                $sert = LaporanProduksiSwadaya::where('id', $livewire->ownerRecord->id)->first();
                                $lembaga_non = ProduksiBenihUmum::where('id', $sert->lembaga_id)->first();
                                return SertifikatKompetensi::where('lembaga_id', $lembaga_non->id)->pluck('no_serti', 'no_serti')->toArray();
                            })
                            ->label('No. Sertifikat Kompetensi SMM/ No. Sertifikat Kompetensi LSSM/No. Sertifikat Kompetensi Produsen'),
                        Forms\Components\TextInput::make('no_batch')
                            ->label('No. Lot/ No. Kelompok Benih')
                            ->required(),

                        Forms\Components\TextInput::make('no_induk_sertifikasi')
                            ->label('No. Induk Sertifikasi')
                            ->required(),
                        Forms\Components\TextInput::make('no_sertifikat')
                            ->label('No. Sertifikat')
                            ->required(),
                        Forms\Components\TextInput::make('kode_urut_awal')
                            ->label('Kode No. Seri Awal')
                            ->required(),
                        Forms\Components\TextInput::make('no_awal')
                            ->label('No. Seri Awal')
                            ->required()
                            ->numeric(),
                        Forms\Components\TextInput::make('no_akhir')
                            ->label('No. Seri Akhir')
                            ->required()
                            ->numeric(),
                        Forms\Components\TextInput::make('no_registrasi_pohon')
                            ->label('Nomor Registrasi Tanaman Induk'),
                        Forms\Components\TextInput::make('pemilik_pohon')
                            ->label('Nama Pemilik Tanaman Induk'),
                        Forms\Components\TextInput::make('alamat_pohon')
                            ->label('Alamat Pemilik Tanaman Induk'),
                        Forms\Components\Repeater::make('data')
                            ->schema(
                                function ($livewire) {
                                    $idmaster = LaporanProduksiSwadaya::where('id', $livewire->ownerRecord->id)->first();
                                    $formlabel = FormLabel::where([['golongan_id', $idmaster->golongan_id], ['cara_id', $idmaster->cara_id]])->first();
                                    $das = $formlabel->json_form;
                                    foreach ($das as $item) {
                                        if (isset($item['required'])) {
                                            // If 'required' key exists, create the TextInput with required attribute
                                            $data[] = Forms\Components\TextInput::make($item['key'])
                                                ->label($item['key'])
                                                ->required(function () use ($item) {
                                                    return $item['required'];
                                                });
                                        } else {
                                            // If 'required' key does not exist, create the TextInput without required attribute
                                            $data[] = Forms\Components\TextInput::make($item['key'])
                                                ->label($item['key']);
                                        }
                                    }
                                    return $data;
                                }
                            )
                            ->defaultItems(1)
                            ->minItems(1)
                            ->maxItems(1)
                            ->required()
                            ->columns(1)
                    ]),
                Tables\Actions\Action::make('Qr')
                    ->hidden(
                        function ($record) {
                            if (auth()->user()->id != 1 && $record->boleh_download == 1) {
                                return false;
                            } else {
                                return true;
                            }
                        }
                    )
                    ->button()
                    ->color('success')
                    ->label('Generate QRCode')
                    ->action(
                        function (RelationManager $livewire, $record) {
                            $url = route('qrnons', $record->id);
                            $user = auth()->user()->id;
                            return [
                                DB::table('child_produksi_swadaya')->where('id', $record->id)->update([
                                    'dicetak_oleh' => $user,
                                    'jumlah_download' => $record->jumlah_download + 1,
                                    'boleh_download' => 0,
                                ]),
                                redirect()->intended($url),
                            ];
                        }
                    )
                    ->openUrlInNewTab()
                    ->visible(
                        function ($record) {
                            if (is_array($record->data) && count($record->data) > 0) {
                                return true;
                            } else {
                                return false;
                            }
                        }
                    ),
                Tables\Actions\Action::make('label')
                    ->hidden(
                        function ($record) {
                            if (auth()->user()->id != 1 && $record->boleh_label_download == 1) {
                                return false;
                            } else {
                                return true;
                            }
                        }
                    )
                    ->button()
                    ->color('success')
                    ->label('Generate Label')
                    ->action(
                        function (RelationManager $livewire, $record) {
                            $url = route('labelnons', $record->id);
                            $user = auth()->user()->id;
                            return [
                                DB::table('child_produksi_swadaya')->where('id', $record->id)->update([
                                    'dicetak_oleh' => $user,
                                    'jumlah_label_download' => $record->jumlah_label_download + 1,
                                    'boleh_label_download' => 0,
                                ]),
                                redirect()->intended($url),
                            ];
                        }
                    )
                    ->openUrlInNewTab()
                    ->visible(
                        function ($record) {
                            if (is_array($record->data) && count($record->data) > 0) {
                                return true;
                            } else {
                                return false;
                            }
                        }
                    ),
                    
                Tables\Actions\Action::make('excel')
                ->hidden(
                    function ($record) {
                        if (auth()->user()->id != 1 && $record->generate_excel == 1) {
                            return false;
                        } else {
                            return true;
                        }
                    }
                )
                ->button()
                ->color('success')
                ->label('Export Excel')->action(
                    function (RelationManager $livewire, $record) {
                        $url = route('export', $record->id);
                        $user = auth()->user()->id;
                        return [
                            DB::table('child_produksi_swadaya')->where('id', $record->id)->update([
                                'dicetak_oleh' => $user,
                                'jumlah_generate_excel' => $record->jumlah_generate_excel + 1,
                                'generate_excel' => 0,
                            ]),
                            redirect()->intended($url),
                        ];
                    }
                )
                ->openUrlInNewTab()
                ->visible(
                    function ($record) {
                        if (is_array($record->data) && count($record->data) > 0) {
                            return true;
                        } else {
                            return false;
                        }
                    }
                ),
                Tables\Actions\Action::make('Ajukan')
                    ->hidden(
                        function ($record) {
                            if (auth()->user()->hasRole("super_admin") && $record->boleh_download == 0 || auth()->user()->hasRole("Lembaga Sertifikasi Benih") && $record->boleh_download == 0 || auth()->user()->hasRole("Produsen Benih") && $record->boleh_download == 0) {
                                return false;
                            } else {
                                return true;
                            }
                        }
                    )
                    ->label('Izinkan Cetak Ulang')
                    ->action(
                        function (RelationManager $livewire, $record) {
                            $user = auth()->user()->id;
                            return [
                                DB::table('child_produksi_swadaya')->where('id', $record->id)->update([
                                    'boleh_download' => 1,
                                    'boleh_label_download' => 1,
                                    'generate_excel' => 1,
                                ]),
                            ];
                        }
                    )
                    ->button()
                    ->color('success')
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
            
    }
}
