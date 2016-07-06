<!doctype html>
<!--[if IE 8 ]>
<html class="ie ie8" lang="en">
<![endif]-->
<!--[if (gte IE 9)|!(IE)]>
<html lang="en" class="no-js">
<![endif]-->
<html lang="en">
  <head>
    <!-- Basic -->
    <title>
      IKnowWelding
    </title>
    <!-- Define Charset -->
    <meta charset="utf-8">
    <!-- Responsive Metatag -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <!-- Page Description and Author -->
    <meta name="description" content="welding">
    <meta name="author" content="">
        
	<!-- Bootstrap CSS  -->
	<link rel="stylesheet" href="<?php echo CSS_PATH; ?>bootstrap.min.css" type="text/css" media="screen">
	<!-- Font Awesome CSS -->
	<link rel="stylesheet" href="<?php echo FONTS_PATH; ?>font-awesome.min.css" type="text/css" media="screen">
	<!-- Icon -->
	<link rel="stylesheet" href="<?php echo CSS_PATH; ?>simple-line-icons.css" type="text/css" media="screen">
	<!-- ConBiz Iocn -->
	<link rel="stylesheet" href="<?php echo CSS_PATH; ?>flaticon.css" type="text/css" media="screen">
	<!-- rs style -->
	<link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH; ?>settings.css" media="screen">
	<!-- ConBiz CSS Styles  -->
	<link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH; ?>main.css" media="screen">
	<!-- Responsive CSS Styles  -->
	<link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH; ?>responsive.css" media="screen">
	<!-- Css3 Transitions Styles  -->
	<link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH; ?>animate.css" media="screen">
	<!-- Slicknav  -->
	<link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH; ?>slicknav.css" media="screen">

	<!-- Selected Preset -->
	<link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH; ?>yellow.css" media="screen" />
	
        <title></title>
    </head>
    <body>
    <!-- topbar starts -->
    <div class="navbar navbar-default" role="navigation">

        <div class="navbar-inner">
            <button type="button" class="navbar-toggle pull-left animated flip">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.html"> Sisterhood Portal </a>

            <!-- user dropdown starts -->
            <div class="btn-group pull-right">
                <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                    <i class="glyphicon glyphicon-user"></i>
                    <span class="hidden-sm hidden-xs">
                    <?php 
                        if(isset($this->session->userdata('info')['first_name'])){
                            $name = $this->session->userdata('info')['first_name'];
                        } else {
                            $name = '';
                        }
                    echo $name 
                    ?>
                    </span>
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo site_url('profile'); ?>">Profile</a></li>
                    <li class="divider"></li>
                    <li><a href="<?php echo site_url('logout'); ?>">Logout</a></li>
                </ul>
            </div>
            <!-- user dropdown ends -->

            <ul class="collapse navbar-collapse nav navbar-nav top-menu">
                <li><a href="<?php echo site_url('home'); ?>"><i class="glyphicon glyphicon-list"></i> Dashboard</a></li>
                <li><a href="<?php echo site_url('logout'); ?>"><i class="glyphicon glyphicon-globe"></i> Visit Site</a></li>
            </ul>


        </div>
    </div>
    <!-- topbar ends -->
    <div class="ch-container">
    <div class="row">
    
    <!-- left menu starts -->
        <div class="col-sm-2 col-lg-2">
            <div class="sidebar-nav">
                <div class="nav-canvas">
                    <div class="nav-sm nav nav-stacked">

                    </div>
                    <?php
                    $city = '';
                        if(isset($this->session->userdata('menu')['who'])){
                            if($this->session->userdata('info')['user_type_id'] == SISTER_LGU){
                               $city = $this->session->userdata('info')['city_name']; 
                            }
                            $who = $this->session->userdata('menu')['who'];
                        } else {
                            $who = '';
                        }
                        if(isset($this->session->userdata('menu')['down'])){
                            $down = $this->session->userdata('menu')['down'];
                        } else {
                            $down = $menu['down'];
                        }
                    ?>
                    <ul class="nav nav-pills nav-stacked main-menu">
                        <li class="nav-header"><h3><?php echo $who; ?></h3><h4 align="center"><?php echo $city; ?></h4></li>
                         <?php foreach ($down as $key_menu => $val_menu): ?>
                            <li>
                                <a class="ajax-link" href=<?php echo  base_url().$val_menu[1]; ?>>
                                    <i class="glyphicon glyphicon-chevron-right"></i><span> <?php echo $val_menu[0]; ?> </span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
        <!--/span-->
    <!-- left menu ends -->
    <noscript>
        <div class="alert alert-block col-md-12">
            <h4 class="alert-heading">Warning!</h4>

            <p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a>
                enabled to use this site.</p>
        </div>
    </noscript>
	
	
	<!-- Main JS  -->
    <script type="text/javascript" src="<?php echo JS_PATH; ?>jquery-min.js"></script>      
    <script type="text/javascript" src="<?php echo JS_PATH; ?>bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo JS_PATH; ?>owl.carousel.min.js"></script>
    <script type="text/javascript" src="<?php echo JS_PATH; ?>modernizrr.js"></script>
    <script type="text/javascript" src="<?php echo JS_PATH; ?>nivo-lightbox.min.js"></script>
    <script type="text/javascript" src="<?php echo JS_PATH; ?>jquery.mixitup.min.js"></script>
    <script type="text/javascript" src="<?php echo JS_PATH; ?>jquery.appear.js"></script>
    <script type="text/javascript" src="<?php echo JS_PATH; ?>count-to.js"></script>
    <script type="text/javascript" src="<?php echo JS_PATH; ?>jquery.parallax.js"></script>
    <script type="text/javascript" src="<?php echo JS_PATH; ?>smooth-scroll.js"></script>
    <script type="text/javascript" src="<?php echo JS_PATH; ?>jquery.slicknav.js"></script>
    <script type="text/javascript" src="<?php echo JS_PATH; ?>main.js"></script>

    <!-- Revelosition slider js -->
    <script src="<?php echo JS_PATH; ?>jquery.themepunch.revolution.min.js"></script>
    <script src="<?php echo JS_PATH; ?>jquery.themepunch.tools.min.js"></script>
    
    </body>
       
	   
