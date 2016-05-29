<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1 , maximum-scale=1">
    <!-- Page Description and Author -->
    <meta name="description" content="ConBiz - Responsive HTML5 Template">
    <meta name="author" content="Grayrids">
    
    <title>Laravel Quickstart - Basic</title>
    
    <!-- Styles -->
    <!-- Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
    <!-- Bootstrap CSS  -->
    <!--<link rel="stylesheet" href="{{ asset('iknowwelding/css/bootstrap.min.css') }}" type="text/css" media="screen">-->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <!-- Icon -->
    <link rel="stylesheet" href="{{ asset('iknowwelding/fonts/simple-line-icons.css') }}" type="text/css" media="screen">
    <!-- ConBiz Iocn -->
    <link rel="stylesheet" href="{{ asset('iknowwelding/fonts/flaticon.css') }}" type="text/css" media="screen">
    <!-- rs style -->
    <link rel="stylesheet" type="text/css" href="{{ asset('iknowwelding/css/settings.css') }}" media="screen">
    <!-- ConBiz CSS Styles  -->
    <link rel="stylesheet" type="text/css" href="{{ asset('iknowwelding/css/main.css') }}" media="screen">
    <!-- Responsive CSS Styles  -->
    <link rel="stylesheet" type="text/css" href="{{ asset('iknowwelding/css/responsive.css') }}" media="screen">
    <!-- Css3 Transitions Styles  -->
    <link rel="stylesheet" type="text/css" href="{{ asset('iknowwelding/css/animate.css') }}" media="screen">
    <!-- Slicknav  -->
    <link rel="stylesheet" type="text/css" href="{{ asset('iknowwelding/css/slicknav.css') }}" media="screen">
    <!-- Selected Preset -->
    <link rel="stylesheet" type="text/css" href="{{ asset('iknowwelding/css/colors/yellow.css') }}" media="screen" />
        <!-- Color CSS Styles  -->
    <link rel="stylesheet" type="text/css" href="{{ asset('iknowwelding/css/colors/yellow.css') }}" title="yellow" media="screen" />
    <!--<link rel="stylesheet" type="text/css" href="{{ asset('iknowwelding/css/colors/turquoise.css') }}" title="turquoise" media="screen" />-->
    <!--<link rel="stylesheet" type="text/css" href="{{ asset('iknowwelding/css/colors/emerald.css') }}" title="emerald" media="screen" />-->
    <!--<link rel="stylesheet" type="text/css" href="{{ asset('iknowwelding/css/colors/river.css') }}" title="river" media="screen" />-->
    <!--<link rel="stylesheet" type="text/css" href="{{ asset('iknowwelding/css/colors/wisteria.css') }}" title="wisteria" media="screen" />-->
    <!--<link rel="stylesheet" type="text/css" href="{{ asset('iknowwelding/css/colors/alizarin.css') }}" title="alizarin" media="screen" />-->
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}
    <!--[if IE 8]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <style>
        body {  
            font-family: 'Lato';
        }

        .fa-btn {
            margin-right: 6px;
        }
    </style>
</head>
<body id="app-layout">
    @yield('content')
    <!-- Full Body Container -->
    <div id="container">
    <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<!--    <script type="text/javascript" src="{{ asset('iknowwelding/js/jquery-min.js') }}"></script>      
    <script type="text/javascript" src="{{ asset('iknowwelding/js/bootstrap.min.js') }}"></script>-->
    <script type="text/javascript" src="{{ asset('iknowwelding/js/owl.carousel.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('iknowwelding/js/modernizrr.js') }}"></script>
    <script type="text/javascript" src="{{ asset('iknowwelding/js/nivo-lightbox.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('iknowwelding/js/jquery.mixitup.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('iknowwelding/js/jquery.appear.js') }}"></script>
    <script type="text/javascript" src="{{ asset('iknowwelding/js/count-to.js') }}"></script>
    <script type="text/javascript" src="{{ asset('iknowwelding/js/jquery.parallax.js') }}"></script>
    <script type="text/javascript" src="{{ asset('iknowwelding/js/smooth-scroll.js') }}"></script>
    <script type="text/javascript" src="{{ asset('iknowwelding/js/jquery.slicknav.js') }}"></script>
    <script type="text/javascript" src="{{ asset('iknowwelding/js/main.js') }}"></script>

    <!-- Revelosition slider js -->
    <script src="{{ asset('iknowwelding/js/jquery.themepunch.revolution.min.js') }}"></script>
    <script src="{{ asset('iknowwelding/js/jquery.themepunch.tools.min.js') }}"></script>
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    @stack('page_plugins')
    <!-- END PAGE LEVEL PLUGINS -->
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
    </div>
</body>
</html>
