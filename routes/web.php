<?php
use App\Http\Livewire\VarietasTerdaftar;
use App\Http\Livewire\VarietasSanggah1;
use App\Http\Livewire\PohonInduk1;
use App\Http\Livewire\Apbn;
use App\Http\Livewire\KinerjaPelaporan;
use App\Http\Livewire\NonApbn;
use App\Http\Livewire\Serkom;
use App\Http\Livewire\PohonInduk;
use App\Http\Livewire\Produsen;
use App\Http\Livewire\SebaranVarietas;
use App\Filament\Pages\Dashboard;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\ExportQR;
use App\Http\Controllers\LembagaQrController;
use App\Http\Controllers\ExcelController;


use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// livewire
// Prokel

        Route::get('/export/{id}', [ExcelController::class, 'export'])
        ->name('export');
// table Produksi APBN
        Route::get('/l-apbn', Apbn::class);

        // table Produksi Non APBN
        Route::get('/l-nonapbn', NonApbn::class);

        // pmb
        // table serkom
        Route::get('/l-serkom', Serkom::class);

        // PV
        // tabelsebaran varietas
        Route::get('/l-sebarvar', SebaranVarietas::class);
        // Database

        // tabelprodusen
        Route::get('/l-produsen', Produsen::class);

        // tabelpohoninduk
        Route::get('/l-pohin', PohonInduk1::class);

        // tabelvarietasterdaftar
        Route::get('/l-vardaf', VarietasTerdaftar::class);

        // tabelvarietassanggah
        Route::get('/l-varsang', VarietasSanggah1::class);

        // kinerjapelaporan
        Route::get('/l-kinerja', KinerjaPelaporan::class);
        //iframe
        Route::get('/1', [FrontController::class, 'varietasdaftar']);
        Route::get('/detail-pohon-kosong/{id}', [FrontController::class, 'detailpohonkosong'])
                ->name('detail-pohon-kosong');
        Route::get('/', function () {
        return view('index');
        });
        Route::get('/', [FrontController::class, 'depan'])
                ->name('index');
        Route::get('admin/produsen-benihs/{id}', [LembagaQrController::class, 'generateInvoice'])
                ->name('produsen-benihs');
        Route::get('admin/pohon-induks/{id}', [LembagaQrController::class, 'PohonQr'])
                ->name('pohon-induks');
                
        Route::get('admin/labels/{id}', [LembagaQrController::class, 'LabelQr'])
                ->name('labels');
        Route::get('admin/qrlabels/{id}', [LembagaQrController::class, 'Qr'])
                ->name('qrlabels');
        Route::get('admin/qrnons/{id}', [LembagaQrController::class, 'Qrnon'])
                ->name('qrnons');
        Route::get('admin/labelnons/{id}', [LembagaQrController::class, 'labelnons'])
                ->name('labelnons');

        Route::get('/peta-salur/{id}', [FrontController::class, 'petasebar'])
                ->name('peta-salur');
        Route::get('/detail-produsen/{id}', [FrontController::class, 'detailprodusen'])
        ->name('detail-produsen');
        Route::get('/detail-produsen-non/{id}', [FrontController::class, 'detailprodusennon'])
        ->name('detail-produsen-non');
        Route::get('/detail-pohon/{id}', [FrontController::class, 'detailpohon'])
                ->name('detail-pohon');
        
        Route::get('/detail-benihsalur/{id}', [FrontController::class, 'detailbenihsalurqr'])
                ->name('detail-benihsalur');
        Route::get('/prokel', [FrontController::class, 'prokel'])
                ->name('prokel');
        Route::get('/pmb', [FrontController::class, 'pmb'])
                ->name('pmb');
        Route::get('/pv', [FrontController::class, 'pv'])
                ->name('pv');
        Route::get('/detailpvsebar/{id}', [FrontController::class, 'detailpvsebar'])
                ->name('detailpvsebar');
        Route::get('/detailprokelsebar/{id}', [FrontController::class, 'detailprokelsebar'])
                ->name('detailprokelsebar');
        Route::get('/produsen', [FrontController::class, 'produsen'])
                ->name('produsen');
        Route::get('/pohon', [FrontController::class, 'pohon'])
                ->name('pohon');
        Route::get('/produksi-apbn', [FrontController::class, 'produksiapbn'])
                ->name('produksi-apbn');
        Route::get('/produksi-nonapbn', [FrontController::class, 'produksinonapbn'])
                ->name('produksi-non-apbn');
        Route::get('/serkom', [FrontController::class, 'serkom'])
                ->name('serkom');
        Route::get('/sebaran-varietas', [FrontController::class, 'varsebar'])
                ->name('sebaran-varietas');
// Route::get('/benih-salur', [FrontController::class, 'benihsalur'])
//         ->name('benihsalur');
//Route::get('/varietas-daftar', [FrontController::class, 'varietasdaftar'])
//        ->name('varietasdaftar');
	Route::get('/varietas-daftar', function () {
                return view('/new/varietas-terdaftar');
        });
        Route::get('/varietas-sanggah', [FrontController::class, 'varietassanggah'])
                ->name('varietassanggah');
        Route::get('/kinerja', [FrontController::class, 'lapor'])
                ->name('lapor');
        Route::get('/detail-kinerja/{user_id}/{bulan}', [FrontController::class, 'detaillapor'])
                ->name('detaillapor');
        Route::get('/dashboard', function () {
        return view('dashboard');
        })->middleware(['auth', 'verified'])->name('dashboard');

        Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
                });
        //export PV
        Route::get('/pv/export/varsebar_nas', [ExportController::class, 'varsebar_nas'])
                ->name('varsebar_nas');
        Route::get('/pv/export/varsebar_prov/{id}', [ExportController::class, 'varsebar_prov'])
                ->name('varsebar_prov');
        Route::get('/pv/export/varsebar_kab', [ExportController::class, 'varsebar_kab'])
                ->name('varsebar_kab');
        //export prokel apbn
        Route::get('/prokel/export/varprod_nas', [ExportController::class, 'varprod_nas'])
                ->name('varprod_nas');
        //export prokel non apbn
        Route::get('/prokel/non/export/varprod_nas', [ExportController::class, 'varprodnon_nas'])
                ->name('varprodnon_nas');