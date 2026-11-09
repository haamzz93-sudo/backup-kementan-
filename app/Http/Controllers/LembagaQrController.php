<?php

namespace App\Http\Controllers;
use DB;
use App\Models\Label;
use App\Models\LaporanSertifikasiBenih;
use App\Models\LaporanBenihPTM;
use App\Models\LaporanTargetBenih;
use App\Models\Komoditas;
use App\Models\Varietas;
use App\Models\Provinces;
use App\Models\Cara;
use App\Models\ChildProduksiSwadaya;
use App\Models\FormLabel;
use App\Models\ProdusenBenih;
use App\Models\KelasBenih;
use App\Models\LaporanProduksiSwadaya;
use App\Models\LaporanSertifikasiNonAPBN;
use App\Models\LembagaSertifikasi;
use App\Models\PemeriksaanTanaman;
use App\Models\ProduksiBenihUmum;
use App\Models\QRNon;
use App\Models\SertifikasiNonAPBN;
use App\Models\SertifikatKompetensi;
use App\Models\JenisLembaga;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Dompdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Http\Request;

class LembagaQrController extends Controller
{
    public function generateInvoice($id)
    {
        $url = url('/');
		$induk = DB::table('lembaga as l')
		->select('l.id as idnya','l.nama_lembaga as namanya', DB::raw('concat(IFNULL(j.kode,""),".",IFNULL(l.provinces_id,""),".","0",IFNULL(l.smm,""),".","0",IFNULL(l.sedia_bwg_pth,""),".",IFNULL(l.id,"")) as kodenya'))
		->Join('jenis_produsen as j', 'j.id', '=', 'l.jenis_produsen_id')
		->where('l.id', $id)
		->get();

        $pdf = PDF::loadView('admin_lembaga', compact('induk','url'))->setPaper('a4', 'potrait');
        return $pdf->stream();
    }
    public function PohonQr($id)
    {
         $url = url('/');
		$induk = DB::table('pohon_induk')
		->select('*')
		->Join('varietas', 'varietas.id', '=', 'pohon_induk.varietas_id')
		->Join('pemilik_pohon', 'pemilik_pohon.id', '=', 'pohon_induk.pemilik_pohon_id')
		->Join('komoditas', 'komoditas.id', '=', 'pohon_induk.komoditas_id')
		->Join('kelas_benih', 'kelas_benih.id', '=', 'pohon_induk.kelas_benih_id')
		->where('pohon_induk.id', $id)
		->first();
		$reg = DB::table('child_pohon_induk')
		->select('*','child_pohon_induk.id as idnyo')
		->Join('pohon_induk', 'pohon_induk.id', '=', 'child_pohon_induk.pohon_induk_id')
		->where('child_pohon_induk.pohon_induk_id', $id)
		->get();
        $pdf = PDF::loadView('admin_pohon', compact('induk','reg','url'))->setPaper('a4', 'potrait');
        return $pdf->stream();
    }
	public function LabelQr($id)
    {
		$url = url('/');
		$datetime = date("Y_m_d");
		$label = Label::where('id',$id)->first();
		$sertibenih = LaporanSertifikasiBenih::where('id',$label->lap_sertifikasi_benih_id)->first();
		$panen = LaporanBenihPTM::where('id',$sertibenih->lap_benih_panen_id)->first();
		$target = LaporanTargetBenih::where('id',$panen->target_benih_id)->first();
		$komoditas = Komoditas::where('id',$target->komoditas_id)->first();
		$word = "Jeruk";
		$cara = Cara::where('id',$target->cara_id)->first();
		$kelas = KelasBenih::where('id',$target->kelas_benih_id)->first();
		$lembaga = ProdusenBenih::where('id',$target->lembaga_id)->first();
		$lembagaser = ProdusenBenih::where('id',$lembaga->lembaga_serti_id)->first();
		$provinsi = Provinces::where('id',$lembaga->provinces_id)->first();
		$varietasatas = Varietas::where('id',$target->varietas_id)->first();
		$varietasbwh = Varietas::where('id',$label->varietas_id)->first();
		$periksa = PemeriksaanTanaman::where('lap_benih_panen_id',$panen->id) ->orderBy('tanggal_lapor', 'desc')->first();
		$induk_en = json_encode($target->no_induk);
		$induk = json_decode($induk_en);

        $pdf = PDF::loadView('admin_label', compact(
			'label',
			'url',
			'sertibenih',
			'panen',
			'target',
			'komoditas',
			'cara',
			'kelas',
			'lembaga',
			'lembagaser',
			'provinsi',
			'varietasatas',
			'varietasbwh',
			'periksa',
			'word',
			'induk_en',
			'induk'
			))->setPaper('a4', 'potrait');
		
        return $pdf->stream('labeling'.$datetime.'_'.$id.'.pdf');
		}
		public function Qr($id)
    {
		$url = url('/');
		$datetime = date("Y_m_d");
		$label = Label::where('id',$id)->first();
		$sertibenih = LaporanSertifikasiBenih::where('id',$label->lap_sertifikasi_benih_id)->first();
		$panen = LaporanBenihPTM::where('id',$sertibenih->lap_benih_panen_id)->first();
		$target = LaporanTargetBenih::where('id',$panen->target_benih_id)->first();
		$komoditas = Komoditas::where('id',$target->komoditas_id)->first();
		$word = "Jeruk";
		$cara = Cara::where('id',$target->cara_id)->first();
		$kelas = KelasBenih::where('id',$target->kelas_benih_id)->first();
		$lembaga = ProdusenBenih::where('id',$target->lembaga_id)->first();
		$lembagaser = ProdusenBenih::where('id',$lembaga->lembaga_serti_id)->first();
		$provinsi = Provinces::where('id',$lembaga->provinces_id)->first();
		$varietasatas = Varietas::where('id',$target->varietas_id)->first();
		$varietasbwh = Varietas::where('id',$label->varietas_id)->first();
		$periksa = PemeriksaanTanaman::where('lap_benih_panen_id',$panen->id) ->orderBy('tanggal_lapor', 'desc')->first();
		$induk_en = json_encode($target->no_induk);
		$induk = json_decode($induk_en);
        $pdf = PDF::loadView('admin_qrlabel', compact(
			'label',
			'url',
			'sertibenih',
			'panen',
			'target',
			'komoditas',
			'cara',
			'kelas',
			'lembaga',
			'lembagaser',
			'provinsi',
			'varietasatas',
			'varietasbwh',
			'periksa',
			'word',
			'induk_en',
			'induk'
			))->setPaper($customPaper, 'landscape');
		
        return $pdf->stream('labeling'.$datetime.'_'.$id.'.pdf');

	}
	public function Qrnon($id)
{
    $url = url('/');
    $datetime = date("Y_m_d");
    $use = auth()->user()->id;
    $label = ChildProduksiSwadaya::where('id', $id)->first();
    $user = User::where('id', $use)->first();
    $logo = LembagaSertifikasi::select('logo')->where('id', $user->lembaga_id)->first();
    $sert = LaporanProduksiSwadaya::where('id', $label->laporan_produksi_swadaya_id)->first();
    $lembaga_non = ProduksiBenihUmum::where('id', $sert->lembaga_id)->first();
    $jenis = JenisLembaga::where('id',$lembaga_non->jenis_lembaga_id)->first();
    $nomor = SertifikatKompetensi::where('lembaga_id', $lembaga_non->id)->first();
    
    // Define custom paper size in points (3 cm = 85.03937 points)
    $customPaper = array(0, 0, 150, 150);
    
    if (null !== $logo) {
        $logoa = "/storage/app/public/" . $logo->logo;
    } else {
        $logoa = "/public/frontend/images/kementan.png";
    }

    $pdf = PDF::loadView('admin_qrnon', compact(
        'user',
        'id',
        'logoa',
        'label',
        'url',
        'sert',
        'lembaga_non',
        'nomor',
        'logo',
        'jenis'
    ))
    ->setPaper($customPaper, 'landscape');
    
    return $pdf->stream('qrnon' . $datetime . '_' . $id . '.pdf');
}

	public function labelnons($id)
    {
		$url = url('/');
		$use = auth()->user()->id;
		$user = User::where('id',$use)->first();
		$datetime = date("Y_m_d");
		$no = 1;
		$label = ChildProduksiSwadaya::where('id', $id)->first();
		$child_en = json_encode($label->child_smm);
		$data_en = json_encode($label->data);
		$child = json_decode($child_en);
		$data = $label->data;
		$sert = LaporanProduksiSwadaya::where('id', $label->laporan_produksi_swadaya_id)->first();
		$lembaga_non = ProduksiBenihUmum::where('id', $sert->lembaga_id)->first();
		$lembaga_sert = null;

		if ($lembaga_non && $lembaga_non->lembaga_serti_id) {
			$lembaga_sert = ProduksiBenihUmum::where('id', $lembaga_non->lembaga_serti_id)->first();
		}

		// Correct condition: OR instead of AND
		if (in_array($lembaga_non->jenis_lembaga_id, [2, 6, 8])) {
			$logo = $lembaga_non->logo;
			$stempel = $lembaga_non->stempel;
		} else {
			// Safeguard against null
			$logo = $lembaga_sert?->logo;
			$stempel = $lembaga_sert?->stempel;
		}
		$nomor = SertifikatKompetensi::where('lembaga_id', $lembaga_non->id)->first();
		$komoditas = Komoditas::where('id', $sert->komoditas_id)->first();
		$word = "Jeruk";
		$master_label = FormLabel::where('cara_id',$sert->cara_id)->first();
		$m_label = $master_label->json_form;
		$filteredArray2 = array_filter($m_label, function($item) {
			return isset($item['data_label']) && $item['data_label'] === true;
		});
	
		
		usort($filteredArray2, function($a, $b) {
			return intval($a['urut']) - intval($b['urut']);
		});
		
		$array1Object = $data[0];
		$result = array_map(function($item) use ($array1Object) {
			return ['key' => $item['key'], 'value' => $array1Object[$item['key']]];
		}, $filteredArray2);

		if(null!==$logo){
			$logoa = "/storage/app/public/".$logo;
			$path1 = storage_path('app/public/'.$logo);
		}else{
			$logoa = "/public/frontend/images/kementan.png";
			$path1 = public_path('frontend/images/kementan.png');
		}

		if(null!==$stempel){
			$logob = "/storage/app/public/".$stempel;
			$path2 = storage_path('app/public/'.$stempel);
		}else{
			$logob = "/public/frontend/images/kementan.png";
			$path2 = public_path('frontend/images/kementan.png');
		}

        $pdf = new Dompdf();
        	$pdf = PDF::loadView('admin_labelnon', compact(
            'id',
            'label',
            'url',
            'sert',
            'path1',
            'logoa',	
            'lembaga_non',
            'nomor',
            'child',
            'data',
            'no',
            'master_label',
            'm_label',
            'result',
            'path2',
            'logob',
			'komoditas',
			'word'
        ));
        
        $pdf->setPaper([0, 0, 283.5, 130.41], 'portrait'); // Adjust dimensions as needed
        
        return $pdf->stream('labelnon'.$datetime.'_'.$id.'.pdf');

	}
}
