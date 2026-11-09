<?php
 
namespace App\Filament\Pages;
 
use Filament\Pages\Dashboard as BasePage;
use Illuminate\Contracts\Support\Htmlable;
use App\Models\ProdusenBenih;
use App\Models\JenisLembaga;
use App\Models\Provinces;
use App\Models\Varietas;
use App\Models\VarietasSanggah;
use App\Models\VarietasSebar;
use App\Models\LaporanTargetBenih;
use App\Models\LembagaSertifikasi;
use App\Models\LokasiProduksiDetail;
use App\Models\NomorRegistrasi;
use DB;

class Dashboard extends BasePage
{
//     protected function getSubheading(): string | Htmlable | null
//     {
//         $provinsis = DB::table('provinces')->get();
//         if (auth()->user()->hasRole("super_admin") or auth()->user()->hasRole("Pimpinan") or auth()->user()->hasRole("Admin Pv") or auth()->user()->hasRole("Admin Prokel") or auth()->user()->hasRole("Admin Pmb") ){
//         $lembaga = ProdusenBenih::all();
//         }elseif (auth()->user()->hasRole("Lembaga Sertifikasi Benih")){
//          $lembaga = ProdusenBenih::all(); 
//         }else{
//         $lembaga = ProdusenBenih::all(); 
//         }
//         $lokasi = LokasiProduksiDetail::all();
        
//         $pohonbbh = NomorRegistrasi::join('pemilik_pohon','pemilik_pohon.id','child_pohon_induk.pemilik_pohon_id')->where('pemilik_pohon_id',auth()->user()->lembaga_id)->count('no_registrasi');
//         $pohonbpsb = NomorRegistrasi::where('lembaga_serti_id',auth()->user()->lembaga_id)->count('no_registrasi');
//         $currentDate = date('Y-m-d');
//         $varietas =Varietas::all();
//         $varsang = VarietasSanggah::all();
// ;
        
//             $url = url('/');

            
//         return view('admin.dashboard',compact(
//             'currentDate',
//                 // 'bbhsuper',
//                 // 'umumsuper',
//                 // 'swastasuper',
//                 // 'upbssuper',
//                 // 'bbh',
//                 // 'umum',
//                 // 'swasta',
//                 // 'upbs',
//                 'lembaga',
//                 'pohonbbh',
//                 'pohonbpsb',
//                 //'bpsb',
//                 'lokasi',
//                 'varietas',
//                 'varsang',
//                 'provinsis',
//                 'url'));
//     }
    
}