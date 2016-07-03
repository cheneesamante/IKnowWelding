</div>
    <div class="templatemo-footer" >
            <div class="container">
                <?php if(!isset($this->session->userdata('menu')['who'])){ ?>
                <div class="row"> 
                    <div class="text-center">
                        <div class="footer_container">
                            <ul class="nav navbar-nav list-inline">
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
                                        <?php echo strtoupper($val_menu[0]); ?> 
                                    </a>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                    </div>
                </div>
                <?php } ?>
                <div class="row">
                    <div class="text-center">

                        <div class="footer_container">
                            <div class="height30 footer_container"></div>
                        </div>
                        <div class="footer_bottom_content">
                            <?php 
                            $copyright = 'Copyright &copy 2014 <a href="#"> Sisterhood - Portal </a>' ;
                            if(isset($this->session->userdata('menu')['who'])){
                                    echo '<hr>';
                            }
                            echo $copyright;
                            ?>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
</body>
</html>
<script>
	$(function(){
	  $('.textarea-custom').editable({placeholder: '', inlineMode: false, buttons: ['undo', 'redo', 'sep', 'bold', 'italic', 'underline', 'strikeThrough', 'sep',
	  'fontSize', 'table', 'createLink', 'formatBlock', 'align', 'insertOrderedList', 'insertUnorderedList', 'sep', 'outdent', 'indent', 'selectAll',
	  'formatBlock', 'alert', 'clear', 'color' ]});		  
	});	
	
	
	<?php
	if(!isset($this->session->userdata('info')['first_name'])){
    ?>
        $("#sisterhood-city-thumbnail img").MyThumbnail({
            thumbWidth:185,
            thumbHeight:120,
            backgroundColor:"#ccc",
            imageDivClass:"sisterhood"
        });
        $("#program-list img").MyThumbnail({
            thumbWidth:360,
            thumbHeight:230,
            backgroundColor:"#ccc",
            imageDivClass:"program"
        });
        
        $("#news-preview img").MyThumbnail({
            thumbWidth:150,
            thumbHeight:150,
            backgroundColor:"#ccc",
            imageDivClass:"news"
        });
        
        $("#extruderTop").buildMbExtruder({
            positionFixed:false,
            width:350,
            extruderOpacity:1,
            //autoCloseTime:4000,
            closeOnExternalClick:false,
            hidePanelsOnClose:false,
            onExtOpen:function(){},
            onExtContentLoad:function(){},
            onExtClose:function(){}
          });
      
        $(document).ready(function() {
            $('.pgwSlider').pgwSlider({maxHeight : 200});
        });
		
        
		
	<?php
	}
    ?>
        
        $('.modal') 
	.on('shown', function(){ 
	  $('body').css({overflow: 'hidden'}); 
	}) 
	.on('hidden', function(){ 
	  $('body').css({overflow: ''}); 
	});
        
        $("#sisterhood-city-preview img").MyThumbnail({
            thumbWidth:250,
            thumbHeight:230,
            backgroundColor:"#ccc",
            imageDivClass:"image_preview"
        });

</script>	
