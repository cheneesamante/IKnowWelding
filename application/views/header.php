<!DOCTYPE HTML>
<html lang="en">

    <head>
        <title>Sisterhood - Portal</title>
        <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Sisterhood Portal">
        <meta name="keywords" content="Makati, Sister City, Sister Cities, Makati Portal" />
        <meta http-equiv="content-type" content="text/html; charset=windows-1252" />
		
		<link rel="shortcut icon" href="<?php echo base_url(); ?>/bootstrap/img/makati-seal.ico" type="image/icon"> <link rel="icon" href="<?php echo base_url(); ?>/bootstrap/img/makati-seal.ico" type="image/icon">
        <!-- Google Web Font Embed -->
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'>
        
        <link href="<?php echo CSS_PATH; ?>bootstrap.min.css" rel="stylesheet" type="text/css">
        <!-- Custom styles for our template -->
	<link href="<?php echo CSS_PATH; ?>bootstrap-theme.css" rel="stylesheet" media="screen">
	<link href="<?php echo CSS_PATH; ?>da-slider.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo CSS_PATH; ?>style.css" rel="stylesheet" >
        <link href="<?php echo CSS_PATH; ?>font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="<?php echo CSS_PATH; ?>fullcalendar.print.css" rel="stylesheet" type="text/css">
        <link href="<?php echo CSS_PATH; ?>fullcalendar.css" rel="stylesheet" type="text/css">
        <!-- Custom styles for this template -->
        <link href="<?php echo CSS_PATH; ?>colorbox.css"  rel="stylesheet" type="text/css">
        <link href="<?php echo CSS_PATH; ?>templatemo_style.css"  rel="stylesheet" type="text/css">
        <link href="<?php echo CSS_PATH; ?>pgwslider.min.css"  rel="stylesheet" type="text/css">
        <link href="<?php echo CSS_PATH; ?>pgwslider.min.css"  rel="stylesheet" type="text/css">
        <link href="<?php echo CSS_PATH; ?>mbExtruder.css" media="all" rel="stylesheet" type="text/css"> 
    </head>
    <body>
    <div>
        
        <div class="templatemo-top-menu">
            <div class="container">
                <!-- Static navbar -->
                <div class="navbar navbar-default" role="navigation">
                    <div class="container">
                        <div class="navbar-header">
                                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                </button>
                                <a href="#" class="navbar-brand" style="padding-left:30px ; padding-bottom:15px; margin-left:-92px ; margin-top:15px; "><img style="" src="<?php echo base_url(); ?>bootstrap/img/logo2.png" alt="Makati Sisterhood Portal" title="Makati Sisterhood Portal" /></a>
                        </div>
                        <div id="extruderTop" class="{title:'SIGN IN', url:'<?php echo base_url().'login/display'?>'}"></div>
                        <div class="navbar-collapse collapse" id="templatemo-nav-bar">
                            <ul class="nav navbar-nav navbar-right" style="margin-top: 40px; padding-top:20px;">
                                <?php foreach ($menu['up'] as $key_menu => $val_menu): ?>
                                <?php 
                                    $class = isset($class) ? '' : 'active' ;
                                    $href = explode("/", $val_menu[1]); 
                                    $page = $href[count($href) - 1];
                                    
                                    $link = $val_menu[0] == 'City of Makati' ? 
                                        'rel="nofollow" href="http://www.makati.gov.ph" class="external-link"' : 
                                        "href=#".$page ;
                                ?>
                                <li>
                                    <a <?php echo $link; ?>>
                                        <i class="fa fa-bank"></i>
                                        <?php echo strtoupper($val_menu[0]); ?> 
                                    </a>
                                </li>
                                <?php endforeach; ?>
                                <!--
                                <li class="active"><a href="#templatemo-top">HOME</a></li>
                                <li><a href="#templatemo-about">ABOUT</a></li>
                                <li><a href="#templatemo-portfolio">PORTFOLIO</a></li>
                                <li><a href="#templatemo-blog">BLOG</a></li>
                                <li><a rel="nofollow" href="http://www.google.com" class="external-link">EXTERNAL</a></li>
                                <li><a href="#templatemo-contact">CONTACT</a></li>
                                -->
                            </ul>
                        </div><!--/.nav-collapse -->
                    </div><!--/.container-fluid -->
                </div><!--/.navbar -->
            </div> <!-- /container -->
        </div>
        
        <div>
            <!-- Carousel -->
            <div id="templatemo-carousel" class="carousel slide" data-ride="carousel">
                <!-- Indicators -->
                <ol class="carousel-indicators">
                    <li data-target="#templatemo-carousel" data-slide-to="0" class="active"></li>
                    <li data-target="#templatemo-carousel" data-slide-to="1" ></li>
                    <li data-target="#templatemo-carousel" data-slide-to="2"></li>
                    <li data-target="#templatemo-carousel" data-slide-to="3"></li>
                    <li data-target="#templatemo-carousel" data-slide-to="4"></li>
                    <li data-target="#templatemo-carousel" data-slide-to="5"></li>
                </ol>
                <div class="carousel-inner">
                    <div class="item active">
                        <div class="container">			
                            <div class="carousel-caption">
                                <h1>WELCOME TO MAKATI SISTERHOOD PORTAL </h1>
                                <p>&nbsp;</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="item ad1">                   
                        <div class="container">
                            <div class="carousel-caption"></div>
                        </div>
                    </div>
                    <div class="item ad2">
                        <div class="container">
                            <div class="carousel-caption"></div>
                        </div>
                    </div>
                    <div class="item ad3">
                        <div class="container">
                            <div class="carousel-caption"></div>
                        </div>
                    </div>
                    <div class="item ad4">
                        <div class="container">
                            <div class="carousel-caption"></div>
                        </div>
                    </div>
                    <div class="item ad5">
                        <div class="container">
                            <div class="carousel-caption"></div>
                        </div>
                    </div>
                </div>
                <a class="left carousel-control" href="#templatemo-carousel" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
                <a class="right carousel-control" href="#templatemo-carousel" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
            </div><!-- /#templatemo-carousel -->
        </div>

	<!-- Header -->
        <!--
	<header id="head">
            <div class="container">
                <div class="banner-content">
                    <div id="da-slider" class="da-slider">
                        <div class="da-slide" style="background: #181015 url('<?php echo base_url(); ?>/bootstrap/img/banner.jpg') no-repeat; background-size: cover;">
                            <h2>Welcome to Makati Sisterhood Portal</h2>
                            <p></p>
                            <div class="da-img"></div>
                        </div>
                        <div class="da-slide" style="background: #181015 url('<?php echo base_url(); ?>/bootstrap/img/banner1.jpg') no-repeat; background-size: cover;">
                            <p></p>
                            <div class="da-img"></div>
                        </div>
                        <div class="da-slide" style="background: #181015 url('<?php echo base_url(); ?>/bootstrap/img/banner2.jpg') no-repeat; background-size: cover;">
                            <p></p>
                            <div class="da-img"></div>
                        </div>
                        <div class="da-slide" style="background: #181015 url('<?php echo base_url(); ?>/bootstrap/img/banner3.jpg') no-repeat; background-size: cover;">
                            <p></p>
                            <div class="da-img"></div>
                        </div>
                        <div class="da-slide" style="background: #181015 url('<?php echo base_url(); ?>/bootstrap/img/banner4.jpg') no-repeat; background-size: cover;">
                            <p></p>
                            <div class="da-img"></div>
                        </div>
                         <div class="da-slide" style="background: #181015 url('<?php echo base_url(); ?>/bootstrap/img/banner5.jpg') no-repeat; background-size: cover;">
                            <p></p>
                            <div class="da-img"></div>
                        </div>
                        <nav class="da-arrows">
                            <span class="da-arrows-prev"></span>
                            <span class="da-arrows-next"></span>
                        </nav>
                    </div>
                </div>
            </div>
	</header> -->
	<!-- /Header -->
        
        <!-- JavaScript libs are placed at the end of the document so the pages load faster -->
       	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="<?php echo JS_PATH; ?>html5shiv.js"></script>
	<script src="<?php echo JS_PATH; ?>respond.min.js"></script>
	<![endif]-->
        
        <script src="<?php echo JS_PATH; ?>jquery.js"></script>
        
        <!-- library for bootsrap validator -->
        <script src="<?php echo JS_PATH; ?>bootstrapValidator.min.js"></script>
        <script src="<?php echo JS_PATH; ?>bootstrap.min.js"></script>
	<script src="<?php echo JS_PATH; ?>froala_editor.min.js"></script>

        <script src="<?php echo JS_PATH; ?>stickUp.min.js"></script>
        <script src="<?php echo JS_PATH; ?>jquery.colorbox-min.js"></script>
        <script src="<?php echo JS_PATH; ?>templatemo_script.js"></script>
        <script src="<?php echo JS_PATH; ?>jquery.MyThumbNail.js"></script>
        <script src="<?php echo JS_PATH; ?>pgwslider.min.js"></script>

        <!-- calendar plugin -->
        <script src="<?php echo JS_PATH; ?>moment.min.js"></script>
        <script src="<?php echo JS_PATH; ?>fullcalendar.min.js"></script>
        <script src="<?php echo JS_PATH; ?>bootstrap-datetimepicker.js"></script>
        
        <!-- login panel -->
        <script src="<?php echo JS_PATH; ?>jquery.hoverIntent.min.js"></script>
        <script src="<?php echo JS_PATH; ?>jquery.mb.flipText.js"></script>
        <script src="<?php echo JS_PATH; ?>mbExtruder.js"></script>
        
        
        
       
