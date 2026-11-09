<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\AdminPelapor;
use App\Models\AdminProdusen;
use App\Models\Akreditasi;
use App\Models\Cara;
use App\Models\ChildProduksiSwadaya;
use App\Models\Districts;
use App\Models\DokumenPemeriksaanAPBN;
use App\Models\ExportLaporanSertifikat;
use App\Models\ExportPohonInduk;
use App\Models\ExportLembaga;
use App\Models\ExportProduksiStok;
use App\Models\ExportSebaranVarietas;
use App\Models\Golongan;
use App\Models\JenisLembaga;
use App\Models\JenisPemilik;
use App\Models\JenisPenyimpanan;
use App\Models\JenisProdusen;
use App\Models\KegagalanPerbanyakanBenih;
use App\Models\KelasBenih;
use App\Models\KelBenih;
use App\Models\KelKomoditas;
use App\Models\KepemilikanPohonInduk;
use App\Models\Komoditas;
use App\Models\Kondisi;
use App\Models\KondisiPohon;
use App\Models\Label;
use App\Models\LaporanBatangMati;
use App\Models\LaporanBenihPTM;
use App\Models\LaporanLabelMati;
use App\Models\LaporanProduksiMati;
use App\Models\LaporanProduksiSwadaya;
use App\Models\LaporanSertifikasiBenih;
use App\Models\LaporanSertifikasiNonAPBN;
use App\Models\LaporanStokProdusen;
use App\Models\LaporanTargetBenih;
use App\Models\LapProdusenNon;
use App\Models\LembagaSertifikasi;
use App\Models\LokasiGudangDetail;
use App\Models\LokasiProduksiDetail;
use App\Models\NomorRegistrasi;
use App\Models\PemeriksaanTanaman;
use App\Models\Pemohon;
use App\Models\PenerimaanBatangBawah;
use App\Models\PengadaanStokBenih;
use App\Models\PenguranganStokBenih;
use App\Models\PenyaluranStokBenih;
use App\Models\PerpanjanganSMM;
use App\Models\PertumbuhanBenih;
use App\Models\PohonInduk;
use App\Models\ProduksiBenih;
use App\Models\ProduksiBenihAPBD;
use App\Models\ProduksiBenihUmum;
use App\Models\ProdusenBenih;
use App\Models\ProsesPerbanyakanBenih;
use App\Models\Provinces;
use App\Models\ProvincesSebaran;
use App\Models\QRNon;
use App\Models\Regencies;
use App\Models\RegistrasiPohonInduk;
use App\Models\Regulasi;
use App\Models\SaranaLembaga;
use App\Models\Satuan;
use App\Models\SertifikasiBenih;
use App\Models\SertifikasiNonAPBN;
use App\Models\SertifikatKompetensi;
use App\Models\StokProdusen;
use App\Models\StokOp;
use App\Models\TargetBenih;
use App\Models\TargetSalur;
use App\Models\User;
use App\Models\Varietas;
use App\Models\VarietasSanggah;
use App\Models\VarietasSebar;
use App\Models\Villages;
use Spatie\Activitylog\Models\Activity;

class ExportController extends Controller
{
	
	public function varsebar_nas()
	{
		$provinsis = ProvincesSebaran::all();
		$jeniskom = KelKomoditas::all();
		$komoditas = Komoditas::all();
		$varietas = Varietas::all();
		$lapsebaran = VarietasSebar::all();
		$lapsebaranvar = VarietasSebar::groupBy('varietas_id')->get();
		
		return view('export/varietas/varsebar_nas', compact('lapsebaranvar','lapsebaran','varietas','jeniskom', 'komoditas', 'provinsis'));
	}
    public function varsebar_prov($id)
	{
		$kabupaten = Regencies::where('provinces_id',$id)->get();
		$sebal = VarietasSebar::where('provinces_id',$id)->get();
		$provinsis = ProvincesSebaran::where('id',$id)->first();
		$jeniskom = KelKomoditas::all();
		$komoditas = Komoditas::all();
		$varietas = Varietas::all();
		$varietas1 = Varietas::paginate(20);
		$varietassanggah = VarietasSanggah::paginate(20);
		$lapsebaran = VarietasSebar::paginate(20);
		$lapsebaranvar = VarietasSebar::where('provinces_id',$id)->groupBy('varietas_id','provinces_id')->get();
		$lapsebaranvar1 = VarietasSebar::where('provinces_id',$id)->groupBy('varietas_id','provinces_id')->get();
		
		return view('export/varietas/varsebar_prov', compact('id','sebal','kabupaten','lapsebaranvar1','lapsebaranvar','varietas1','lapsebaran','varietas','varietassanggah','jeniskom', 'komoditas', 'provinsis'));
	}
    public function varsebar_kab()
	{
		$provinsis = ProvincesSebaran::all();
		$regencies = Regencies::all();
		$jeniskom = KelKomoditas::all();
		$komoditas = Komoditas::all();
		$varietas = Varietas::all();
		$lapsebaran = VarietasSebar::all();
		
		return view('export/varietas/varsebar_kab', compact('lapsebaran','varietas','jeniskom', 'komoditas', 'provinsis'));
	}
	public function varprod_nas()
	{
		$provinsis = Provinces::all();
		$jenisprod = JenisProdusen::all();
		$lembaga = ProdusenBenih::whereIn('jenis_lembaga_id', [2, 6])->get();
		$targetnya = LaporanTargetBenih::all();
		$berlabel = PemeriksaanTanaman::get();
		$ptmnya = LaporanBenihPTM::get();
		$nonapbn = LaporanProduksiSwadaya::all();
		
		return view('export/produksi/apbn/varprod_nas', compact('nonapbn','jenisprod','provinsis','lembaga', 'targetnya','berlabel','ptmnya'));
	}
	public function varprodnon_nas()
	{
		$provinsis = Provinces::all();
		$jenisprod = JenisProdusen::all();
		$lembaga = ProdusenBenih::whereIn('jenis_lembaga_id', [2, 6])->get();
		$targetnya = LaporanTargetBenih::all();
		$berlabel = PemeriksaanTanaman::get();
		$ptmnya = LaporanBenihPTM::get();
		$nonapbn = LaporanProduksiSwadaya::all();
		
		return view('export/produksi/non/varprod_non_nas', compact('nonapbn','jenisprod','provinsis','lembaga', 'targetnya','berlabel','ptmnya'));
	}
	
}
