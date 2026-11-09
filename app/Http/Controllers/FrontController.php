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

class FrontController extends Controller
{
	public function depan()
	{
		$countlembaga = ProdusenBenih::whereIn('jenis_lembaga_id', [2, 6])->count('id');
		$countlabel = Label::all()->sum('jumlah_label');
		$countpohon = NomorRegistrasi::whereNotNull('pohon_induk_id')->count('id');
		$countvarietas = Varietas::all()->count('id');
		return view('index', compact('countlembaga','countpohon','countlabel','countvarietas'));
	}
	public function prokel()
	{
		$provinsis = Provinces::all();
		$jenisprod = JenisProdusen::all();
		$lembaga = ProdusenBenih::whereIn('jenis_lembaga_id', [2, 6])->get();
		$targetnya = LaporanTargetBenih::paginate(10);
		$berlabel = PemeriksaanTanaman::get();
		$ptmnya = LaporanBenihPTM::get();
		$nonapbn = LaporanProduksiSwadaya::paginate(10);
		return view('new/prokel', compact('nonapbn','jenisprod','provinsis','lembaga', 'targetnya','berlabel','ptmnya'));
	}	
	public function produksiapbn()
	{
		return view('new/produksi-apbn');
	}
	public function produksinonapbn()
	{
		return view('new/produksi-non-apbn');
	}
	public function serkom()
	{
		return view('new/sertifikat-kompetensi');
	}
	public function varsebar()
	{
		return view('new/varietas-sebar');
	}
	public function detailprokelsebar($id)
	{
		$provinsis = Provinces::where('id',$id)->first();
		$kabupaten = Regencies::where('provinces_id',$id)->get();
		$jenisprod = JenisProdusen::all();
		$lembaga = ProdusenBenih::where('provinces_id',$id)->whereIn('jenis_lembaga_id', [2, 6])->get();
		$targetnya = LaporanTargetBenih::all();
		$berlabel = PemeriksaanTanaman::get();
		$ptmnya = LaporanBenihPTM::get();
		return view('new/detail/detailprokelsebar', compact('kabupaten','id','jenisprod','provinsis','lembaga', 'targetnya','berlabel','ptmnya'));
	}
	public function detailproduksi()
	{
		if (isset($_GET['year'])) {
			$year = $_GET['year'];
		} else {
			$year = date("Y");
		}
		if (isset($_GET['idkom'])) {
			$parkom = $_GET['idkom'];
		} else {
			$parkom = null;
		}
		if (isset($_GET['idprov'])) {
			$parprov = $_GET['idprov'];
		} else {
			$parprov = null;
		}
		if (isset($_GET['idsat'])) {
			$parsat = $_GET['idsat'];
		} else {
			$parsat = null;
		}
		$url = url("/");
		if ($parprov and $parkom and $parsat) {
			$provinsis1 = DB::table('provinces')->where('id', $parprov)->first();
			$komoditas1 = DB::table('komoditas')->where('id', $parkom)->first();
			$satuan1 = DB::table('satuan')->where('id', $parsat)->first();
			$target_benih = DB::table('target_benih')
				->select(
					'*',
					'target_benih.id as idtar'
				)
				->join('lembaga', 'lembaga.id', 'target_benih.lembaga_id')
				->where([['target_benih.tahun', '=', $year], ['target_benih.komoditas_id', $parkom], ['target_benih.satuan_id', $parsat], ['lembaga.provinces_id', $parprov], ['target_benih.status', "active"]])
				->get();
		} elseif ($parprov and $parkom == NULL and $parsat == NULL) {
			$provinsis1 = DB::table('provinces')->where('id', $parprov)->first();
			$target_benih = DB::table('target_benih')
				->select(
					'*',
					'target_benih.id as idtar'
				)
				->join('lembaga', 'lembaga.id', 'target_benih.lembaga_id')
				->where([['target_benih.tahun', '=', $year], ['lembaga.provinces_id', $parprov], ['target_benih.status', "active"]])
				->get();
		} elseif ($parprov == NULL and $parkom and $parsat) {
			$komoditas1 = DB::table('komoditas')->where('id', $parkom)->first();
			$satuan1 = DB::table('satuan')->where('id', $parsat)->first();
			$target_benih = DB::table('target_benih')
				->select(
					'*',
					'target_benih.id as idtar'
				)
				->where([['target_benih.tahun', '=', $year], ['target_benih.komoditas_id', $parkom], ['target_benih.satuan_id', $parsat], ['target_benih.status', "active"]])
				->get();
		} else {
			$target_benih = DB::table('target_benih')
				->select(
					'*',
					'target_benih.id as idtar'
				)
				->where([['target_benih.tahun', '=', $year], ['target_benih.status', "active"]])
				->get();
		}
		$provinsis = DB::table('provinces')->get();
		$komkel = DB::table('kel_komoditas')->get();
		$komoditas = DB::table('komoditas')->get();
		$varietas = DB::table('varietas')->get();
		$satuan = DB::table('satuan')->get();
		$btg_bwh = DB::table('lap_pengadaan_btgbwh')->get();
		$benih_tumbuh = DB::table('lap_benih_tumbuh')->get();
		$benih_mati = DB::table('lap_benih_mati')->get();
		$benih_panen = DB::table('lap_benih_panen')->get();
		$sertifikasi_benih = DB::table('lap_sertifikasi_benih')->get();
		$benih_label = DB::table('lap_benih_label')->get();


		return view('new/detail/produksi', compact('parprov', 'parkom', 'parsat', 'komoditas1', 'satuan1', 'provinsis1', 'year', 'provinsis', 'lembaga', 'jenis_produsen', 'target_benih', 'komkel', 'komoditas', 'varietas', 'satuan', 'btg_bwh', 'benih_tumbuh', 'benih_mati', 'benih_panen', 'sertifikasi_benih', 'benih_label'));
	}
	public function pv()
	{
		$provinsis = ProvincesSebaran::all();
		$jeniskom = KelKomoditas::all();
		$komoditas = Komoditas::all();
		$varietas = Varietas::all();
		$varietas1 = Varietas::paginate(20);
		$varietassanggah = VarietasSanggah::paginate(20);
		$lapsebaran = VarietasSebar::paginate(20);
		$lapsebaranvar = VarietasSebar::groupBy('varietas_id')->paginate(20);
		$lapsebaranvar1 = VarietasSebar::groupBy('varietas_id')->get();

		return view('new/pv', compact('lapsebaranvar1', 'lapsebaranvar', 'varietas1', 'lapsebaran', 'varietas', 'varietassanggah', 'jeniskom', 'komoditas', 'provinsis'));
	}

	public function detailpvsebar($id)
	{
		$kabupaten = Regencies::where('provinces_id', $id)->get();
		$sebal = VarietasSebar::where('provinces_id', $id)->get();
		$provinsis = ProvincesSebaran::where('id', $id)->first();
		$jeniskom = KelKomoditas::all();
		$komoditas = Komoditas::all();
		$varietas = Varietas::all();
		$varietas1 = Varietas::paginate(20);
		$varietassanggah = VarietasSanggah::paginate(20);
		$lapsebaran = VarietasSebar::paginate(20);
		$lapsebaranvar = VarietasSebar::where('provinces_id', $id)->groupBy('varietas_id')->paginate(20);
		$lapsebaranvar1 = VarietasSebar::where('provinces_id', $id)->groupBy('varietas_id')->get();

		return view('new/detail/detailkabsebar', compact('id', 'sebal', 'kabupaten', 'lapsebaranvar1', 'lapsebaranvar', 'varietas1', 'lapsebaran', 'varietas', 'varietassanggah', 'jeniskom', 'komoditas', 'provinsis'));
	}
	public function pmb()
	{
	    $provinsis = Provinces::all();
		$jenisprod = JenisProdusen::all();
		$lembaga = ProdusenBenih::whereIn('jenis_lembaga_id', [2, 6])->get();
		$serkomall = SertifikatKompetensi::all();
		$serkom = SertifikatKompetensi::paginate(10);

		return view('new/pmb', compact('lembaga', 'serkom','provinsis','jenisprod','serkomall'));
	}



	//dibawah yg lama
	public function produsen()
	{
		$jenis_produsen = JenisProdusen::all();
		if (isset($_GET['jenis_produsen'])) {
			if ($_GET['jenis_produsen'] == 0) {
				$lembaga = ProdusenBenih::whereIn('jenis_lembaga_id', [2, 6, 8])->paginate(20);
				return view('/new/produsen-benih', compact('lembaga', 'jenis_produsen'));
			} else {
				$jenprod = $_GET['jenis_produsen'];
				$lembaga = ProdusenBenih::where('jenis_produsen_id', $_GET['jenis_produsen'])->whereIn('jenis_lembaga_id', [2, 6, 8])->paginate(20);
				return view('/new/produsen-benih', compact('lembaga', 'jenis_produsen', 'jenprod'));
			}
		} else {
			$lembaga = ProdusenBenih::whereIn('jenis_lembaga_id', [2, 6, 8])->paginate(20);
			return view('/new/produsen-benih', compact('lembaga', 'jenis_produsen'));
		}
	}
	public function detailprodusen($id, Request $request)
	{
		$lembaga = ProdusenBenih::where('id', $id)->first();
		$targetnya = LaporanTargetBenih::where('lembaga_id', $id)->orderByDesc('tahun')->paginate(5);
		$produksinon = LaporanProduksiSwadaya::where('lembaga_id', $id)->paginate(5);
		$berlabel = PemeriksaanTanaman::get();
		$ptmnya = LaporanBenihPTM::get();
		$serkom = SertifikatKompetensi::where('lembaga_id',$id)->get();
		return view('/new/detail/detail-produsen', compact('serkom','produksinon', 'lembaga', 'targetnya', 'berlabel', 'ptmnya'));
	}
	public function pohon()
	{
		$pohon = NomorRegistrasi::whereNotNull('lembaga_serti_id')->paginate(20);
		// $varietas = $pohon->pohoninduk->varietas->groupBy('varietas.id')->get();
		// $lemserti = $pohon->lembagasertifikasi->groupBy('lembaga_sertifikasi_id')->get();


		return view('/new/pohon-induk', compact('pohon'));
	}
	public function detailpohonkosong($id, Request $request)
	{
		$url = url('/');
		$detail = NomorRegistrasi::where('id', $id)->first();
		$laporan = KondisiPohon::where('child_pohon_induk_id', $id)->get();
		return view('/new/detail/detail-pohon-kosong', compact('detail', 'laporan', 'url'));
	}
	public function detailpohon($id, Request $request)
	{
		$url = url('/');
		$detail = NomorRegistrasi::where('id', $id)->first();
		$laporan = KondisiPohon::where('child_pohon_induk_id', $id)->get();
		return view('/new/detail/detail-pohon', compact('detail', 'laporan', 'url'));
	}
	public function benihsalur()
	{
		$benih = DB::table('label as lab')
			->select(
				'lab.id as idnya',
				'lab.lot as lotnya',
				'lab.lap_sertifikasi_benih_id',
				'ser.no_label1 as no_sertinya',
				'ser.tgl_periksa_akhir as mulai_sertinya',
				'ser.tgl_berlaku as akhir_sertinya',
				'ser.kode as kodemasternya',
				'ser.lap_benih_panen_id',
				'blab.lap_benih_panen_id',
				'plab.target_benih_id',
				'target.lembaga_id',
				'target.komoditas_id',
				'kom.nama as komod',
				'target.varietas_id',
				'var.nama_varietas as var',
				'target.kelas_benih_id',
				'kel.kelas_benih as kelasnya',
				'target.cara_id',
				'car.cara_banyak as perbanyakan',
				'target.satuan_id',
				'sat.nama_satuan as satuannya',
				'target.tanggal_r_tanam as realisasi_tanam',
				'target.tanggal_r_panen as realisasi_panen',
				'target.tanggal_r_salur as realisasi_salur',
				'target.jum_s_benih as realisasi_jum_stok',
				'target.jum_s_salur as realisasi_jum_salur',
				DB::raw('YEAR(target.tanggal_r_salur) as tahunstoknya'),
				DB::raw('concat(IFNULL(l.nama_lembaga,""),"-",IFNULL(l.nama_kepala,"")) as namanya'),
				'l.nama_kepala as kepalanya',
				'l.no_telp as notlp',
				'l1.nama_lembaga as namasertinya',
				'j.nama_jenis as jenis_pronya',
				DB::raw('IF(l.smm=1, "Ya", "Tidak") as smmnya'),
				DB::raw('IF(l.sedia_bwg_pth=1, "Bersedia", "Tidak Bersedia") as wajib'),
				DB::raw('concat(IFNULL(j.kode,""),".",IFNULL(l.provinces_id,""),".","0",IFNULL(l.smm,""),".","0",IFNULL(l.sedia_bwg_pth,""),".",IFNULL(l.id,"")) as kodenya'),
				DB::raw('concat(IFNULL(l.alamat,"")," ",IFNULL(p.name,"")," ",IFNULL(r.name,"")," ",IFNULL(d.name,"")," ",IFNULL(v.name,"")," ","RT ",IFNULL(l.rt,"")," RW ",IFNULL(l.rw,"")," kodepos ",IFNULL(l.kodepos,"")) as daerahnya')
			)
			->leftJoin('lap_sertifikasi_benih as ser', 'ser.id', '=', 'lab.lap_sertifikasi_benih_id')
			->leftJoin('lap_benih_panen as plab', 'plab.id', '=', 'ser.lap_benih_panen_id')
			->leftJoin('lap_benih_label as blab', 'blab.lap_benih_panen_id', '=', 'plab.id')
			->leftJoin('target_benih as target', 'target.id', '=', 'plab.target_benih_id')
			->leftJoin('komoditas as kom', 'kom.id', '=', 'target.komoditas_id')
			->leftJoin('varietas as var', 'var.id', '=', 'target.varietas_id')
			->leftJoin('kelas_benih as kel', 'kel.id', '=', 'target.kelas_benih_id')
			->leftJoin('cara as car', 'car.id', '=', 'target.cara_id')
			->leftJoin('satuan as sat', 'sat.id', '=', 'target.satuan_id')
			->leftJoin('lembaga as l', 'l.id', '=', 'target.lembaga_id')
			->leftJoin('lembaga as l1', 'l1.id', '=', 'l.lembaga_serti_id')
			->leftJoin('jenis_produsen as j', 'j.id', '=', 'l.jenis_produsen_id')
			->leftJoin('provinces as p', 'p.id', '=', 'l.provinces_id')
			->leftJoin('regencies as r', 'r.id', '=', 'l.regencies_id')
			->leftJoin('districts as d', 'd.id', '=', 'l.districts_id')
			->leftJoin('villages as v', 'v.id', '=', 'l.villages_id')
			->get();
		return view('/new/benih-salur', compact('benih'));
	}
	public function detailbenihsalurqr($id, Request $request)
	{
		$url = url('/');
		$detailqr = Label::where('id', $id)->first();
		return view('/new/detail/detail-benihsalur', compact('id', 'detailqr', 'url'));
	}
	public function varietasdaftar()
	{
		$vardaf = Varietas::all();
		
		return view('/new/iframe/varietas-terdaftar', compact('vardaf'));
	}
	public function varietassanggah()
	{
		$varsan = VarietasSanggah::where(function ($q) {
			$NewDate = date('Y-m-d', strtotime('tanggal_entri' . " +30 days"));
			$q->where('tanggal_entri', '<=', $NewDate);
		})->paginate(10);
		return view('/new/varietas-sanggah', compact('varsan'));
	}
	public function pemohon()
	{
		$mohon = DB::table('pemohon as p')
			->select(
				'p.id as idnya',
				'p.nama_produsen as pemohonnya',
				'pr.name as nprov',
				're.name as nkab',
				'p.alamat as alamat',
				'p.nama_kepala as ketua',
				'p.no_telp as telp'
			)
			->leftJoin('provinces as pr', 'pr.id', '=', 'p.provinces_id')
			->leftJoin('regencies as re', 're.id', '=', 'p.regencies_id')
			->get();
		return view('/new/partial/db-pemohon', compact('mohon'));
	}
	public function lapor()
	{
		$no = 1;
		if (isset($_GET['year'])) {
			$year = $_GET['year'];
		} else {
			$year = date("Y");
		}
		if (isset($_GET['jenis'])) {
			$getjenis = $_GET['jenis'];
		} else {
			$getjenis = null;
		}
		$url = url('/');
		$month = array(
			array("01-" . $year, "Januari"),
			array("02-" . $year, "Februari"),
			array("03-" . $year, "Maret"),
			array("04-" . $year, "April"),
			array("05-" . $year, "Mei"),
			array("06-" . $year, "Juni"),
			array("07-" . $year, "Juli"),
			array("08-" . $year, "Agustus"),
			array("09-" . $year, "September"),
			array("10-" . $year, "Oktober"),
			array("11-" . $year, "November"),
			array("12-" . $year, "Desember")
		);
		$user = User::paginate(10);
		return view('/new/kinerja-lapor', compact('no', 'month', 'url', 'year', 'user'));
	}
	public function detaillapor($user_id, $bulan)
	{
		$no = 1;
		$url = url('/');
		$log1 = DB::table('activity_log')
			->select(
				'activity_log.id as idpro',
				'activity_log.properties as pro',
				'activity_log.description as description',
				'activity_log.created_at as create',
				'activity_log.causer_id as idnya',
				DB::raw('DATE_FORMAT(activity_log.created_at,"%m-%Y") as bulan_tahun')
			)
			->where('activity_log.causer_id', $user_id)
			->where(DB::raw('DATE_FORMAT(activity_log.created_at,"%m-%Y")'), $bulan)
			->where('description', 'not like', '%logged%')
			->paginate(10);
		$pelapor = User::where('id', $user_id)->first();
		return view('/new/detail/detaillapor', compact('log1', 'url', 'no', 'pelapor', 'bulan', 'user_id'));
	}
	public function detailprodusennon($id)
	{
		$url = url('/');
		$datetime = date("Y_m_d");
		$no = 1;
		$label = ChildProduksiSwadaya::where('id', $id)->first();
		$child_en = json_encode($label->child_smm);
		$data_en = json_encode($label->data);
		$child = json_decode($child_en);
		$data = $label->data;
		$sert = LaporanProduksiSwadaya::where('id', $label->laporan_produksi_swadaya_id)->first();
		$lembaga_non = ProduksiBenihUmum::where('id', $sert->lembaga_id)->first();
		$nomor = SertifikatKompetensi::where('lembaga_id', $lembaga_non->id)->first();
		return view('/new/detail/detail-produsen-non', compact(
			'label',
			'url',
			'sert',
			'lembaga_non',
			'nomor',
			'child',
			'data',
			'no'
		));
	}
	public function petasebar($id)
{
    $lembaga = ProdusenBenih::find($id);
    $targetIds = LaporanTargetBenih::where('lembaga_id', $id)->pluck('id');
    
    // Retrieve PenyaluranStokBenih instances grouped by 'regencies_id' and filtered by 'target_benih_id'
    $salurbenihGroups = PenyaluranStokBenih::whereIn('target_benih_id', $targetIds)
        ->get()
        ->groupBy('regencies_id');
    
    // Retrieve all regencies' details including latitude, longitude, and name
    $regenciesDetails = DB::table('regencies')
        ->select('id', 'latitude', 'longitude', 'name')
        ->get()
        ->keyBy('id'); // Index the results by regency ID
    
    // Initialize an empty array to store regency details
    $regencies = [];
    
    // Loop through each group to fetch and store regency details
    foreach ($salurbenihGroups as $regencyId => $group) {
        // Check if regency details exist for the current regency ID
        if ($regenciesDetails->has($regencyId)) {
            // Store regency details in the array
            $regencies[$regencyId] = $regenciesDetails[$regencyId];
        }
    }
    
    return view('/new/sebarsalurindo', compact('lembaga', 'salurbenihGroups', 'regencies','targetIds'));
}


	
}
