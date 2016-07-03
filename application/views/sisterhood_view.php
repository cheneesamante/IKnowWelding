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
    <div class="row">
        <div class="templatemo-slogan text-center">
            <span class="txt_orange"> <?php echo $city["city_name"]; ?> </span>
	</div>
	<div class="col-sm-4 col-md-4">
            <img src="<?php echo CITY_IMG_PATH.$city["city_img"]; ?>">
	</div>
	<div class="col-sm-4 col-md-4">
            <?php echo $city["city_description"];?>
	</div>
	
    </div>
    <div id="location-canvas" style="margin-top:50px; width:100%;height:300px;"></div>
</div>

<script src="https://maps.googleapis.com/maps/api/js"></script>
    <script>
    function initialize() {
        var mapOptions = {
            zoom: 16, //zoom level, 0 = earth view to higher value
            center: new google.maps.LatLng(<?php echo $city["lat"]; ?>, <?php echo $city["lng"]; ?>),
            mapTypeId: google.maps.MapTypeId.ROADMAP
         };

         var map = new google.maps.Map(document.getElementById('location-canvas'),
    mapOptions);

        var marker = new google.maps.Marker({
            map: map,
            draggable: false,
            position: new google.maps.LatLng(<?php echo $city["lat"]; ?>, <?php echo $city["lng"]; ?>)
        });

        var infowindow = new google.maps.InfoWindow({ // Create a new InfoWindow
            content:"<h4>Sisterhood City in <?php echo $city["city_name"]; ?> </h4>" // HTML contents of the InfoWindow
        });

        infowindow.open(map,marker); // Open our InfoWindow
    }
 
    google.maps.event.addDomListener(window, 'resize', initialize);
    google.maps.event.addDomListener(window, 'load', initialize);
    </script>

