<!DOCTYPE HTML>
<html lang="en">

    <head>
        <!-- TODO: constants -->
        <title>IKnowWelding</title>
        <!-- Define Charset -->
        <meta charset="utf-8">
        <!-- Responsive Metatag -->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <!-- Page Description and Author -->
        <meta name="description" content="Welcome to IknowWelding - A social networking website exclusively open to all welding professionals who are working in the welding industry from very simple welding job to the most advance and complex welding works including the design, production and quality control. ">
        <meta name="keywords" content="welding, social network, ranking, welder">
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
    </head>
    <body>

        <!-- Full Body Container -->
        <div id="container">
            <!-- Start Header Section -->
         <header id="header-wrap" class="site-header clearfix">
                 <!--Start Top Bar--> 
                <div class="top-bar hidden-xs">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-7 col-sm-9">

                                 <!--End Contact Info--> 
                            </div>
                            <div class="col-md-5 col-sm-3">
                                 <!--Start Social Links--> 
                                <form id="form-login" method="post" action="<?php echo site_url('login/check'); ?>" data-parsley-validate>
                                    <ul class="social-list">
                                        <li>
                                            <input type="text" name="username" id="username" data-parsley-trigger="change" required="required" placeholder="Email address or Username" />
                                        </li>
                                        <li>
                                            &nbsp;
                                        </li>
                                        <li>
                                            &nbsp;
                                        </li>
                                        <li>
                                            &nbsp;
                                        </li>
                                        <li>
                                            &nbsp;
                                        </li>
                                        <li>
                                            <input type="password" name="password" id="password" data-parsley-trigger="change" required="required" placeholder="Password" />
                                        </li>
                                        <li>
                                            <div class="col-md-4 col-sm-4">
                                                <input class="btn btn-border btn-login" type="submit" value="Sign in" />
                                            </div>
                                        </li>
                                    </ul>
                                </form>
                                 <!--End Social Links--> 
                            </div>
                        </div>
                    </div>
                </div>
                 <!--End Top Bar--> 
                 <!--Start  Logo & Navigation-->  
                <div class="navbar navbar-default navbar-top" role="navigation" data-spy="affix" data-offset-top="50">
                    <div class="container">
                         <!--Brand and toggle get grouped for better mobile display--> 
                        <div class="navbar-header">
                             <!--Stat Toggle Nav Link For Mobiles--> 
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>
                          <!--Brand and toggle menu for mobile ends-->  

                        <div class="navbar-collapse collapse">

                            <ul class="nav navbar-nav navbar-left" id="marquee-txt">
                                <li>
                                    <a class="marquee" href="index.html">
                                        TELL US YOU KNOW ABOUT WELDING AND WE WILL TELL THE WORLD
                                    </a>
                                </li>
                            </ul>
                             <!--Start Navigation List--> 
                            <ul class="nav navbar-nav navbar-right">
                                <li>
                                <li>
                                    <a class="active" href="<?php echo site_url('/home'); ?>">
                                        Home
                                    </a>
                                </li>
                                <?php
                                if ($menu):
                                    foreach ($menu as $m):
                                        echo "<li>
								  <a href='" . site_url('/menu/' . $m['page_name']) . "'>
								  " . $m['title'] . "
								  </a>
								</li>";
                                    endforeach;
                                endif;
                                ?>
                            </ul>
                             <!--End Navigation List--> 
                        </div>
                    </div>

                     <!--Mobile Menu Start--> 
                    <ul class="wpb-mobile-menu">
                        <li>
                            <?php
                            if ($menu):
                                foreach ($menu as $m):
                                    echo "<li>
							  <a href='" . get_base_url() . $m['link'] . "'>
							  " . $m['name'] . "
							  </a>
							</li>";
                                endforeach;
                            else:
                                ?>
                            <li>
                                <a class="active" href="/home">
                                    Home
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                     <!--Mobile Menu End--> 

                </div>
                 <!--End Header Logo & Navigation -->
                <div class="clearfix"></div>
             <!--End Header Section--> 
        </header>

        <!-- For other status alert -->
        <div id="alert-modal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form>
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span> <span class="sr-only">close</span></button>
                            <h4 id="alert-modal-title" class="modal-title"></h4>
                        </div>
                        <div class="modal-body">
                            <div id="user-info-alert-msg"></div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-default" onclick="javascript:refresh_page()">OK</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>