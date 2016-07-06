      <!-- Start Footer Section -->
      <footer>
        <div class="container">
          <div class="row footer-widgets">
            <!-- Start Contact Widget -->
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="footer-widget contact-widget">
                <h4>
                  ABOUT US
                </h4>
                <p class="txt-justified">
					UNIQUE FROM OTHER SOCIAL NETWORK WEBSITE. 
					THIS WEBSITE IS DESIGN TO PROVIDE AUTOMATIC STAR RANKING BASED ON THE INFORMATION YOU PROVIDED AFTER
					COMPLETING YOUR ONLINE PROFILE.
				</p>
				<p>LEARN THE CRITERIA FOR RANKING <a>HERE</a>.</p>
              </div>
            </div>
            <!-- End Contact Widget -->

            
			<div class="col-md-1 col-sm-3 col-xs-5"></div>
            <!-- Start Address Widget -->
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="footer-widget">
                <h4>
                  OUR CONTACT
                </h4>
                <ul class="address">
                  <li>
                    <a href="#"><i class="fa fa-envelope"></i> EMAIL: info@iknowwelding.com</a>
					<a href="#"><i class="fa"></i> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;
					&nbsp; &nbsp; &nbsp; &nbsp; support@iknowwelding.com</a>
                  </li>
                </ul>
              </div>
            </div>
            <!-- End Address Widget -->

			<div class="col-md-1 col-sm-3 col-xs-5"></div>
            <!-- Start Text Widget -->
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="footer-widget hours-widget">
                <h4>
                  PRIVACY
                </h4>
              </div>
            </div>
            <!-- End Text Widget -->

          </div>
          <!-- .row -->        
        </div>
      </footer>
      <!-- End Footer Section -->

      <!-- Start Copyright -->
      <div class="copyright-section">
        <div class="container">
          <div class="row">
            <div class="col-sm-12">
              <p>
                Copyright &copy; 2015 IKnowWelding 
				<!-- - Designed & Developed by 
                <a href="http://graygrids.com"> 
                GrayGrids -->
                </a>
              </p>
            </div>
          </div>
          <!-- .row -->
        </div>
      </div>
      <!-- End Copyright -->
    </div>
    <!-- End Full Body Container -->
	
	    <!-- Go To Top Link -->
    <a href="#" class="back-to-top">
      <i class="fa fa-angle-up"></i>
    </a>

    <!-- Start Loader -->
    <div id="loader">
      <div class="square-spin">
        <div></div>
      </div>
    </div>
	
	   
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
</html>
<script>
	$(function() {
		$('[data-toggle="popover"]').popover();
		$('#div-list-join').hide();
		$('.btn-join').click(function () {
			if($('#div-list-join').is(":visible")){
				$('#div-list-join').fadeOut('slow');
			} else {
				$('#div-list-join').hide();
				$('.btn-join').animate('slow',function(){
					$('#div-list-join').fadeIn('slow');
				});
			}
				
		});
		
	});
</script>
