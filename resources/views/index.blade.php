@extends('layout/app')
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
    <!--====== SLIDER PART START ======-->
    
    <section id="slider-part" class="slider-active">
        <div class="single-slider bg_cover pt-150" style="background-image: url('{{ asset('frontend/images/slider/s-1.jpg') }}')" data-overlay="4">
            <div class="container">
                <div class="row">
                    <div class="col-xl-7 col-lg-9">
                        <div class="slider-cont">
                            <h1 data-animation="bounceInLeft" data-delay="1s">Informasi Produksi dan Kelembagaan</h1>
                            <p data-animation="fadeInUp" data-delay="1.3s">Penyajian data terkait kelembagaan perbenihan hortikultura untuk jenis Balai, Penangkat Benih Umum, UPBS, Serta Mitra Swasta. Serta data produksi benih bermutu</p>
                            @if(Auth::check())
                            <ul>
                                <li><a data-animation="fadeInUp" data-delay="1.6s" class="main-btn" href="{{url('/')}}/prokel">Lihat Disini</a></li>
                            </ul>
                            @endif
                        </div>
                    </div>
                </div> <!-- row -->
            </div> <!-- container -->
        </div> <!-- single slider -->
        
        <div class="single-slider bg_cover pt-150" style="background-image: url('{{ asset('frontend/images/slider/s-2.jpg') }}')" data-overlay="4">
            <div class="container">
                <div class="row">
                    <div class="col-xl-7 col-lg-9">
                        <div class="slider-cont">
                            <h1 data-animation="bounceInLeft" data-delay="1s">Informasi Pengawasan Mutu</h1>
                            <p data-animation="fadeInUp" data-delay="1.3s">Penyajian data terkait sertifikasi benih bermutu, inventaris pohon induk dan sebarannya</p>
                            @if(Auth::check())
                            <ul>
                                <li><a data-animation="fadeInUp" data-delay="1.6s" class="main-btn" href="{{url('/')}}/pmb">Lihat Disini</a></li>
                            </ul>
                            @endif
                        </div>
                    </div>
                </div> <!-- row -->
            </div> <!-- container -->
        </div> <!-- single slider -->
        
        <div class="single-slider bg_cover pt-150" style="background-image: url('{{ asset('frontend/images/slider/s-3.jpg') }}')" data-overlay="4">
            <div class="container">
                <div class="row">
                    <div class="col-xl-7 col-lg-9">
                        <div class="slider-cont">
                            <h1 data-animation="bounceInLeft" data-delay="1s">Informasi Penilaian dan Penyebaran Varietas</h1>
                            <p data-animation="fadeInUp" data-delay="1.3s">Penyajian data terkait pendaftaran varietas, data varietas dalam masa sanggah, dan sebaran varietas</p>
                            @if(Auth::check())
                            <ul>
                                <li><a data-animation="fadeInUp" data-delay="1.6s" class="main-btn" href="{{url('/')}}/pv">Lihat Disini</a></li>
                            </ul>
                            @endif
                        </div>
                    </div>
                </div> <!-- row -->
            </div> <!-- container -->
        </div> <!-- single slider -->
    </section>
    @if(Auth::check())
    <section id="category-part">
        <div class="container">
            <div class="category pt-40 pb-80">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="category-text pt-40">
                            <h2>Fitur - fitur utama dalam pelaporan</h2>
                        </div>
                    </div>
                    <div class="col-lg-6 offset-lg-1 col-md-8 offset-md-2 col-sm-8 offset-sm-2 col-8 offset-2">
                        <div class="row category-slied mt-40">
                            <div class="col-lg-4">
                                <a href="{{url('/')}}/prokel">
                                    <span class="singel-category text-center color-1">
                                        <span class="icon">
                                            <img src="{{ asset('frontend/images/all-icon/ctg-1.png')}}" alt="Icon">
                                        </span>
                                        <span class="cont">
                                            <span>Produksi dan Kelembagaan</span>
                                        </span>
                                    </span> <!-- singel category -->
                                </a>
                            </div>
                            <div class="col-lg-4">
                                <a href="{{url('/')}}/pmb">
                                    <span class="singel-category text-center color-2">
                                        <span class="icon">
                                            <img src="{{ asset('frontend/images/all-icon/ctg-2.png')}}" alt="Icon">
                                        </span>
                                        <span class="cont">
                                            <span>Pengawasan Mutu Benih</span>
                                        </span>
                                    </span> <!-- singel category -->
                                </a>
                            </div>
                            <div class="col-lg-4">
                                <a href="{{url('/')}}/pv">
                                    <span class="singel-category text-center color-3">
                                        <span class="icon">
                                            <img src="{{ asset('frontend/images/all-icon/ctg-3.png')}}" alt="Icon">
                                        </span>
                                        <span class="cont">
                                            <span>Penyebaran Varietas</span>
                                        </span>
                                    </span> <!-- singel category -->
                                </a>
                            </div>
                            <div class="col-lg-4">
                                <a href="{{url('/')}}/kinerja">
                                    <span class="singel-category text-center color-4">
                                        <span class="icon">
                                            <img src="{{ asset('frontend/images/all-icon/ctg-1.png')}}" alt="Icon">
                                        </span>
                                        <span class="cont">
                                            <span>Monitoring Pelapor</span>
                                        </span>
                                    </span> <!-- singel category -->
                                </a>
                            </div>
                        </div> <!-- category slied -->
                    </div>
                </div> <!-- row -->
            </div> <!-- category -->
        </div> <!-- container -->
    </section>
    @endif
    <!--====== SLIDER PART ENDS ======-->
    
    
    <section id="teachers-part" class="pt-65 pb-120 white-bg">
        <div class="container">
            <div class="row">
			<div class="col-lg-12">
                    <div class="happy-student mt-55">
                        <div class="happy-title">
                            <h3>Video Opening</h3>
                        </div>
                        <div class="student-slied" style="height:100%;padding:10px">
                            <iframe  style="height:600px;width:100%" width="600" height="800" src="https://www.youtube.com/embed/Oy8P2_OUmyA?si=XgK4cWD4KeXUFbd_" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                        </div> <!-- student slied -->
                    </div> <!-- happy student -->
                </div>
                <div class="col-lg-12">
                    <div class="section-title mt-50 pb-25">
                        <h5>Tutorial</h5>
                        <h2>Halaman Admin</h2>
                    </div> <!-- section title -->
                    <div class="teachers-2">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="teachers-2-singel mt-30">
                                    <div class="cont">
                                        <a href="teachers-singel.html"><h5>Admin Pusat</h5></a>
                                        <p>Level Direktorat Perbenihan Hortikultura</p>
                                        <span><i class="fa fa-book"></i>10 Courses</span>
                                    </div>
                                </div> <!-- teachers 2 singel -->
                            </div>
                            <div class="col-md-6">
                                <div class="teachers-2-singel mt-30">
                                    <div class="cont">
                                        <a href="teachers-singel.html"><h5>Admin Sertifikasi</h5></a>
                                        <p>Level Lembaga Pengawasan dan Sertifikasi Benih Provinsi</p>
                                        <span><i class="fa fa-book"></i>05 Courses</span>
                                    </div>
                                </div> <!-- teachers 2 singel -->
                            </div>
                            <div class="col-md-6">
                                <div class="teachers-2-singel mt-30">
                                    <div class="cont">
                                        <a href="teachers-singel.html"><h5>Admin Produsen Umum</h5></a>
                                        <p>Level Lembaga/Perseorangan Produsen Benih Umum</p>
                                        <span><i class="fa fa-book"></i>10 Courses</span>
                                    </div>
                                </div> <!-- teachers 2 singel -->
                            </div>
                            <div class="col-md-6">
                                <div class="teachers-2-singel mt-30">
                                    <div class="cont">
                                        <a href="teachers-singel.html"><h5>Admin Produsen Balai</h5></a>
                                        <p>Level Lembaga Balai Daerah yang memiliki bantuan APBN</p>
                                        <span><i class="fa fa-book"></i>05 Courses</span>
                                    </div>
                                </div> <!-- teachers 2 singel -->
                            </div>
                        </div> <!-- row -->
                    </div> <!-- teachers 2 -->
                </div>
                
            </div> <!-- row -->
        </div> <!-- container -->
    </section>
    
    <!--====== COUNTER PART START ======-->
    
    <div id="counter-part" class="bg_cover pt-25 pb-70 gray-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-sm-6">
                    <div class="singel-counter counter-3 text-center mt-40">
                        <span><span class="counter">{{ $countlembaga }}</span>+</span>
                        <p>Lembaga Produsen Benih</p>
                    </div> <!-- singel counter -->
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="singel-counter counter-3 text-center mt-40">
                        <span><span class="counter">{{$countpohon}}</span>+</span>
                        <p>Nomor Registrasi Pohon Induk</p>
                    </div> <!-- singel counter -->
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="singel-counter counter-3 text-center mt-40">
                        <span><span class="counter">{{$countlabel}}</span>+</span>
                        <p>Label Benih Bermutu</p>
                    </div> <!-- singel counter -->
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="singel-counter counter-3 text-center mt-40">
                        <span><span class="counter">{{$countvarietas}}</span>+</span>
                        <p>Varietas Hortikultura Terdaftar</p>
                    </div> <!-- singel counter -->
                </div>
            </div> <!-- row -->
        </div> <!-- container -->
    </div>
    
    @endsection
 