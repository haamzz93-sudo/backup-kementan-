<?php

namespace App\Providers;

use Filament\Navigation\UserMenuItem;
use Filament\Navigation\NavigationItem;
use Filament\Facades\Filament;
use App\Filament\Resources\CaraResource;
use App\Filament\Resources\DistrictsResource;
use App\Filament\Resources\GolonganResource;
use App\Filament\Resources\JenisLembagaResource;
use App\Filament\Resources\JenisPemilikResource;
use App\Filament\Resources\JenisProdusenResource;
use App\Filament\Resources\KelasBenihResource;
use App\Filament\Resources\KelBenihResource;
use App\Filament\Resources\KelKomoditasResource;
use App\Filament\Resources\KepemilikanPohonIndukResource;
use App\Filament\Resources\KomoditasResource;
use App\Filament\Resources\KondisiResource;
use App\Filament\Resources\LembagaSertifikasiResource;
use App\Filament\Resources\NomorRegistrasiResource;
use App\Filament\Resources\PemohonResource;
use App\Filament\Resources\PohonIndukResource;
use App\Filament\Resources\ProduksiBenihResource;
use App\Filament\Resources\ProduksiBenihAPBDResource;
use App\Filament\Resources\ProduksiBenihUmumResource;
use App\Filament\Resources\ProdusenBenihResource;
use App\Filament\Resources\ProvincesResource;
use App\Filament\Resources\ProvincesSebaranResource;
use App\Filament\Resources\RegenciesResource;
use App\Filament\Resources\SatuanResource;
use App\Filament\Resources\SertifikasiBenihResource;
use App\Filament\Resources\StokProdusenResource;
use App\Filament\Resources\TargetBenihResource;
use App\Filament\Resources\UserResource;
use App\Filament\Resources\VillagesResource;
use App\Models\User;
use Z3d0X\FilamentLogger\Resources\ActivityResource;
use BezhanSalleh\FilamentShield\Resources\RoleResource;

use Illuminate\Support\ServiceProvider;


class FilamentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot() {
        if(auth()->user()!==null){
        if (auth()->user()->hasRole("Lembaga Sertifikasi Benih") 
        or auth()->user()->hasRole("Produsen Benih") 
        or auth()->user()->hasRole("Pelapor"))
        {
        Filament::serving(function() {
                Filament::registerNavigationItems([

                ]);

        });
    }else{
        Filament::registerNavigationItems([
            NavigationItem::make('Daftar Pengguna')
                ->url(UserResource::getUrl())
                ->icon('heroicon-o-users')
                ->group('Settings')
        ]);
    }
    }
    }
    
}
