@extends('layout/pv')
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
                    <h2>Penyebaran Varietas</h2>
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
                    <span>Sebaran Varietas Hortikultura<br>PROVINSI {{$provinsis->name}}</span>
                </div> <!-- singel counter -->
            </div>
        </div> <!-- row -->
    </div> <!-- container -->
</div>
<section id="about-page" class="pt-20 pb-80">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
            @include('peta.petadetailpv')
            </div> <!-- about cont -->
        </div> <!-- about items -->
    </div> <!-- container -->
</section>
<section>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-sm-12">
                <div class="section-title">
                    <h5>Tabel Sebaran Varietas</h5>
                </div> <!-- section title -->
            </div>
        </div> <!-- row -->
        <div class="row">
            <div class="col-lg-12 col-sm-12">
            <a href="{{url('/')}}/pv/export/varsebar_prov/{{$id}}"><button>Export Data Provinsi</button></a>
                <div class="section-title mt-50 pb-35">
                    <table id="customers">
                        <tr>
                            <th>Nama Komoditas</th>
                            <th>Nama Varietas</th>
                            <th>Tanggal Lapor Terakhir</th>
                            <th>Luasan (Hektar)</th>
                            <th>Satuan</th>
                        </tr>
                        @foreach ($lapsebaranvar as $data)
                            @php
                                $results = DB::table('varietas_sebar')
                                    ->select(DB::raw('MAX(tanggal_lapor_sebar) as max'))
                                    ->where([['varietas_id', $data->varietas_id],['provinces_id',$data->provinces_id]])
                                    ->first();

                                $jumlah = DB::table('varietas_sebar')
                                    ->select('regencies_id', DB::raw('SUM(luas_sebar) as total_luas_sebar'))
                                    ->where([['varietas_id', $data->varietas_id],['provinces_id',$data->provinces_id]])
                                    ->whereIn('tanggal_lapor_sebar', function ($query) use ($data) {
                                        $query->select(DB::raw('MAX(tanggal_lapor_sebar) as max_tanggal'))
                                            ->from('varietas_sebar')
                                            ->where([['varietas_id', $data->varietas_id],['provinces_id',$data->provinces_id]])
                                            ->groupBy('regencies_id');
                                    })
                                    ->groupBy('regencies_id')
                                    ->get();
                            @endphp
                            <tr>
                                <td>{{ $data->komoditas->nama }}</td>
                                <td>{{ $data->varietas->nama_varietas }}</td>
                                <td>{{ $results ? $results->max : 'N/A' }}</td>
                                <td>{{ $jumlah->sum('total_luas_sebar') }}</td>
                                <td>Hektar</td>
                            </tr>
                        @endforeach
                    </table>
                    {!! $lapsebaranvar->withQueryString()->links() !!}
                </div> <!-- section title -->
            </div>
        </div> <!-- row -->
    </div> <!-- container -->
</section>

<a href="#" class="back-to-top"><i class="fa fa-angle-up"></i></a>

<!--====== BACK TO TOP PART ENDS ======-->
@endsection