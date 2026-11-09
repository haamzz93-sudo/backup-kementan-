@extends('layout/database')
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

<section id="page-banner" class="pt-105 pb-110 bg_cover" data-overlay="8" style="background-image: url('{{ asset('frontend/images/page-banner-1.jpg') }}')">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-banner-cont">
                    <h2>Produksi dan Stok APBN</h2>
                </div> <!-- page banner cont -->
            </div>
        </div> <!-- row -->
    </div> <!-- container -->
</section>

<!--====== PAGE BANNER PART ENDS ======-->

<!--====== ABOUT PART START ======-->

<section id="about-page" class="pt-70 pb-110">

           <iframe src="{{url('/')}}/l-apbn" width="100%" height="100%" style="min-height:1300px" frameborder="0" allowfullscreen></iframe>

</section>

<!--====== ABOUT PART ENDS ======-->

<!--====== BACK TO TOP PART START ======-->

<a href="#" class="back-to-top"><i class="fa fa-angle-up"></i></a>

<!--====== BACK TO TOP PART ENDS ======-->
@endsection