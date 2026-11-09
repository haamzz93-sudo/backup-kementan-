@extends('layout/pmb')
@section('title')
	HOMEPAGE PROSEED
@endsection
@section('meta')
	<meta charset="utf-8" />
	<meta name="keywords" 				   content="Homepage PROSEED">
	<meta property="og:url"                content="" />
	<meta property="og:type"               content="article" />
	<meta property="og:title"              content="HOMEPAGE PROSEED" />
	<meta property="og:description"        content="" />
	<meta property="og:image"              content="" />
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
    <section id="page-banner" class="pt-105 pb-110 bg_cover" data-overlay="8" style="background-image: url('{{ asset('frontend/images/page-banner-1.jpg') }}')">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="page-banner-cont">
                        <h2>Pengawasan Mutu Benih</h2>   
                    </div>  <!-- page banner cont -->
                </div>
            </div> <!-- row -->
        </div> <!-- container -->
    </section>
    <div id="counter-part" data-overlay="8" style="background-color:#387905">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-sm-12">
                <div class="singel-counter text-center mt-40">
                    <span>Peta Sebaran Sertifikat Kompetensi Produsen Benih Hortikultura</span>
                </div> <!-- singel counter -->
            </div>
        </div> <!-- row -->
    </div> <!-- container -->
</div>
    <!--====== PAGE BANNER PART ENDS ======-->
   
    <!--====== ABOUT PART START ======-->
    
    <section id="about-page" class="pt-70 pb-110">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
            @include('peta.petapmb')
            </div> <!-- about cont -->
        </div> <!-- about items -->
    </div> <!-- container -->
</section>
<div id="counter-part" data-overlay="8" style="background-color:#387905">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-sm-12">
                <div class="singel-counter text-center mt-40">
                    <span>Data Sertifikat Kompetensi Produsen Benih Hortikultura</span>
                </div> <!-- singel counter -->
            </div>
        </div> <!-- row -->
    </div> <!-- container -->
</div>
<div class="container">
    <div class="row">
            <div class="col-md-12">
                <div class="table-container table-responsive table-striped display">
                    <h3 class="text-center">SERTIFIKAT KOMPETENSI PRODUSEN BENIH</h3>
                    <table id="customers">
                    <thead class="garis text-center">
                    <tr>
                      <th class="garis text-center">NOMOR SERTIFIKAT KOMPETENSI</th>
                      <th class="garis text-center">NAMA PRODUSEN</th>
                      <th class="garis text-center">PROVINSI</th>
                      <th class="garis text-center">ALAMAT</th>
                      <th class="garis text-center">JENIS KOMPETENSI</th>
                      <th class="garis text-center">TANGGAL PENETAPAN SERTIFIKAT KOMPETENSI AWAL</th>
                      <th class="garis text-center">BERLAKU HINGGA</th>
                      <th class="garis text-center">PERPANJANGAN</th>
                      <th class="garis text-center">STATUS</th>
                      <th class="garis text-center">LIHAT DETAIL PRODUSEN</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($serkom as $ser)
                    @if(isset($ser->produsenbenih))
                 <tr>
                    <td>{{$ser->no_serti}}</td>
                    <td>{{$ser->produsenbenih->nama_lembaga ?? 'Kesalahan dalam Pengisian Data'}}</td>
                    <td>{{$ser->produsenbenih->provinces->name ?? 'Kesalahan dalam Pengisian Data'}}</td>
                    <td>{{$ser->produsenbenih->alamat ?? 'Kesalahan dalam Pengisian Data'}}</td>
                    @php
                    $col = collect($ser->jenis_kompetensi);
                    $array = $col->toArray();
                    $string = implode(', ', $array);
                    @endphp
                    <td>{{$string ?? 'Kesalahan dalam Pengisian Data'}}</td>
                    <td>{{$ser->tgl_awal}}</td>
                    <td>@php
                    $tgl_akhir = $ser->tgl_akhir;
                    $panjang =  $ser->perpanjangansmm->where('child_smm_id',$ser->id)->sortByDesc('tgl_perpanjangan')->first();
                    if($panjang){
                    $tglakhirp = $panjang->tgl_berlaku;
                    
                        echo $tglakhirp;
                    }else{
                        echo $tgl_akhir;
                    }
                        @endphp
                    </td>
                    <td>{{$ser->perpanjangansmm->count() }}</td>
                    <td>
                    @php
                    $now = date("Y-m-d");
                    $tgl_akhir = $ser->tgl_akhir;
                    $panjang =  $ser->perpanjangansmm->where('child_smm_id',$ser->id)->sortByDesc('tgl_perpanjangan')->first();
                    if($panjang){
                    $tglakhirp = $panjang->tgl_berlaku;
                    if($now>$tglakhirp){
                        echo "Tidak Berlaku";
                    }else{
                        echo "Berlaku";
                    }
                    }else{
                        if($now>$tgl_akhir){
                            echo "Tidak Berlaku" ;
                        }else{
                            echo "Berlaku";
                        }
                    }
                    @endphp

                    </td>
                    <td><a href="">Detail</a></td>
                 </tr>
                 @endif
                 @endforeach
                  </tbody>
                    </table>
                    {!! $serkom->withQueryString()->links() !!}
                    <div style="">
                    <!-- pagination -->
                    </div>
                </div>
            </div>
           
        </div>
        </div> <!-- row -->
    
    <!--====== TEACHERS PART ENDS ======-->
   
    <!--====== BACK TO TOP PART START ======-->
    
    <a href="#" class="back-to-top"><i class="fa fa-angle-up"></i></a>
    
    <!--====== BACK TO TOP PART ENDS ======-->
@endsection