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
    <div class="container-fluid bg-light bg-icon my-5 py-6">
        <div class="container">
            <div class="section-header text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
                <h1 class="display-5 mb-3">PROSEED - HORTI</h1>
                <p>Digitalisasi Perbenihan Hortikultura</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="bg-white text-center h-100 p-4 p-xl-5">
                    <a class="btn" href="">
                        <img class="img-fluid mb-4" src="{{ asset('img/icon-1.png')}}" alt="">
                        <h4 class="mb-3">Produksi Dan Kelembagaan</h4>
                    </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="bg-white text-center h-100 p-4 p-xl-5">
                    <a class="btn" href="">
                        <img class="img-fluid mb-4" src="{{ asset('img/icon-3.png')}}" alt="">
                        <h4 class="mb-3">Pengawasan Mutu Benih</h4>
                    </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="bg-white text-center h-100 p-4 p-xl-5">
                    <a class="btn" href="">
                        <img class="img-fluid mb-4" src="{{ asset('img/icon-2.png')}}" alt="">
                        <h4 class="mb-3">Penyebaran Varietas</h4>
                    </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Feature End -->

    @endsection