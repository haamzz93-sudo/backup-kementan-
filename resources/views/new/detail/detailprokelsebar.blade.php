@extends('layout/prokel')
@section('title')
HOMEPAGE PROSEED
@endsection
@section('meta')
<meta charset="utf-8" />
<meta name="keywords" content="Homepage PROSEED">
<meta property="og:url" content="" />
<meta property="og:type" content="article" />
<meta property="og:title" content="HOMEPAGE PROSEED" />
<meta property="og:description" content="" />
<meta property="og:image" content="" />
<meta name="csrf-token" content="" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
@endsection

@section('content')
<!--====== PAGE BANNER PART START ======-->
<style>
    #customers {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    #customers td,
    #customers th {
        border: 1px solid #ddd;
        padding: 8px;
    }

    #customers tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    #customers tr:hover {
        background-color: #ddd;
    }

    #customers th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #04AA6D;
        color: white;
    }
    [data-ml-modal] {
	position:fixed;
	top:0;
	bottom:0;
	left:0;
	right:0;
	overflow-x:hidden;
	overflow-y:auto;
	-webkit-overflow-scrolling:touch;
	z-index:999;
	width:0;
	height:0;
	opacity:0;
}
[data-ml-modal]:target {
	width:auto;
	height:auto;
	opacity:1;
	-webkit-transition:  opacity 1s ease;
	transition: opacity 1s ease;
}
[data-ml-modal]:target .modal-overlay {
	position:fixed;
	top:0;
	bottom:0;
	left:0;
	right:0;
	cursor:pointer;
	background-color:#000;
	background-color:rgba(0, 0, 0, 0.7);
	z-index:1;
}
[data-ml-modal] .modal-dialog {
	border-radius:6px;
	box-shadow:0 11px 15px -7px rgba(0, 0, 0, 0.2), 0 24px 38px 3px rgba(0, 0, 0, 0.14), 0 9px 46px 8px rgba(0, 0, 0, 0.12);
	position:relative;
	width: 90%;
	max-width:660px;
	max-height:70%;
	margin:10% auto;
	overflow-x:hidden;
	overflow-y:auto;
	z-index:2;
}
.modal-dialog-lg {max-width:820px !important;}

[data-ml-modal] .modal-dialog > h3 {
	background-color:#eee;
	border-bottom:1px solid #b3b3b3;
	font-size:24px;
	font-weight: 400;
	margin:0;
	padding:0.8em 56px .8em 27px; 
}
[data-ml-modal] .modal-content {background:#fff; padding:23px 27px;}
[data-ml-modal] .modal-close {
  	position:absolute;
	top:13px;
	right:13px;
	color:#0085a6;
	background-color:#fff;
	border-radius:50%;
	height:40px;
	width:40px;
	font-size:30px;
	line-height:37px;
	text-align:center;
	-webkit-transition: all .3s ease-in-out;
    transition: all .3s ease-in-out;
}
[data-ml-modal] .modal-close:hover {background-color:#0085a6; color:#fff; cursor:pointer;}
[data-ml-modal] p:first-child, [data-ml-modal] p:last-child {margin:0;}
@media (max-width:767px) {
	[data-ml-modal] .modal-dialog {margin:20% auto;}
}
/* End Modals ------------------------------*/
</style>

<section id="page-banner" class="pt-105 pb-110 bg_cover" data-overlay="8" style="background-image: url('{{ asset('frontend/images/slider/s-1.jpg') }}')">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-banner-cont">
                    <h2>Produksi Dan Kelembagaan</h2>
                </div> <!-- page banner cont -->
            </div>
        </div> <!-- row -->
    </div> <!-- container -->
</section>

<!--====== PAGE BANNER PART ENDS ======-->

<!--====== ABOUT PART START ======-->
<div id="counter-part" data-overlay="8" style="background-color:#387905">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-sm-12">
                <div class="singel-counter text-center mt-40">
                    <span>Produksi dan Kelembagaan Hortikultura<br>PROVINSI {{$provinsis->name}}</span>
                </div> <!-- singel counter -->
            </div>
        </div> <!-- row -->
    </div> <!-- container -->
</div>
<section id="about-page" class="pt-20 pb-80">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
            @include('peta.petadetailprokel')
            </div> <!-- about cont -->
        </div> <!-- about items -->
    </div> <!-- container -->
</section>
<section id="about-page" class="pt-20 pb-80">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
            </div> <!-- about cont -->
        </div> <!-- about items -->
    </div> <!-- container -->
</section>
<section>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-sm-12">
                <div class="section-title">
                    <h5>Tabel Produksi APBN</h5>
                </div> <!-- section title -->
            </div>
        </div> <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <div class="table-container table-responsive table-striped display">
                    <h3 class="text-center">Produksi APBN</h3>
                    <table id="customers">
                    <thead class="garis text-center">
                    <tr>
                      <th class="garis text-center" rowspan="2">TAHUN TARGET PRODUKSI</th>
                      <th class="garis text-center" rowspan="2">ID PRODUSEN</th>
                      <th class="garis text-center" rowspan="2">KODE PRODUSEN</th>
                      <th class="garis text-center" rowspan="2">JENIS PRODUSEN</th>
                      <th class="garis text-center" rowspan="2">NAMA PRODUSEN</th>
                      <th class="garis text-center" rowspan="2">NAMA PROVINSI</th>
                      <th class="garis text-center" rowspan="2">NAMA KABUPATEN</th>
                      <th class="garis text-center" rowspan="2">NAMA KECAMATAN</th>
                      <th class="garis text-center" rowspan="2">NAMA DESA</th>
                      <th class="garis text-center" rowspan="2">ALAMAT</th>
                      <th class="garis text-center" rowspan="2">LOKASI PRODUKSI</th>
                      <th class="garis text-center" rowspan="2">KOMODITAS - VARIETAS</th>
                      <th class="garis text-center" rowspan="2">TARGET PRODUKSI</th>
                      <th class="garis text-center" rowspan="2">TARGET SALUR</th>
                      <th class="garis text-center" colspan="4">PROSES PERBANYAKAN</th>
                      <th class="garis text-center" colspan="4">MENCAPAI PTM</th>
                      <th class="garis text-center" colspan="4">SIAP SALUR</th>
                      <th class="garis text-center" rowspan="2">TERSALUR</th>
                      <th class="garis text-center" rowspan="2">KINERJA PENYALURAN</th>
                      <th class="garis text-center" rowspan="2">SISA STOK</th>
                      <th class="garis text-center" rowspan="2">STATUS</th>
                      <th class="garis text-center" rowspan="2">LIHAT DETAIL PRODUSEN</th>
                    </tr>
                    <tr class="garis text-center">
                      <th class="garis text-center">BERHASIL</th>
                      <th class="garis text-center">GAGAL</th>
                      <th class="garis text-center">BELUM DIPROSES</th>
                      <th class="garis text-center">KINERJA PERBANYAKAN</th>
                      <th class="garis text-center">BERHASIL</th>
                      <th class="garis text-center">GAGAL</th>
                      <th class="garis text-center">BELUM PTM</th>
                      <th class="garis text-center">KINERJA PTM</th>
                      <th class="garis text-center">BERLABEL</th>
                      <th class="garis text-center">PENGURANGAN BERLABEL</th>
                      <th class="garis text-center">BELUM BERLABEL</th>
                      <th class="garis text-center">KINERJA BERLABEL</th>
                    </tr>
                  @foreach($targetnya as $target)
                  @if (optional($target->lembaga)->jenis_produsen_id == 4 && isset($target->lembaga->nama_lembaga) && $target->status != "tolak" && $target->lembaga->provinces_id == $id)
                    @php
                    $jumlah = DB::table('target_benih')
                    ->join('lap_benih_panen','lap_benih_panen.target_benih_id','target_benih.id')
                    ->join('lap_benih_label','lap_benih_label.lap_benih_panen_id','lap_benih_panen.id')
                    ->where('target_benih.id',$target->id)
                    ->sum('jumlah_lanjut');
                    @endphp
                    <!--Lokasi Produksi-->
                    <tr>
                    <td class="garis text-center">{{$target->tahun}}</td>
                    <td class="garis text-center">{{$target->lembaga->id}}</td>
                    <td class="garis text-center">{{$target->lembaga->kode_produsen ?? 'Belum Ada Kode'}}</td>
                    <td class="garis text-center">{{$target->lembaga->jenisprodusen->nama_jenis ?? 'Belum Ada Jenis'}}</td>
                    <td class="garis text-center">{{$target->lembaga->nama_lembaga}}</td>
                    <td class="garis text-center">{{$target->lembaga->provinces->name ?? 'Provinsi Belum Diisi'}}</td>
                    <td class="garis text-center">{{$target->lembaga->regencies->name ?? 'Kabupaten Belum Diisi'}}</td>
                    <td class="garis text-center">{{$target->lembaga->districts->name ?? 'Kecamatan Belum Diisi'}}</td>
                    <td class="garis text-center">{{$target->lembaga->villages->name ?? 'Desa Belum Diisi'}}</td>
                    <td class="garis text-center">{{$target->lembaga->alamat ?? 'Alamat Belum Diisi'}}</td>
                    <td class="garis text-center">{{$target->lokasiproduksidetail->alamat ?? 'Alamat Tidak Diisi'}}</td>
                    
                    <td class="garis text-center">{{$target->komoditas->nama}} - {{$target->varietas->nama_varietas ?? 'Varietas Tidak Dipilih'}}</td>
                    <td class="garis text-center">{{number_format($target->jum_target,0,",",".")}} {{$target->satuan->nama_satuan}}</td>
                    <td class="garis text-center">{{number_format($target->targetsalur->sum('jumlah'),0,",",".")}} {{$target->satuan->nama_satuan}}</td>
                    
                    <!--Proses Perbanyakan Berhasil-->
                    <td class="garis text-center">{{number_format(($target->produksi->sum('pengadaan_benih')-$target->produksimati->sum('produksi_mati')),0,",",".")}} {{$target->satuan->nama_satuan}}</td>

                    <!--Proses Perbanyakan Gagal-->
                    <td class="garis text-center">{{number_format($target->produksimati->sum('produksi_mati'),0,",",".")}} {{$target->satuan->nama_satuan}}</td>
                    <!-- bELUM PROSES -->
                    <td class="garis text-center">{{number_format(($target->jum_target-$target->produksi->sum('pengadaan_benih')+$target->produksimati->sum('produksi_mati')),0,",",".")}} {{$target->satuan->nama_satuan}}</td>
                    
                    <!--Kinerja Perbanyakan-->
                    <td class="garis text-center">
                        @if(($target->produksi->sum('pengadaan_benih')-$target->produksimati->sum('produksi_mati'))>0 )
                        {{number_format((($target->produksi->sum('pengadaan_benih')-$target->produksimati->sum('produksi_mati'))*100/$target->jum_target),0,",",".")."%"}}
                        
                        @else
                        Belum Ada Pelaporan
                        @endif
                        </td>
                    <!--PTM Berhasil-->
                    <td class="garis text-center">{{number_format(($target->ptm->sum('jum_panen')-$target->ptmmati->sum('label_mati')),0,",",".")}} {{$target->satuan->nama_satuan}}</td>
                    <!--PTM Gagal-->
                    <td class="garis text-center">{{number_format($target->ptmmati->sum('label_mati'),0,",",".")}} {{$target->satuan->nama_satuan}}</td>
                    <!-- BELUM PTM -->
                    <td class="garis text-center">{{number_format(($target->produksi->sum('pengadaan_benih')-$target->produksimati->sum('produksi_mati')-$target->ptm->sum('jum_panen')+$target->ptmmati->sum('label_mati')))}} {{$target->satuan->nama_satuan}}</td>
                    <!--Proses Kinerja PTM-->
                    <td class="garis text-center">
                        @if(($target->ptm->sum('jum_panen')-$target->ptmmati->sum('label_mati'))>0)
                        {{number_format((($target->ptm->sum('jum_panen')-$target->ptmmati->sum('label_mati'))*100/$target->jum_target),0,",",".")."%"}}
                        @else
                        Belum Ada Pelaporan
                        @endif
                        </td>
                    <!--Siap Salur Berlabel-->
                    <td class="garis text-center">{{number_format(($jumlah-$target->penguranganstok->sum('jumlah')),0,",",".")}} {{$target->satuan->nama_satuan}}</td>
                    <!--Siap Salur Mati Berlabel-->
                    <td class="garis text-center">{{number_format($target->penguranganstok->sum('jumlah'),0,",",".")}} {{$target->satuan->nama_satuan}}</td>
                    <!--Siap Salur belum Berlabel-->
                    <td class="garis text-center">{{number_format(($target->ptm->sum('jum_panen')-$target->ptmmati->sum('label_mati')-$jumlah),0,",",".")}} {{$target->satuan->nama_satuan}}</td>
                    <!--Proses Kinerja Berlabel-->
                    <td class="garis text-center">
                        @if(($jumlah-$target->penguranganstok->sum('jumlah'))>0)
                        {{number_format((($jumlah-$target->penguranganstok->sum('jumlah'))*100/$target->jum_target),0,",",".")."%"}}
                        @else
                        Belum Ada Pelaporan
                        @endif</td>
                    <!--tersalur-->
                    <td class="garis text-center">{{number_format($target->penyaluranstok->sum('jumlah'),0,",",".")}} {{$target->satuan->nama_satuan}}</td>
                    <!--Kinerja tersalur-->
                    <td class="garis text-center">
                        @if(($target->penyaluranstok->sum('jumlah'))>0)
                        {{number_format((($target->penyaluranstok->sum('jumlah'))*100/$target->jum_target),0,",",".")."%"}}
                        @else
                        Belum Ada Pelaporan
                        @endif
                        </td>
                    <!--stok-->
                    <td class="garis text-center">{{number_format(($jumlah-$target->penguranganstok->sum('jumlah')-$target->penyaluranstok->sum('jumlah')),0,",",".")}} {{$target->satuan->nama_satuan}}</td>
                    <td class="garis text-center">
                      @if($target->status=="active")
                      Terverifikasi
                      @elseif($target->status=="pending")
                      Diajukan Ulang
                      @elseif($target->status=="tolak")
                      Ditolak dengan keterangan {{$target->keterangan}}
                      @elseif($target->status=="selesai")
                      Target Selesai
                      @else
                      Diajukan
                      @endif</td>
                      <td class="garis text-center"><a href="https://benih.pertanian.go.id/detail-produsen/{{$target->lembaga->id}}">Lihat Detail</a></td>
                    </tr>
                    @endif
                    @endforeach
                    </table>
                </div> <!-- section title -->
            </div>
        </div> <!-- row -->
    </div> <!-- container -->
</section>

<a href="#" class="back-to-top"><i class="fa fa-angle-up"></i></a>

<!--====== BACK TO TOP PART ENDS ======-->
@endsection