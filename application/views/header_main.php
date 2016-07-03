<!DOCTYPE HTML>
<html>
    <head>
    <!--
        ===
        This comment should NOT be removed.

        Charisma v2.0.0

        Copyright 2012-2014 Muhammad Usman
        Licensed under the Apache License v2.0
        http://www.apache.org/licenses/LICENSE-2.0

        http://usman.it
        http://twitter.com/halalit_usman
        ===
    -->
    <title>Sisterhood - Portal</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
	<link rel="shortcut icon" href="<?php echo base_url(); ?>/bootstrap/img/makati-seal.ico" type="image/icon"> <link rel="icon" href="<?php echo base_url(); ?>/bootstrap/img/makati-seal.ico" type="image/icon">
        <link href="<?php echo CSS_PATH; ?>screen.css" rel="stylesheet">
        <link href="<?php echo CSS_PATH; ?>jquery.weekcalendar.css" rel="stylesheet" id="bs-css">
        <link href="<?php echo CSS_PATH; ?>bootstrap.min.css" rel="stylesheet" id="bs-css">
        <link href="<?php echo CSS_PATH; ?>bootstrap-lumen.min.css" rel="stylesheet" id="bs-css">
        
        <link href="<?php echo CSS_PATH; ?>charisma-app.css" rel="stylesheet">
        <link href="<?php echo CSS_PATH; ?>jquery.dataTables.css" rel="stylesheet" type="text/css">
        <link href="<?php echo CSS_PATH; ?>jquery.dataTables_themeroller.css" rel="stylesheet" type="text/css">
        <script src="<?php echo JS_PATH; ?>jquery.js"></script>
        <script src="<?php echo JS_PATH; ?>docs.min.js"></script>	
        <script src="<?php echo JS_PATH; ?>jquery.dataTables.min.js"></script>
        <script src="<?php echo JS_PATH; ?>zabuto_calendar.js"></script>
        <script src="<?php echo JS_PATH; ?>bootstrap-datetimepicker.js"></script>
        <link href="<?php echo CSS_PATH; ?>sidebar.css" rel="stylesheet" type="text/css">
        <link href="<?php echo CSS_PATH; ?>jquery-ui.min.css" rel="stylesheet" type="text/css">
        <link href="<?php echo CSS_PATH; ?>jquery-ui.theme.min.css" rel="stylesheet" type="text/css">
        <link href="<?php echo CSS_PATH; ?>fullcalendar.print.css" rel="stylesheet" media="print">
        <link href="<?php echo CSS_PATH; ?>fullcalendar.css" rel="stylesheet" type="text/css">
        <link href="<?php echo CSS_PATH; ?>zabuto_calendar.css" rel="stylesheet" type="text/css">
        <link href="<?php echo CSS_PATH; ?>bootstrap-datetimepicker.css" rel="stylesheet" type="text/css">
        
        <link href="<?php echo CSS_PATH; ?>font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="<?php echo CSS_PATH; ?>froala_editor.min.css" rel="stylesheet" type="text/css">
        <link href="<?php echo CSS_PATH; ?>froala_style.min.css" rel="stylesheet" type="text/css">
        
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
    
    <script src="<?php echo JS_PATH; ?>bootstrap.min.js"></script>
    <!-- library for jquery ui -->
    <script src="<?php echo JS_PATH; ?>jquery-ui.min.js"></script>
    <!-- library for jquery validation -->
    <script src="<?php echo JS_PATH; ?>jquery.validate.min.js"></script>
    <!-- library for cookie management -->
    <script src="<?php echo JS_PATH; ?>jquery.cookie.js"></script>
    <!-- calender plugin -->
    <script src="<?php echo JS_PATH; ?>moment.min.js"></script>
    <script src="<?php echo JS_PATH; ?>fullcalendar.min.js"></script>
    <!-- select or dropdown enhancer -->
    <script src="<?php echo JS_PATH; ?>chosen.jquery.min.js"></script>
    <!-- plugin for gallery image view -->
    <script src="<?php echo JS_PATH; ?>jquery.colorbox-min.js"></script>
    <!-- for iOS style toggle switch -->
    <script src="<?php echo JS_PATH; ?>jquery.iphone.toggle.js"></script>
    <!-- star rating plugin -->
    <script src="<?php echo JS_PATH; ?>jquery.raty.min.js"></script>
    <!-- multiple file upload plugin -->
    <script src="<?php echo JS_PATH; ?>jquery.uploadify-3.1.min.js"></script>
    <!-- application script for Charisma demo -->
    <script src="<?php echo JS_PATH; ?>charisma.js"></script>
    <!-- history.js for cross-browser state change on ajax -->
    <script src="<?php echo JS_PATH; ?>jquery.history.js"></script>
    
    <!-- text area editor -->
    <script src="<?php echo JS_PATH; ?>froala_editor.min.js"></script>
    <script src="<?php echo JS_PATH; ?>tables.min.js"></script>

    <script src="<?php echo JS_PATH; ?>jquery.MyThumbNail.js"></script>
    
    </body>
        
