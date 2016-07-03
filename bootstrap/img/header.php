<!DOCTYPE HTML>
<html lang="en">

    <head>
        <title>Sisterhood - Portal</title>
        <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Sisterhood Portal">
        <meta name="keywords" content="website keywords, website keywords" />
        <meta http-equiv="content-type" content="text/html; charset=windows-1252" />
        <link href="<?php echo CSS_PATH; ?>bootstrap.min.css" rel="stylesheet" type="text/css">
        <!-- Custom styles for our template -->
	<link href="<?php echo CSS_PATH; ?>bootstrap-theme.css" rel="stylesheet" media="screen">
	<link href="<?php echo CSS_PATH; ?>da-slider.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo CSS_PATH; ?>style.css" rel="stylesheet" >
        <link href="<?php echo CSS_PATH; ?>font-awesome.min.css" rel="stylesheet" type="text/css">
        <title></title>
    </head>
    <body>
    <div id="main">
        <!-- Fixed navbar -->
	<div class="navbar navbar-inverse">
            <div class="container">
                <div id="header_logo" class="navbar-header">
                    <!-- Button for smallest screens -->
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
                </div>
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav pull-right mainNav">

                        <?php foreach ($menu['up'] as $key_menu => $val_menu): ?>
                        <?php $class = isset($class) ? '' : 'active' ; ?>
                        <li>
                            <a href=<?php echo base_url()."$val_menu[1]"; ?> >
                                <i class="fa fa-bank"></i>
                                <?php echo $val_menu[0]; ?> 
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <!--/.nav-collapse -->
            </div>
	</div>
	<!-- /.navbar -->

	<!-- Header -->
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
                        <div class="da-slide" style="background: #181015 url('<?php echo base_url(); ?>/bootstrap/img/banner6.jpg') no-repeat; background-size: cover;">
                            <p></p>
                            <div class="da-img"></div>
                        </div>
                        <div class="da-slide" style="background: #181015 url('<?php echo base_url(); ?>/bootstrap/img/banner7.jpg') no-repeat; background-size: cover;">
                            <p></p>
                            <div class="da-img"></div>
                        </div>
                        <div class="da-slide" style="background: #181015 url('<?php echo base_url(); ?>/bootstrap/img/banner8.jpg') no-repeat; background-size: cover;">
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
	</header>
	<!-- /Header -->
        
        <!-- JavaScript libs are placed at the end of the document so the pages load faster -->
       	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="<?php echo JS_PATH; ?>html5shiv.js"></script>
	<script src="<?php echo JS_PATH; ?>respond.min.js"></script>
	<![endif]-->
        <script src="<?php echo JS_PATH; ?>jquery.js"></script>
        <script src="<?php echo JS_PATH; ?>bootstrap.min.js"></script>
        <script src="<?php echo JS_PATH; ?>docs.min.js"></script>	
	<script src="<?php echo JS_PATH; ?>froala_editor.min.js"></script>
        <script src="<?php echo JS_PATH; ?>modernizr.js"></script>
	<script src="<?php echo JS_PATH; ?>jquery.cslider.js"></script>
        <script src="<?php echo JS_PATH; ?>jquery.fancybox.pack.js"></script>
	<script src="<?php echo JS_PATH; ?>custom.js"></script>

       
