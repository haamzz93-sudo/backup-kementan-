@extends('app')
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


    <!-- Feature Start -->
    <div class="container-fluid bg-light my-0 py-6">
        <div class="container">
            <div class="section-header text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
                <h3 class="display-7 mb-3">Pengawasan Mutu Benih</h3>
                </div>
            <div class="row g-4">
            @include('peta.petapmb')
            </div>
        </div>
    </div>
    <!-- Feature End -->

    <!-- Firm Visit Start -->
    <div class="container-fluid bg-warning bg-icon mt-0 py-6">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-md-12 wow fadeIn" data-wow-delay="0.1s">
                    <h4 class="text-center display-8 text-white mb-3">JUMLAH SERTIFIKAT KOMPETENSI YANG SUDAH DIKELUARKAN</h4>
                    <p class="text-center text-white mb-0">Berdasarkan Status</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Firm Visit End -->


    <!-- Testimonial Start -->
    <div class="container-fluid bg-light bg-icon py-6 mb-0">
        <div class="container">
            <div class="section-header text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
                <h3 class="display-7 mb-3">TABEL DAFTAR SERTIFIKAT KOMPETENSI</h3>
            </div>
            <div class="row g-5 align-items-center">
                <div class="col-lg-12 col-md-12 col-xs-12 wow fadeIn" data-wow-delay="0.5s">
                
                </div>
            </div>
        </div>
    </div>
    <!-- Testimonial End -->


    @endsection