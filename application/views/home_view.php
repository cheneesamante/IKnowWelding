
    <div class="templatemo-welcome" id="templatemo-welcome">
        <div class="container">
            <div class="templatemo-slogan text-center">
                <span class="txt_darkgrey">Welcome to </span><span class="txt_orange">Sisterhood Portal</span>
                <div>
                    <p class="txt_slogan"> </p>
                <p class="txt_slogan">
                        The City of Makati is one of the cities that comprise the Metropolitan Manila.
                </p>
                <p class="txt_slogan"> 
                        It is the financial capital of the Philippines filled with gigantic buildings, condominiums, five-star hotels, major banks, corporations, department stores as well as foreign embassies. Makati is also known for being a major cultural and entertainment centre in Metro Manila.
                    The local government of Makati has been in existence for 344 years.  It was transformed from a municipality into a highly urbanized city on January 2, 1995 through Republic Act 7854 with the great support of the residents in a plebiscite held on February 4, 1995.  The reforms implemented by the Mayor are in line with its thrust of installing a local government that is efficient, effective and responsive in delivering the essential services to all Makati constituents.
                </p>
                <p class="txt_slogan">
                        The sisterhood agreement is one of the projects of the Hon. Jejomar C. Binay who was then the mayor of Makati, now the Vice President of the Philippines. A sister city, municipality relationship becomes official with the signing of a formal agreement by the top elected officials approving a long-term partnership between the two communities. Sister city or municipality relationship between Makati, Metro Manila and other provinces and even foreign countries is continuously expanding through the efforts of Hon. Mayor Jejomar Erwin S. Binay, Jr. It aims to further involve the widest possible diversity of exchanges and projects, such as health care, education, economics and business development.  Another is academic exchanges of students whereby they can avail the privileges enjoyed by Makati residents.
                    The benefits of the sister city or municipality relationship include the following: an air of global perspective with a feeling of welcoming, relax, and at ease visiting various locations of the city, provision of free accommodations by the Makati City government in the Friendship Suite, and an escort service upon their arrival from the airport to the place of their destination and until departure.
                    Sisterhood agreement merely establishes friendship ties through sharing of experiences and best practices in areas of common interest.

                </p>
                </div>
            </div>	
        </div>
    </div>

    <div id="0004" class="templatemo-service">
        <div class="container">
            <?php if(isset($sisterhood)){ ?>
            <?php $ctr = 0; ?>
             <?php foreach($sisterhood as $program_info=>$program_val): ?>
             <?php $ctr++; ?>
                                
            <div class="row" id="program-list">
                <div class="col-sm-5 col-md-6">
                    <div class="templatemo-service-item">
                        <div>
                            <?php if($ctr == 1){ ?>
                            <img style="margin-right: 20px" src="bootstrap/img/program-1.jpg" />
                            <?php } else if ($ctr == 2){ ?>
                            <img src="bootstrap/img/program-2.jpg" />
                            <?php } ?>
                            <br/>
                        </div>
                    </div>
                    <br style="clear:both" >
                    <div class="templatemo-service-item">
                    <span class="templatemo-service-item-header" style="clear:both;"><?php echo $program_val["title"]; ?></span>
                    <p> <?php echo $program_val["body"]; ?> </p>
                    </div>
                    <div class="clearfix"></div>
                     
                </div>
                 <?php endforeach; 
                 } 
                 if (count($sisterhood) == 0) {?>
                    <span class="blog_header"> No Contents Available </span>
                    <?php } ?>
            </div>
        </div>
    </div>

    <div id="sisterhood">
            <div class="container">
                <div class="row">
                    <div class="templatemo-line-header" >
                        <div class="text-center">
                            <hr class="team_hr team_hr_left hr_gray"/><span class="txt_darkgrey">SISTER CITIES</span>
                            <hr class="team_hr team_hr_right hr_gray" />
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div> <!-- /.row -->

                
                <div class="clearfix"></div>
                <div class="text-center" id="sisterhood-city-thumbnail">
                    <ul class="templatemo-project-gallery" >
                        <?php foreach($cities as $city=>$city_val): ?>
                        <li class="col-lg-2 col-md-2 col-sm-2">
                            <a href="<?php echo site_url('common/pages/sister_cities/'.$city_val["city_id"]); ?>">
                                <div class="templatemo-project-box">
                                    <img src="<?php echo CITY_IMG_PATH.$city_val["city_img"]; ?>" class="img-responsive" />
                                    <div class="project-overlay">
                                        <h5><?php echo $city_val["city_name"]; ?></h5>
                                        <hr />
                                    </div>
                                </div>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul><!-- /.gallery -->
                </div>
                <div class="clearfix"></div>
                <?php
                 if (count($cities) == 0) {?>
                    <span class="blog_header"> No Contents Available </span>
                    <?php } ?>
            </div><!-- /.container -->
        </div> <!-- /.templatemo-portfolio -->

        <div id="events" class="tabs-item">
            <div class="container">
                <div class="row">
                    <div class="templatemo-line-header head_contact">
                        <div class="text-center">
                            <hr class="team_hr team_hr_left hr_gray"/><span class="txt_darkgrey">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;EVENTS&nbsp;&nbsp;&nbsp;&nbsp;</span>
                            <hr class="team_hr team_hr_right hr_gray" />
                        </div>
                    </div>
                    
                </div> <!-- /.row -->
                <div class="center-block" style="max-width:600px;">
                <div id="calendar"></div>
                    <?php  $this->load->view('events_view'); ?>
                    
                </div>
                
                <div class="clearfix"></div>
            
        </div>
            
            </div>
        
        <div id="news">
            <div class="container">
                <div class="row">
                    <div class="templatemo-line-header" style="margin-top: 0px;" >
                        <div class="text-center">
                            <hr class="team_hr team_hr_left hr_gray"/><span class="span_blog txt_darkgrey">NEWS</span>
                            <hr class="team_hr team_hr_right hr_gray" />
                        </div>
                    </div>
                    <br class="clearfix"/>
                </div>
                
                <div class="blog_box">
                    <?php if(isset($news)){ ?>
                    <?php foreach($news as $news_info=>$news_val): ?>
                    <div class="col-sm-5 col-md-6 blog_post">
                        <ul class="list-inline">
                            <li class="col-md-4">
                                <?php if(isset($news_val["news_img"])): ?>
                                <a>
                                    <img class="img-responsive" src="<?php echo NEWS_IMG_PATH.$news_val["news_img"]; ?>" />
                                </a>
                                <?php endif; ?>
                            </li>
                            <li  class="col-md-8">
                                <div class="pull-left">
                                    <span class="blog_header"><?php echo strtoupper($news_val["news_title"]); ?></span><br/>
                                    <span>Posted on : <?php echo date("F j, Y", strtotime($news_val["news_date"])); ?> </span>
                                </div>

                                <div class="clearfix"> </div>
                                <p class="blog_text">
                                    <?php echo substr(strip_tags($news_val["news_body"]), 0, 75); ?>
                                    <?php echo strlen(strip_tags($news_val["news_body"])) > 75 ? '[...]' : '' ; ?>
                                </p>
                                <div class="pull-right">
                                    <a class="btn btn-blue" href="<?php echo site_url('common/pages/news/'.$news_val["news_id"]); ?>" 
                                       role="button">READ MORE>>></a>
                                </div>
                            </li>
                        </ul>
                    </div> <!-- /.blog_post 1 -->
                    <?php endforeach; 
                    } 
                    if (count($news) == 0) { ?>
                    <span class="blog_header"> No News Available </span>
                    <?php } ?>
                </div>
            </div>
        </div>
        
       
</div>
