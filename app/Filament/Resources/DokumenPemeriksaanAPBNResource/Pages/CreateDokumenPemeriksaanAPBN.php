<?php

namespace App\Filament\Resources\DokumenPemeriksaanAPBNResource\Pages;

use App\Filament\Resources\DokumenPemeriksaanAPBNResource;
use Filament\Pages\Actions\Action;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDokumenPemeriksaanAPBN extends CreateRecord
{
    protected static string $resource = DokumenPemeriksaanAPBNResource::class;
    protected static bool $canCreateAnother = false;
    protected function getRedirectUrl(): string
    {
        return $this->previousUrl;
    }
    protected function getFormActions(): array
    {
	 if (auth()->user()->hasRole("Produsen Benih") or auth()->user()->hasRole("Pelapor")){
        return array_merge(parent::getFormActions(), [
            Action::make('create')->hidden(),
            Action::make('cancel')->hidden(),
            Action::make('kembali')
                ->url(function($record){ return $this->previousUrl; }),
        ]);
	}else if (auth()->user()->hasRole("Lembaga Sertifikasi Benih")){
        return array_merge(parent::getFormActions(), [
        ]);
}
    }
}
