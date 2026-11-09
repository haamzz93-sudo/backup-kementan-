<!doctype html>
<html lang="en">

<head>
   
    <!--====== Required meta tags ======-->
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    @yield('librarycss')
    <!--====== Title ======-->
    <title>PROSEED - Produksi Dan Kelembagaan</title>
    
    <!--====== Favicon Icon ======-->
    <link rel="shortcut icon" href="{{ asset('frontend/images/favicon.png')}}" type="image/png">

    <!--====== Slick css ======-->
    <link rel="stylesheet" href="{{ asset('frontend/css/slick.css')}}">

    <!--====== Animate css ======-->
    <link rel="stylesheet" href="{{ asset('frontend/css/animate.css')}}">
    
    <!--====== Nice Select css ======-->
    <link rel="stylesheet" href="{{ asset('frontend/css/nice-select.css')}}">
    
    <!--====== Nice Number css ======-->
    <link rel="stylesheet" href="{{ asset('frontend/css/jquery.nice-number.min.css')}}">

    <!--====== Magnific Popup css ======-->
    <link rel="stylesheet" href="{{ asset('frontend/css/magnific-popup.css')}}">

    <!--====== Bootstrap css ======-->
    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css')}}">
    
    <!--====== Fontawesome css ======-->
    <link rel="stylesheet" href="{{ asset('frontend/css/font-awesome.min.css')}}">
    
    <!--====== Default css ======-->
    <link rel="stylesheet" href="{{ asset('frontend/css/default.css')}}">
    
    <!--====== Style css ======-->
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css')}}">
    
    <!--====== Responsive css ======-->
    <link rel="stylesheet" href="{{ asset('frontend/css/responsive.css')}}">
  
  
</head>

<body>
      
   <!--====== PRELOADER PART START ======-->
    
    <div class="preloader">
        <div class="loader rubix-cube">
            <div class="layer layer-1"></div>
            <div class="layer layer-2"></div>
            <div class="layer layer-3 color-1"></div>
            <div class="layer layer-4"></div>
            <div class="layer layer-5"></div>
            <div class="layer layer-6"></div>
            <div class="layer layer-7"></div>
            <div class="layer layer-8"></div>
        </div>
    </div>
    
    <!--====== PRELOADER PART START ======-->
   
    <!--====== HEADER PART START ======-->
    
    <header id="header-part">        
        <div class="navigation navigation-2 navigation-3">
            <div class="container">
                <div class="row no-gutters">
                    <div class="col-lg-11 col-md-10 col-sm-9 col-9">
                    <nav class="navbar navbar-expand-lg">
                            <a class="navbar-brand" href="index-5.html">
                                <img src="{{ asset('frontend/images/logo-2.png')}}" alt="Logo">
                            </a>
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <div class="collapse navbar-collapse sub-menu-bar" id="navbarSupportedContent">
                                <ul class="navbar-nav ml-auto">
                                    <li class="nav-item">
                                        <a href="{{ url('/')}}">Beranda</a>
                                    </li>
                                    @if(Auth::check())
                                    <li class="nav-item">
                                        <a href="{{ url('/prokel')}}" class="active">Produksi dan Kelembagaan</a>
                                    </li>
                                    
                                    <li class="nav-item">
                                        <a href="{{ url('/pmb')}}">Pengawasan Mutu Benih</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('/pv')}}">Penyebaran Varietas</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#">Database</a>
                                        <ul class="sub-menu">
                                            <li><a href="{{ url('/produsen')}}">Produsen/Pengedar Benih</a></li>
                                            <li><a href="{{ url('/pohon')}}">Tanaman Induk</a></li>
                                            <li><a href="{{ url('/produksi-apbn')}}">Produksi dan Stok APBN</a></li>
                                            <li><a href="{{ url('/produksi-nonapbn')}}">Produksi Non APBN</a></li>
                                            <li><a href="{{ url('/serkom')}}">Sertifikat Kompetensi</a></li>
                                            <li><a href="{{ url('/varietas-daftar')}}">Varietas Terdaftar</a></li>
                                            <li><a href="{{ url('/varietas-sanggah')}}">Varietas Masa Sanggah</a></li>
                                            <li><a href="{{ url('/sebaran-varietas')}}">Sebaran Varietas</a></li>
                                            <li><a href="{{ url('/kinerja')}}">Kinerja Pelaporan</a></li>
                                        </ul>
                                    </li>
                                    @else
                                    <li class="nav-item">
                                    <a href="{{ url('/varietas-daftar')}}">Varietas Terdaftar</a>
                                    </li>
                                    <li class="nav-item">
                                    <a href="{{ url('/varietas-sanggah')}}">Varietas Masa Sanggah</a>
                                    </li>
                                    @endif
                                </ul>
                            </div>
                        </nav> <!-- nav -->
                    </div>
                    <div class="col-lg-1 col-md-2 col-sm-3 col-3">
                        <div class="right-icon text-right">
                            <ul>
                                <li><a href="{{ url('/admin')}}"><i class="fa fa-users"></i></a></li>
                            </ul>
                        </div> <!-- right icon -->
                    </div>
                </div> <!-- row -->
            </div> <!-- container -->
        </div>
    </header>
    
    <!--====== HEADER PART ENDS ======-->
   
    
    @yield('content')
   
    <!--====== FOOTER PART START ======-->
    
    <footer id="footer-part">
        <div class="footer-top pt-40 pb-70">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-6">
                        <div class="footer-about mt-40">
                            <div class="logo">
                                <a href="#"><img src="{{ asset('frontend/images/logo-2.png')}}" alt="Logo"></a>
                            </div>
                            <b style="color:white">DIREKTORAT PERBENIHAN HORTIKULTURA</b>
                            <p>
                                DIREKTORAT JENDERAL HORTIKULTURA <br>
                  
                                Kementerian Pertanian<br>
                                Republik Indonesia <br>
                              </p>
                        </div> <!-- footer about -->
                    </div>
                    
                    <div class="col-lg-4 col-md-6">
                        <div class="footer-address mt-40">
                            <div class="footer-title pb-25">
                                <h6>Kontak Kami</h6>
                            </div>
                            <ul>
                                <li>
                                    <div class="icon">
                                        <i class="fa fa-home"></i>
                                    </div>
                                    <div class="cont">
                                        <p>Jl. AUP No. 3 Pasar Minggu, Jakarta Selatan 12520</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="icon">
                                        <i class="fa fa-phone"></i>
                                    </div>
                                    <div class="cont">
                                        <p> (021) 7806775 / 78832048 / 78831845</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="icon">
                                        <i class="fa fa-envelope-o"></i>
                                    </div>
                                    <div class="cont">
                                        <p>hortikultura@pertanian.go.id / sekdithorti@pertanian.go.id</p>
                                    </div>
                                </li>
                            </ul>
                        </div> <!-- footer address -->
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="footer-link mt-40">
                            <div class="footer-title pb-25">
                                <h6>Tautan</h6>
                            </div>
                            <ul>
                                <li><a href="https://pertanian.go.id/" target="_blank"><i class="fa fa-angle-right"></i>Web Kementerian Pertanian</a></li>
                                <li><a href="https://hortikultura.pertanian.go.id/" target="_blank"><i class="fa fa-angle-right"></i>Web Direktorat Jenderal Hortikultura</a></li>
                                <li><a href="https://hortikultura.pertanian.go.id/?page_id=123" target="_blank"><i class="fa fa-angle-right"></i>Web Direktorat Perbenihan Hortikultura</a></li>\
                            </ul>
                        </div> <!-- footer link -->
                    </div>
                </div> <!-- row -->
            </div> <!-- container -->
        </div> <!-- footer top -->
        
        <div class="footer-copyright pt-10 pb-25">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <div class="copyright text-md-left text-center pt-15">
                            <p><a target="_blank" href=""></a> </p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="copyright text-md-right text-center pt-15">
                           
                        </div>
                    </div>
                </div> <!-- row -->
            </div> <!-- container -->
        </div> <!-- footer copyright -->
    </footer>
    
    <!--====== FOOTER PART ENDS ======-->
   
    <!--====== BACK TO TP PART START ======-->
    
    <a href="#" class="back-to-top"><i class="fa fa-angle-up"></i></a>
    
    <!--====== BACK TO TP PART ENDS ======-->
   
    
    
    
    
    
    
    
    <!--====== jquery js ======-->
    <script src="{{ asset('frontend/js/vendor/modernizr-3.6.0.min.js')}}"></script>
    <script src="{{ asset('frontend/js/vendor/jquery-1.12.4.min.js')}}"></script>

    <!--====== Bootstrap js ======-->
    <script src="{{ asset('frontend/js/bootstrap.min.js')}}"></script>
    
    <!--====== Slick js ======-->
    <script src="{{ asset('frontend/js/slick.min.js')}}"></script>
    
    <!--====== Magnific Popup js ======-->
    <script src="{{ asset('frontend/js/jquery.magnific-popup.min.js')}}"></script>
    
    <!--====== Counter Up js ======-->
    <script src="{{ asset('frontend/js/waypoints.min.js')}}"></script>
    <script src="{{ asset('frontend/js/jquery.counterup.min.js')}}"></script>
    
    <!--====== Nice Select js ======-->
    <script src="{{ asset('frontend/js/jquery.nice-select.min.js')}}"></script>
    
    <!--====== Nice Number js ======-->
    <script src="{{ asset('frontend/js/jquery.nice-number.min.js')}}"></script>
    
    <!--====== Count Down js ======-->
    <script src="{{ asset('frontend/js/jquery.countdown.min.js')}}"></script>
    
    <!--====== Validator js ======-->
    <script src="{{ asset('frontend/js/validator.min.js')}}"></script>
    
    <!--====== Ajax Contact js ======-->
    <script src="{{ asset('frontend/js/ajax-contact.js')}}"></script>
    
    <!--====== Main js ======-->
    <script src="{{ asset('frontend/js/main.js')}}"></script>
    
    <!--====== Map js ======-->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDC3Ip9iVC0nIxC6V14CKLQ1HZNF_65qEQ"></script>
    <script src="{{ asset('frontend/js/map-script.js')}}"></script>

</body>

</html>
