@extends('layouts/base')
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
<section id="page-banner" class="pt-105 pb-110 bg_cover" data-overlay="8" style="background-image: url('{{ asset('frontend/images/page-banner-1.jpg') }}')">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-banner-cont">
                    <h2>Varietas Terdaftar</h2>
                </div> <!-- page banner cont -->
            </div>
        </div> <!-- row -->
    </div> <!-- container -->
</section>
<section id="about-page" class="pt-70 pb-110">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="iframe-container">
                    <iframe src="{{url('/tabel1')}}"></iframe>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection