<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Tamil Nadu State AIDS Control Society</title>
        <meta name="description" content="Tamil Nadu state AIDS control society">    
        <meta charset="utf-8">
        <meta name="author" content="Tamil Nadu state AIDS control society">
        <!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="_token" content="{!! csrf_token() !!}" />
        <!-- Favicons -->
        <link rel="shortcut icon" href="{{ asset('/frontend/images/favicon.png') }}">

        <!-- CSS -->
        <link rel="stylesheet" href="{{ asset('/frontend/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('/frontend/css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('/frontend/css/style-responsive.css') }}">
        <link rel="stylesheet" href="{{ asset('/frontend/css/animate.min.css') }}">
        <link rel="stylesheet" href="{{ asset('/frontend/css/verticals.min.css') }}">
        <link rel="stylesheet" href="{{ asset('/frontend/css/owl.carousel.css') }}">
        <link rel="stylesheet" href="{{ asset('/frontend/slick/slick.css') }}"> 
        <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
        <style type="text/css">
            .help-block{
                color: red;
            }
        </style>
    </head>
    <body class="appear-animate">
        
        <!-- Page Loader -->        
        <div class="page-loader">
            <div class="loader"></div>
        </div>
        <!-- End Page Loader -->

        <!-- Skip to Content -->
        <a href="#main" class="btn skip-to-content">Skip to Content</a>
        <!-- End Skip to Content -->
        
        <!-- Page Wrap -->
        <div class="page" id="top">
                    
            @yield('navigation')
            
            @yield('maincontent')
            
            @yield('footer')
        
        </div>
        <!-- End Page Wrap -->
        
        
        <!-- JS -->
        <script type="text/javascript" src="{{ asset('frontend/js/jquery-3.5.1.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('frontend/js/jquery.easing.1.3.js') }}"></script>
        <script type="text/javascript" src="{{ asset('frontend/js/bootstrap.bundle.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('frontend/js/jquery.appear.js') }}"></script>
        <script type="text/javascript" src="{{ asset('frontend/js/jquery.sticky.js') }}"></script>
        <script type="text/javascript" src="{{ asset('frontend/js/jquery.parallax-1.1.3.js') }}"></script>
        <script type="text/javascript" src="{{ asset('frontend/js/owl.carousel.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('frontend/js/imagesloaded.pkgd.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('frontend/js/wow.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('frontend/js/jquery.lazyload.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('frontend/slick/slick.js') }}"></script>
        <script type="text/javascript" src="{{ asset('frontend/js/all.js') }}"></script>     
        <!--[if lt IE 10]><script type="text/javascript" src="{{ asset('frontend/js/placeholder.js') }}"></script><![endif]-->
        @yield('scripts')
    </body>
</html>
