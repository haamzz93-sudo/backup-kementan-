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

<div id="counter-part" data-overlay="8" style="background-color:#387905">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-sm-12">
                <div class="singel-counter text-center mt-40">
                    <span>Peta Sebaran Produsen Benih Hortikultura</span>
                </div> <!-- singel counter -->
            </div>
        </div> <!-- row -->
    </div> <!-- container -->
</div>

<section id="about-page" class="pt-70 pb-110">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
            @include('peta.petaprokel')
            </div> <!-- about cont -->
        </div> <!-- about items -->
    </div> <!-- container -->
</section>
<div id="counter-part" data-overlay="8" style="background-color:#387905">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-sm-12">
                <div class="singel-counter text-center mt-40">
                    <span>Data Produksi Benih Hortikultura</span>
                </div> <!-- singel counter -->
            </div>
        </div> <!-- row -->
    </div> <!-- container -->
</div>
    <div class="container">
    <div class="row">
            <div class="col-lg-12 col-sm-12">
                <div class="section-title">
                    <h5>Produksi Benih Per Produsen</h5>
                </div> <!-- section title -->
            </div>
    </div> <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <div class="table-container table-responsive table-striped display">
                    <h3 class="text-center">Produksi APBN</h3>
					 <a href="{{url('/')}}/prokel/export/varprod_nas"><button>Export Data Nasional</button></a>
                    <table id="customers">
                    <thead class="garis text-center">
                    <tr>
                      <th class="garis text-center" rowspan="2">TAHUN TARGET PRODUKSI</th>
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
                  </thead>
                  <tbody>
                  @foreach($targetnya as $target)
                    @if(optional($target->lembaga)->jenis_produsen_id == 4 && isset($target->lembaga->nama_lembaga) && $target->status!="tolak")
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
                      <td class="garis text-center"><a href="{{url('/')}}/detail-produsen/{{$target->lembaga->id}}">Lihat Detail</a></td>
                    </tr>
                    @endif
                    @endforeach
                  </tbody>
                    </table>
                    <div style="">
                    {!! $targetnya->withQueryString()->links() !!}
                    </div>
                </div>
            </div>
            <div class="col-md-12" style="display:none">
                <div class="table-container table-responsive table-striped display">
                    <h3 class="text-center">Produksi NON APBN</h3>
					<a href="{{url('/')}}/prokel/non/export/varprod_nas"><button>Export Data Nasional</button></a>
                    <table id="customers">
                    <thead class="garis text-center">
                    <tr>
                      <th class="garis text-center" rowspan="2">KODE PRODUSEN</th>
                      <th class="garis text-center" rowspan="2">JENIS PRODUSEN</th>
                      <th class="garis text-center" rowspan="2">NAMA PRODUSEN</th>
                      <th class="garis text-center" rowspan="2">NAMA PROVINSI</th>
                      <th class="garis text-center" rowspan="2">NAMA KABUPATEN</th>
                      <th class="garis text-center" rowspan="2">NAMA KECAMATAN</th>
                      <th class="garis text-center" rowspan="2">NAMA DESA</th>
                      <th class="garis text-center" rowspan="2">ALAMAT</th>
                      <th class="garis text-center" rowspan="2">KOMODITAS - VARIETAS</th>
                      <th class="garis text-center" rowspan="2">SATUAN</th>
                      <th class="garis text-center" rowspan="2">JUMLAH PRODUKSI</th>
                      <th class="garis text-center" rowspan="2">JUMLAH PENYALURAN</th>
                      <th class="garis text-center" rowspan="2">STOK SAAT INI</th>
                      <th class="garis text-center" rowspan="2">DETAIL PRODUSEN</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($nonapbn as $non)
                    <tr>
                    <td class="garis text-center">{{$non->produksiumum->kode_produsen ?? 'Belum Ada Kode'}}</td>
                    <td class="garis text-center">{{$non->produksiumum->jenis_produsen->nama_jenis ?? 'Belum Ada Jenis'}}</td>
                    <td class="garis text-center">{{$non->produksiumum->nama_lembaga ?? 'Belum Ada Data'}}</td>
                    <td class="garis text-center">{{$non->produksiumum->provinces->name ?? 'Provinsi Belum Diisi'}}</td>
                    <td class="garis text-center">{{$non->produksiumum->regencies->name ?? 'Kabupaten Belum Diisi'}}</td>
                    <td class="garis text-center">{{$non->produksiumum->districts->name ?? 'Kecamatan Belum Diisi'}}</td>
                    <td class="garis text-center">{{$non->produksiumum->villages->name ?? 'Desa Belum Diisi'}}</td>
                    <td class="garis text-center">{{$non->produksiumum->alamat ?? 'Alamat Belum Diisi'}}</td>
                    <td class="garis text-center">{{$non->komoditas->nama}} - {{$non->varietas->nama_varietas ?? 'Varietas Tidak Dipilih'}}</td>
                    <td class="garis text-center">{{$non->satuan->nama_satuan}}</td>
                    <td class="garis text-center">{{number_format(($non->childproduksiswadaya->sum('produksi_benih')),0,",",".")}} {{$non->satuan->nama_satuan}}</td>
                    <td class="garis text-center">{{number_format(($non->childproduksiswadaya->sum('salur_benih')),0,",",".")}} {{$non->satuan->nama_satuan}}</td>
                    <td class="garis text-center">{{number_format(($non->childproduksiswadaya->sum('produksi_benih')-$non->childproduksiswadaya->sum('salur_benih')),0,",",".")}} {{$non->satuan->nama_satuan}}</td>     
                    <td class="garis text-center"><a href="{{url('/')}}/detail-produsen/{{$non->lembaga_id}}">Lihat Detail</a></td>
                </tr>
                    @endforeach
                  </tbody>
                    </table>
                    <div style="">
                    {!! $nonapbn->withQueryString()->links() !!}
                    </div>
                </div>
            </div>
        </div> <!-- row -->
    </div> <!-- container -->

<!--====== TEACHERS PART ENDS ======-->

<!--====== BACK TO TOP PART START ======-->

<a href="#" class="back-to-top"><i class="fa fa-angle-up"></i></a>

<!--====== BACK TO TOP PART ENDS ======-->
@endsection