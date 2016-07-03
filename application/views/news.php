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
        <link href="<?php echo CSS_PATH; ?>style.css" rel="stylesheet" >
        <link href="<?php echo CSS_PATH; ?>font-awesome.min.css" rel="stylesheet" type="text/css">
        <!-- Custom styles for this template -->
        <link href="<?php echo CSS_PATH; ?>colorbox.css"  rel="stylesheet" type="text/css">
        <link href="<?php echo CSS_PATH; ?>templatemo_style.css"  rel="stylesheet" type="text/css">
    </head>
    <body>
        <div>
<div class="container panel">
                <p> </p>    
    <div class="row">
                    <div class="pull-left">
                        <a class="btn btn-blue" href="<?php echo site_url(); ?>#news" 
                           role="button">BACK</a>
                    </div>
        <div class="templatemo-line-header">
            <div class="text-center">
                <hr class="team_hr team_hr_left hr_gray"/><span class="txt_darkgrey">NEWS</span>
                <hr class="team_hr team_hr_right hr_gray" />
            </div>
        </div>
        <div class="clearfix"></div>
    </div> <!-- /.row -->
    <div class="row">
        
        <div class="templatemo-slogan">
            <h2> <?php echo strtoupper($news["news_title"]); ?> </h2>  
            <div class="caption">
                            <p class="txt_slogan" style="padding-top:0px"><i class="glyphicon glyphicon-calendar"></i> Posted on: 
                    <?php echo date("F j, Y", strtotime($news["news_date"])); ?>  </p>
            <hr></div>
        
	</div>
                        <div class="img-responsive text-center">
        <?php if (isset($news["news_img"])){ ?>
            <img src="<?php echo NEWS_IMG_PATH.$news["news_img"]; ?>" style="margin-right: 20px;">
                    <?php } ?>
	</div>
                    <div class="templatemo-service-item">
                        <p> <?php echo $news["news_body"]; ?> </p> </div>

    </div>
                <div class="clearfix"></div>
                <hr>
                <div class="pull-left">
                    <a class="btn btn-blue" href="<?php echo site_url(); ?>#news" 
                       role="button">BACK</a>
                </div>
</div>


        </div>
    </body>
</html>
