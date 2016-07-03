<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyC6_YwKc1ghybI4ve-W022ERzrWYM8ISt4&sensor=false"></script>
<script>
    $(document).ready(function() {
        $('#city_description').editable({
            // Set the image upload URL.
            inlineMode: false,
            imageUploadURL: "<?php echo site_url('admin/cms/image_uploading'); ?>"
        })
        $('#body_description').editable({
            // Set the image upload URL.
            inlineMode: false,
            imageUploadURL: "<?php echo site_url('admin/cms/image_uploading'); ?>"
        })
        $('#cms_body').editable({
            // Set the image upload URL.
            inlineMode: false,
            imageUploadURL: "<?php echo site_url('admin/cms/image_uploading'); ?>"
        })
        $('#largeModal').hide();
        $('#largeModal-update-cms').hide();
        $('#largeModal-active-inactive-cms').hide();
        $('#largeModal-alert-page-active-cms').hide();

        $('#form-add').submit(function(e) {

            e.preventDefault();
            var body = $('.textarea-custom').editable('getText')[0];

            if (body != "") {
                var frm = $('#form-add').serialize();
                body = $('#cms_body').editable('getHTML');
                var title = $('#title').val();
                var page = $('#page_id').children(":selected").attr("id");
                var msg = '<div class="alert alert-danger">Failed to insert data.</div>';
                $('#largeModal').modal('hide');
                $('#processing-modal').modal();
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('admin/cms/save'); ?>",
                    data: frm + "&bodytext=" + encodeURIComponent(body) + "&title=" + title + "&page=" + page
                }).done(function(data) {
                    $('#processing-modal').modal('hide');
                    if (data == 1) {
                        $('#form-add')[0].reset();
                        msg = '<div class="alert alert-success">Successfully saved.</div>';
                    }
                    $('#form-add')[0].reset();
                    $('#alert-modal-title').html('Add CMS');
                    $('#user-info-alert-msg').html(msg);
                    $('#alert-status').modal();
                    /*$('#add-msg').html(msg);
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);*/
                });
                return false;
            }
        });

        $(".modal-wide").on("show.bs.modal", function() {
            var height = $(window).height() - 200;
            $(this).find(".modal-body").css("max-height", height);
        });

        $('input[type=date]').datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            maxDate: new Date
        });
//add sisterhood

        $("#uploadimage3").on('submit', (function(e) {
            e.preventDefault();
            $("#message3").empty();
            $('#processing-modal').modal();
            $.ajax({
                url: "<?php echo site_url('admin/cms/image_upload/3'); ?>", // Url to which the request is send
                type: "POST", // Type of request to be send, called as method
                data: new FormData(this),// Data sent to server, a set of key/value pairs representing form fields and values 
                contentType: false, // The content type used when sending data to the server. Default is: "application/x-www-form-urlencoded"
                cache: false, // To unable request pages to be cached
                processData: false, // To send DOMDocument or non processed data file it is set to false (i.e. data should not be in the form of string)
                success: function(data)  		// A function to be called if request succeeds
                {
                    $('#processing-modal').modal('hide');
                    $("#message3").html(data);
                }
            });
        }));
//add city
        $("#uploadimage").on('submit', (function(e) {
            e.preventDefault();
            $("#message").empty();
            $('#processing-modal').modal();
            $.ajax({
                url: "<?php echo site_url('admin/cms/image_upload/1'); ?>", // Url to which the request is send
                type: "POST", // Type of request to be send, called as method
                data: new FormData(this),// Data sent to server, a set of key/value pairs representing form fields and values 
                contentType: false, // The content type used when sending data to the server. Default is: "application/x-www-form-urlencoded"
                cache: false, // To unable request pages to be cached
                processData: false, // To send DOMDocument or non processed data file it is set to false (i.e. data should not be in the form of string)
                success: function(data)  		// A function to be called if request succeeds
                {
                    $('#processing-modal').modal('hide');
                    $("#message").html(data);
                }
            });
        }));
//add news
        $("#uploadimage2").on('submit', (function(e) {
            e.preventDefault();
            $("#message2").empty();
            $('#processing-modal').modal();
            $.ajax({
                url: "<?php echo site_url('admin/cms/image_upload/2'); ?>", // Url to which the request is send
                type: "POST", // Type of request to be send, called as method
                data: new FormData(this), // Data sent to server, a set of key/value pairs representing form fields and values 
                contentType: false, // The content type used when sending data to the server. Default is: "application/x-www-form-urlencoded"
                cache: false, // To unable request pages to be cached
                processData: false, // To send DOMDocument or non processed data file it is set to false (i.e. data should not be in the form of string)
                success: function(data)  		// A function to be called if request succeeds
                {
                    $('#processing-modal').modal('hide');
                    $("#message2").html(data);
                }
            });
        }));
        //update city image
        $("#uploadimage_update").on('submit', (function(e) {
            e.preventDefault();
            $("#message_update").empty();
            $('#processing-modal').modal();
            $.ajax({
                url: "<?php echo site_url('admin/cms/image_upload_update/1'); ?>", // Url to which the request is send
                type: "POST", // Type of request to be send, called as method
                data: new FormData(this), // Data sent to server, a set of key/value pairs representing form fields and values 
                contentType: false, // The content type used when sending data to the server. Default is: "application/x-www-form-urlencoded"
                cache: false, // To unable request pages to be cached
                processData: false, // To send DOMDocument or non processed data file it is set to false (i.e. data should not be in the form of string)
                success: function(data)  		// A function to be called if request succeeds
                {
                   $('#processing-modal').modal('hide');
                    $("#message_update").html(data);
                }
            });
        }));
        //update news image
        $("#uploadimage_update2").on('submit', (function(e) {
            e.preventDefault();
            $("#message_update2").empty();
            $('#processing-modal').modal();
            $.ajax({
                url: "<?php echo site_url('admin/cms/image_upload_update/2'); ?>", // Url to which the request is send
                type: "POST", // Type of request to be send, called as method
                data: new FormData(this), // Data sent to server, a set of key/value pairs representing form fields and values 
                contentType: false, // The content type used when sending data to the server. Default is: "application/x-www-form-urlencoded"
                cache: false, // To unable request pages to be cached
                processData: false, // To send DOMDocument or non processed data file it is set to false (i.e. data should not be in the form of string)
                success: function(data)  		// A function to be called if request succeeds
                {
                    $('#processing-modal').modal('hide');
                    $("#message_update2").html(data);
                }
            });
        }));
//        $('#form-add-city').submit(function(e) {
        $("#form-add-city").on('submit', (function(e) {
            e.preventDefault();

//            if ($(this).data('bootstrapValidator').isValid()) {
            // var frm = $('#form-add-city').serialize();
            var city_name = $('#city_name').val();
            var frm = $('#form-add').serialize();
            var city_description = $('#city_description').editable('getHTML');

            var msg = '<div class="alert alert-danger">Failed to insert data.</div>';

            $.ajax({
                type: "POST",
                url: "<?php echo site_url('admin/cms/save_city'); ?>",
                data: frm + "&city_name=" + city_name + "&city_description=" + encodeURIComponent(city_description),
            }).done(function(data) {
                if (data == 1 || data == true) {
                    $('#form-add-city')[0].reset();
                    msg = '<div class="alert alert-success">Successfully saved.</div>';
                    $('#add-city-error-message').html(msg);
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                } else if (data == 2){
                     msg = '<div class="alert alert-danger">Failed to insert data. <p> City name is required. </p></div>';
                } else if (data == 3){
                     msg = '<div class="alert alert-danger">Failed to insert data. <p> City image is required, Please upload a city image. </p></div>';   
                } else {
                     msg = '<div class="alert alert-danger">Failed to insert data. <p>' + data + '</p></div>';
                }
                    $('#add-city-error-message').html(msg);
            });
            return false;
//            }
        }));

        $("#form-add-news").on('submit', (function(e) {
            e.preventDefault();

            var frm = $('#form-add-news').serialize();
            var body = $('#news_body').editable('getHTML');

            var msg = '<div class="alert alert-danger">Failed to insert data.</div>';
            $('#largeModal-news').modal('hide');
            $('#processing-modal').modal();
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('admin/cms/save_news'); ?>",
                data: frm + "&body=" + encodeURIComponent(body),
            }).done(function(data) {
                $('#processing-modal').modal('hide');
                if (data == 1 || data == true) {
                    $('#form-add-news')[0].reset();
                    msg = '<div class="alert alert-success">Successfully saved.</div>';
                } else {
                    msg = '<div class="alert alert-danger">Failed to insert data. <p>' + data + '</p></div>';
                }
                $('#alert-modal-title').html('Add News');
                $('#user-info-alert-msg').html(msg);
                $('#alert-status').modal();

            });
            return false;
        }));

        $("#form-update-city").on('submit', (function(e) {
            e.preventDefault();

//            if ($(this).data('bootstrapValidator').isValid()) {

            var city_name = $('#update_city_name').val();
            var frm = $('#form-update-city').serialize();
            var city_description = $('#city_update_description').editable('getHTML');

            var msg = '<div class="alert alert-danger">Failed to insert data.</div>';
            $('#largeModal-update-sistercity').modal('hide');
            $('#processing-modal').modal();
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('admin/cms/update_city'); ?>",
                data: frm + "&city_name=" + city_name + "&city_description=" + encodeURIComponent(city_description),
            }).done(function(data) {
                $('#processing-modal').modal('hide');
                if (data == 1 || data == true) {
                    $('#form-update-city')[0].reset();
                    msg = '<div class="alert alert-success">Successfully saved.</div>';
                } else {
                    msg = '<div class="alert alert-danger">Failed to insert data. <p>' + data + '</p></div>';
                    $('#update-city-error-message').html(msg);
                }
                $('#alert-modal-title').html('Update Sister City Information');
                $('#user-info-alert-msg').html(msg);
                $('#alert-status').modal();
            });
            return false;
//            }
        }));

        $("#form-update-news").on('submit', (function(e) {
            e.preventDefault();
 
            var frm = $('#form-update-news').serialize();
            var news_description = $('#update_news_body').editable('getHTML');
            var msg = '<div class="alert alert-danger">Failed to insert data.</div>';
            $('#largeModal-update-news').modal('hide');
            $('#processing-modal').modal();
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('admin/cms/update_news'); ?>",
                data: frm + "&news_description=" + encodeURIComponent(news_description),
            }).done(function(data) {
                $('#processing-modal').modal('hide');
                if (data == 1 || data == true) {
                    $('#form-update-news')[0].reset();
                    msg = '<div class="alert alert-success">Successfully saved.</div>';
                } else {
                    msg = '<div class="alert alert-danger">Failed to insert data. <p>' + data + '</p></div>';
                }
                $('#alert-modal-title').html('Update News Information');
                $('#user-info-alert-msg').html(msg);
                $('#alert-status').modal();
            });
            return false;
        }));
        
        //For CMS table
        $('#cms_table').dataTable({
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": "<?php echo site_url('admin/cms/display_data'); ?>",
            "iDisplayStart": 0,
            "iDisplayLength": 10,
            "sPaginationType": "full_numbers",
            "autoWidth": true,
            "order": [[0, "desc"]],
            "bLengthChange": false,
            "aoColumnDefs": [
                {"bSortable": true, "aTargets": [0, 1, 2, 3]},
                {"bSortable": false, "aTargets": [4, 5]}
            ],
            "columnDefs": [
                {"width": "50%", "targets": 0}
            ],
            "aaSorting": [[0, "desc"]], // Sort by first column descending
            "fnServerData": function(sSource, aoData, fnCallback) {
                $.ajax(
                        {
                            'dataType': 'json',
                            'type': 'POST',
                            'url': sSource,
                            'data': aoData,
                            'success': fnCallback
                        }
                );
            }
        });
        //For sister cities table
        $('#sister_cities_table').dataTable({
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": "<?php echo site_url('admin/cms/display_cities_data'); ?>",
            "iDisplayStart": 0,
            "iDisplayLength": 10,
            "sPaginationType": "full_numbers",
            "autoWidth": true,
            "order": [[0, "desc"]],
            "bLengthChange": false,
            "aoColumnDefs": [
                {"bSortable": true, "aTargets": [0, 1, 2, 3, 4]},
                {"bSortable": false, "aTargets": [5, 6]}
            ],
            "columnDefs": [
                {"width": "50%", "targets": 0}
            ],
            "aaSorting": [[0, "desc"]], // Sort by first column descending
            "fnServerData": function(sSource, aoData, fnCallback) {
                $.ajax(
                        {
                            'dataType': 'json',
                            'type': 'POST',
                            'url': sSource,
                            'data': aoData,
                            'success': fnCallback
                        }
                );
            }
        });
        
        //For news table
        $('#news_table').dataTable({
            "bProcessing" : true,
            "bServerSide" : true,
            "sAjaxSource" : "<?php echo site_url('admin/cms/display_news_data'); ?>",
            "iDisplayStart" : 0,
            "iDisplayLength": 10,
            "sPaginationType": "full_numbers",
            "autoWidth": true,
            "order": [[ 0, "desc" ]],
            "bLengthChange": false,
            "aoColumnDefs": [
                {"bSortable": true, "aTargets": [0, 1, 2, 3]},
                {"bSortable": false, "aTargets": [4, 5]}
            ],
            "columnDefs": [
                {"width": "50%", "targets": 0}
            ],
            "aaSorting": [[0, "desc"]], // Sort by first column descending
            "fnServerData": function(sSource, aoData, fnCallback) {
                $.ajax(
                        {
                            'dataType': 'json',
                            'type': 'POST',
                            'url': sSource,
                            'data': aoData,
                            'success': fnCallback
                        }
                );
            }
        });
        
        
        //for the update 
        $('#form-update-cms').submit(function(e) {
            e.preventDefault();
            var body = $('.textarea-custom').editable('getText')[1];
            if (body == "") {
                $('#update-content-error-msg').html('* Body is required');
            } else {
                var frm = $('#form-update-cms').serialize();
                var body_text = $('#body_description').editable('getHTML');
                var page_id = $('#page_id_update').children(":selected").attr("id");
                var msg = '<div class="ajax-cms-update alert alert-danger">Failed to update.</div>';
                var title = $('#title_update').val();
                $('#largeModal-update-cms').modal('hide');
                $('#processing-modal').modal();
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('admin/cms/update_page'); ?>",
                    data: frm + "&body=" + encodeURIComponent(body_text) + "&title=" + title + "&page_id=" + page_id
                }).done(function(data) {
                    $('#processing-modal').modal('hide');
                    if (data == 1) {
                        msg = '<div class="ajax-cms-update alert alert-success">Successfully saved changes.</div>';
                    }
                    $('#form-update-cms')[0].reset();
                    $('#alert-modal-title').html('Update CMS');
                    $('#user-info-alert-msg').html(msg);
                    $('#alert-status').modal();
                    /*
                    $('#update-cms-msg').html(msg);
                    $('#form-update-cms')[0].reset();
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);*/
                });

            }
        });
        //For update user status
        $('#form-update-active-inactive-cms').submit(function(e) {
            e.preventDefault();
            var frm = $('#form-update-active-inactive-cms').serialize();
            var msg = '<div class="alert alert-danger">Failed to update.</div>';
            $('#largeModal-active-inactive-cms').modal('hide');
            $('#processing-modal').modal();
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('admin/cms/update_page_status'); ?>",
                data: frm
            }).done(function(data) {
                $('#processing-modal').modal('hide');
                if (data != 0) {
                    //$('#form-update-reg')[0].reset();
                    msg = '<div class="alert alert-success">Successfully saved changes.</div>';
                }

                $('#update-active-inactive-cms-msg').html(msg);
                $('#alert-modal-title').html('Update Status');
                $('#user-info-alert-msg').html(msg);
                $('#alert-status').modal();
            });

        });

        //For update sister city status
        $('#form-update-active-inactive-sistercity').submit(function(e) {
            e.preventDefault();
            var frm = $('#form-update-active-inactive-sistercity').serialize();
            var msg = '<div class="alert alert-danger">Failed to update.</div>';
            $('#largeModal-active-inactive-sistercity').modal('hide');
            $('#processing-modal').modal();
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('admin/cms/update_city_status'); ?>",
                data: frm
            }).done(function(data) {
                $('#processing-modal').modal('hide');
                if (data != 0) {
                    msg = '<div class="alert alert-success">Successfully saved changes.</div>';
                }
                $('#alert-modal-title').html('Update Sister City Status');
                $('#user-info-alert-msg').html(msg);
                $('#alert-status').modal();
            });
        });


    });
    
    function refresh_page() {
        setTimeout(function() {
            window.location.reload();
        }, 1000);
    }
    
    //google map start
    var mapCenter = new google.maps.LatLng(14.554610, 121.024559); //Google map Coordinates
    var map;
    function add_city() {
       $('#file').val('');
        map_initialize(); // initialize google map
    }

    function edit_city(lat, lng, city) {
        sister_city_map(lat, lng, city);
    }

    //############### Google Map Initialize ##############
    function sister_city_map(lat, lng, city)
    {
        var googleMapOptions =
                {
                    center: new google.maps.LatLng(lat, lng), // map center
                    zoom: 17, //zoom level, 0 = earth view to higher value
                    maxZoom: 18,
                    minZoom: 16,
                    zoomControlOptions: {
                        style: google.maps.ZoomControlStyle.SMALL //zoom control size
                    },
                    scaleControl: true, // enable scale control
                    mapTypeId: google.maps.MapTypeId.ROADMAP // google map type
                };

        map = new google.maps.Map(document.getElementById("edit_map"), googleMapOptions);

        //Load Markers from the XML File, Check (map_process.php)
        $.get("<?php echo site_url('admin/cms/map_process'); ?>", function(data) {
            $(data).find("marker").each(function() {
                var name = $(this).attr('name');
                var address = '<p>' + $(this).attr('address') + '</p>';
                var city = $(this).attr('city');
                var point = new google.maps.LatLng(parseFloat($(this).attr('lat')), parseFloat($(this).attr('lng')));
                create_marker(point, name, address, city, false, false, false, "<?php echo base_url(); ?>/bootstrap/img/pin_blue.png");
            });
        });

        //Right Click to Drop a New Marker
        google.maps.event.addListener(map, 'rightclick', function(event) {
            //Edit form to be displayed with new marker
            var EditForm = '<p><div class="marker-edit">' +
                    '<form method="POST" name="SaveMarker" id="SaveMarker">' +
                    '<label for="pName"><span>Place Name :</span><input type="text" name="pName" class="save-name" placeholder="Enter Title" maxlength="40" /></label>' +
                    '<label for="pDesc"><span>Description :</span><textarea name="pDesc" class="save-desc" placeholder="Enter Address" maxlength="150"></textarea></label>' +
                    '<label for="pCity"><span>City Name :</span><input type="text" name="pCity" class="save-city" placeholder="Enter City" maxlength="40" /></label>' +
                    '</form>' +
                    '</div></p><button name="save-marker" class="save-marker">Save Marker Details</button>';

            //Drop a new Marker with our Edit Form
            create_marker(event.latLng, 'New Marker', EditForm, '', true, true, true, "<?php echo base_url(); ?>/bootstrap/img/pin_blue.png");
        });
        var markers = [];

        if (city != null || city != undefined) {
            document.getElementById('city_map_addr').value = city;
        }
        // Create the search box and link it to the UI element.
        var input = /** @type {HTMLInputElement} */(
                document.getElementById('city_map_addr'));
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        var searchBox = new google.maps.places.SearchBox(
                /** @type {HTMLInputElement} */(input));

        // Listen for the event fired when the user selects an item from the
        // pick list. Retrieve the matching places for that item.
        google.maps.event.addListener(searchBox, 'places_changed', function() {
            var places = searchBox.getPlaces();

            if (places.length == 0) {
                return;
            }
            for (var i = 0, marker; marker = markers[i]; i++) {
                marker.setMap(null);
            }

            // For each place, get the icon, place name, and location.
            markers = [];
            var bounds = new google.maps.LatLngBounds();
            for (var i = 0, place; place = places[i]; i++) {
                var image = {
                    url: place.icon,
                    size: new google.maps.Size(71, 71),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(17, 34),
                    scaledSize: new google.maps.Size(25, 25)
                };

                // Create a marker for each place.
                var marker = new google.maps.Marker({
                    map: map,
                    icon: image,
                    title: place.name,
                    position: place.geometry.location
                });

                markers.push(marker);

                bounds.extend(place.geometry.location);
            }

            map.fitBounds(bounds);
        });

        // Bias the SearchBox results towards places that are within the bounds of the
        // current map's viewport.
        google.maps.event.addListener(map, 'bounds_changed', function() {
            var bounds = map.getBounds();
            searchBox.setBounds(bounds);
        });
//google.maps.event.addDomListener(window, 'load', map_initialize);						
    }

    //############### Google Map Initialize ##############
    function map_initialize()
    {
        var googleMapOptions =
                {
                    center: mapCenter, // map center
                    zoom: 17, //zoom level, 0 = earth view to higher value
                    maxZoom: 18,
                    minZoom: 13,
                    zoomControlOptions: {
                        style: google.maps.ZoomControlStyle.SMALL //zoom control size
                    },
                    scaleControl: true, // enable scale control
                    mapTypeId: google.maps.MapTypeId.ROADMAP // google map type
                };

        map = new google.maps.Map(document.getElementById("google_map"), googleMapOptions);

        //Load Markers from the XML File, Check (map_process.php)
        $.get("<?php echo site_url('admin/cms/map_process'); ?>", function(data) {
            $(data).find("marker").each(function() {
                var name = $(this).attr('name');
                var address = '<p>' + $(this).attr('address') + '</p>';
                var city = $(this).attr('city');
                var point = new google.maps.LatLng(parseFloat($(this).attr('lat')), parseFloat($(this).attr('lng')));
                create_marker(point, name, address, city, false, false, false, "<?php echo base_url(); ?>/bootstrap/img/pin_blue.png");
            });
        });

        //Right Click to Drop a New Marker
        google.maps.event.addListener(map, 'rightclick', function(event) {
            //Edit form to be displayed with new marker
            var EditForm = '<p><div class="marker-edit">' +
                    '<form method="POST" name="SaveMarker" id="SaveMarker">' +
                    '<label for="pName"><span>Place Name :</span><input type="text" name="pName" class="save-name" placeholder="Enter Title" maxlength="40" /></label>' +
                    '<label for="pDesc"><span>Description :</span><textarea name="pDesc" class="save-desc" placeholder="Enter Address" maxlength="150"></textarea></label>' +
                    '<label for="pCity"><span>City Name :</span><input type="text" name="pCity" class="save-city" placeholder="Enter City" maxlength="40" /></label>' +
                    '</form>' +
                    '</div></p><button name="save-marker" class="save-marker">Save Marker Details</button>';

            //Drop a new Marker with our Edit Form
            create_marker(event.latLng, 'New Marker', EditForm, '', true, true, true, "<?php echo base_url(); ?>/bootstrap/img/pin_blue.png");
        });
        var markers = [];

        // Create the search box and link it to the UI element.
        var input = /** @type {HTMLInputElement} */(
                document.getElementById('pac-input'));
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        var searchBox = new google.maps.places.SearchBox(
                /** @type {HTMLInputElement} */(input));

        // Listen for the event fired when the user selects an item from the
        // pick list. Retrieve the matching places for that item.
        google.maps.event.addListener(searchBox, 'places_changed', function() {
            var places = searchBox.getPlaces();

            if (places.length == 0) {
                return;
            }
            for (var i = 0, marker; marker = markers[i]; i++) {
                marker.setMap(null);
            }

            // For each place, get the icon, place name, and location.
            markers = [];
            var bounds = new google.maps.LatLngBounds();
            for (var i = 0, place; place = places[i]; i++) {
                var image = {
                    url: place.icon,
                    size: new google.maps.Size(71, 71),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(17, 34),
                    scaledSize: new google.maps.Size(25, 25)
                };

                // Create a marker for each place.
                var marker = new google.maps.Marker({
                    map: map,
                    icon: image,
                    title: place.name,
                    position: place.geometry.location
                });

                markers.push(marker);

                bounds.extend(place.geometry.location);
            }

            map.fitBounds(bounds);
        });

        // Bias the SearchBox results towards places that are within the bounds of the
        // current map's viewport.
        google.maps.event.addListener(map, 'bounds_changed', function() {
            var bounds = map.getBounds();
            searchBox.setBounds(bounds);
        });
//google.maps.event.addDomListener(window, 'load', map_initialize);						
    }

    //############### Create Marker Function ##############
    function create_marker(MapPos, MapTitle, MapDesc, MapCity, InfoOpenDefault, DragAble, Removable, iconPath)
    {

        //new marker
        var marker = new google.maps.Marker({
            position: MapPos,
            map: map,
            draggable: DragAble,
            animation: google.maps.Animation.DROP,
            title: 'New City',
            icon: iconPath
        });

        //Content structure of info Window for the Markers
        var contentString = $('<div class="marker-info-win">' +
                '<div class="marker-inner-win"><span class="info-content">' +
                '<h1 class="marker-heading">' + MapTitle + '</h1>' +
                MapDesc +
                '</span><p>' + MapCity +
                '</p><button name="remove-marker" class="remove-marker" title="Remove Marker">Remove Marker</button>' +
                '</div></div>');


        //Create an infoWindow
        var infowindow = new google.maps.InfoWindow();
        //set the content of infoWindow
        infowindow.setContent(contentString[0]);

        //Find remove button in infoWindow
        var removeBtn = contentString.find('button.remove-marker')[0];
        var saveBtn = contentString.find('button.save-marker')[0];

        //add click listner to remove marker button
        google.maps.event.addDomListener(removeBtn, "click", function(event) {
            remove_marker(marker);
        });

        if (typeof saveBtn !== 'undefined') //continue only when save button is present
        {
            //add click listner to save marker button
            google.maps.event.addDomListener(saveBtn, "click", function(event) {
                var mReplace = contentString.find('span.info-content'); //html to be replaced after success
                var mName = contentString.find('input.save-name')[0].value; //name input field value
                var mDesc = contentString.find('textarea.save-desc')[0].value; //description input field value
                var mCity = contentString.find('input.save-city')[0].value; //name input field value
                //   var mType = contentString.find('select.save-type')[0].value; //type of marker

                if (mName == '' || mDesc == '')
                {
                    alert("Please enter Name and Description!");
                } else {
                    save_marker(marker, mName, mDesc, mCity, mReplace); //call save marker function
                }
            });
        }

        //add click listner to save marker button		 
        google.maps.event.addListener(marker, 'click', function() {
            infowindow.open(map, marker); // click on marker opens info window 
        });

        if (InfoOpenDefault) //whether info window should be open by default
        {
            infowindow.open(map, marker);
        }
    }

    //############### Remove Marker Function ##############
    function remove_marker(Marker)
    {

        /* determine whether marker is draggable 
         new markers are draggable and saved markers are fixed */
        if (Marker.getDraggable())
        {
            Marker.setMap(null); //just remove new marker
        }
        else
        {
            //Remove saved marker from DB and map using jQuery Ajax
            var mLatLang = Marker.getPosition().toUrlValue(); //get marker position
            var myData = {del: 'true', latlang: mLatLang}; //post variables
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('admin/cms/map_process'); ?>",
                data: myData,
                success: function(data) {
                    Marker.setMap(null);
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError); //throw any errors
                }
            });
        }

    }

    //############### Save Marker Function ##############
    function save_marker(Marker, mName, mAddress, mCity, replaceWin)
    {
        //Save new marker using jQuery Ajax
        var mLatLang = Marker.getPosition().toUrlValue(); //get marker position
//            var myData = {name: mName, address: mAddress, latlang: mLatLang, type: mType}; //post variables
        var myData = {name: mName, address: mAddress, city: mCity, latlang: mLatLang}; //post variables
        console.log(replaceWin);
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('admin/cms/map_process'); ?>",
            data: myData,
            success: function(data) {
                replaceWin.html(data); //replace info window with new html
                Marker.setDraggable(false); //set marker to fixed
                Marker.setIcon('<?php echo base_url(); ?>/bootstrap/img/pin_blue.png'); //replace icon
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError); //throw any errors
            }
        });
    }
//google map end  
    //for the update view
    function update_cms(param) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('admin/cms/get_update_cms'); ?>",
            data: {cms_id: param}
        }).done(function(data) {
            var json = $.parseJSON(data);
            $('.f-placeholder').html(json.body);
            $('.f-placeholder').removeAttr("placeholder");
            $('input[name="title_update"]').val(json.title);
            $('.page_id').html(json.pages);
            $('#hidden-cms_id').val(param);
        });
    }

    //for the update view
    function update_sister_city(param) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('admin/cms/get_update_city'); ?>",
            data: {city_id: param}
        }).done(function(data) {
            var json = $.parseJSON(data);
            var full_path = "<?php echo CITY_IMG_PATH; ?>" + json.city_img;
            $('#previewing_update').text(json.city_img);
            $('#previewing').attr('src', full_path);
            $('.f-placeholder').html(json.city_description);
            $('.f-placeholder').removeAttr("placeholder");
            $('input[name="update_city_name"]').val(json.city_name);
            $('#hidden-city_id').val(param);
            $('#id_update').val(param);
            edit_city(json.lat, json.lng, json.city);
    });
    }
    
        //for the update view
    function update_news(param){
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('admin/cms/get_update_news'); ?>",
            data: { news_id: param }
        }).done(function( data ) {											
         var json = $.parseJSON(data);
         var full_path = "";
         var news_img = "";
           if(json.news_img == null) {
               full_path = "<?php echo DEFAULT_IMG_PATH; ?>";
               news_img = "No Image uploaded";
             } else {
              full_path = "<?php echo NEWS_IMG_PATH; ?>" + json.news_img;
              news_img = json.news_img;
             }
            $('#previewing_update2').text(news_img);
            $('#previewing2').attr('src', full_path);
            $('.f-placeholder').html(json.news_body);
            $('.f-placeholder').removeAttr("placeholder");
            $('input[name="update_news_title"]').val(json.news_title);
            $('input[name="update_news_date"]').val(json.news_date);
            $('input[name="update_news_summary"]').val(json.news_summary);
            $('#hidden-news_id').val(param);
            $('#id_update2').val(param);
        });
    }

    //for the update view
    function update_cms_status(param) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('admin/cms/get_update_cms'); ?>",
            data: {cms_id: param}
        }).done(function(data) {
            var json = $.parseJSON(data);
            $('#hidden-page-id_selected').val(param);
            if (json.active == '1') {
                $('#active_inactive').text('Inactive');
                $('#hidden-page-action').val('0');
                $('#current_status').html('');
                $('#status_action').html('Inactive');
            }
            else if (json.active == '0') {
                $('#active_inactive').text('Active');
                $('#hidden-page-action').val('1');
                $('#status_action').html('Active');
            }
        });
    }

    //for the update view
    function update_city_status(param) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('admin/cms/get_sistercity_status'); ?>",
            data: {city_id: param}
        }).done(function(data) {
            var json = $.parseJSON(data);
            $('#hidden-city-id_selected').val(param);
            if (json.active == '1') {
                $('#active_inactive').text('Inactive');
                $('#hidden-city-action').val('0');
                $('#city_status_action').html('Inactive');
            }
            else if (json.active == '0') {
                $('#active_inactive').text('Active');
                $('#hidden-city-action').val('1');
                $('#city_status_action').html('Active');
            }
        });
    }

    function close_update() {
        $('#form-update-cms')[0].reset();
        setTimeout(function() {
            window.location.reload();
        }, 1000);
    }
    function close_active_inactive() {
        $('#form-update-cms')[0].reset();
        setTimeout(function() {
            window.location.reload();
        }, 1000);
    }
    function close_cancel_sister_city() {
        $('#file').val('');
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('admin/cms/remove_sess'); ?>"
        });
    }
</script>
<div id="content" class="col-lg-10 col-sm-10">
    <!-- content starts -->
    <div class=" row">
        <!-- insert the page content here -->
        <h1>Content Management System</h1>

        <!-- Tabs --> 

        <ul class="nav nav-tabs">
            <li class="active">
                <a href="#sisterhoodnetwork" data-toggle="tab" style="margin-bottom: 0px;">
                    <span class="fa fa-users"></span> Makati Sisterhood Network
                </a>
            </li>
            <li>
                <a href="#sistercities" data-toggle="tab" >
                    <span class="fa fa-building-o"></span> Sister Cities
                </a>
            </li> 
            <li>
                <a href="#news" data-toggle="tab" >
                    <span class="fa fa-newspaper-o"></span> News
                </a>
            </li>
        </ul>
         <!-- Tab panes -->
         <div class="panel-body">
            <div class="tab-content">
                <div class="tab-pane fade in active" id="sisterhoodnetwork">
                    <div class="tab-content">
                        <div class="tab-pane fade in active">
                            <p style="margin-top: 15px;">
                                <button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#largeModal">Add Content</button>            
        </p>
        <p>
            <button type="button" class="btn btn-xs btn-primary"  data-toggle="modal" onclick="window.location = '<?php echo site_url("admin/cms/report_pdf"); ?>'">Export to PDF</button>             
            <button type="button" class="btn btn-xs btn-primary"  data-toggle="modal" onclick="window.location = '<?php echo site_url("admin/cms/report_excel"); ?>'">Export to Excel</button>             
        </p> 
        <table id="cms_table" class="table table-striped" width="100%" cellspacing="0" style="table-layout: fixed; width: 100%">
            <thead>
                <tr>
                    <th>Page Name</th>
                    <th>Title</th>
                    <th>Registration Date</th>
                    <th>Status</th>
                    <th>Status Action</th>
                    <th>Action</th>
                </tr>
            </thead>
                                <tbody></tbody>
        </table> 
			</div>
                    </div>
                </div>
<div class="tab-pane fade in" id="sistercities">
                    <div class="tab-content">
                        <div class="tab-pane fade in active">
                            <p style="margin-top: 15px;">
                                <button type="button" class="btn btn-xs btn-primary" data-toggle="modal" onclick="javascript:add_city();" data-target="#largeModal-city">Add Sister City</button>             
                            </p>
                            <p>
                                <button type="button" class="btn btn-xs btn-primary"  data-toggle="modal" onclick="window.location = '<?php echo site_url("admin/cms/report_pdf_cities"); ?>'">Export to PDF</button>             
                                <button type="button" class="btn btn-xs btn-primary"  data-toggle="modal" onclick="window.location = '<?php echo site_url("admin/cms/report_excel_cities"); ?>'">Export to Excel</button>             
                            </p>        
                            <table id="sister_cities_table" class="table table-striped" width="100%" cellspacing="0" style="table-layout: fixed; width: 100%">
                                <thead>
                                    <tr>
                                        <th>City Name</th>
                                        <th>Created By</th>
                                        <th>Registration Date</th>
                                        <th>Last Update Date</th>
                                        <th>Last Updated By</th>
                                        <th>Status</th>
                                        <th>Status Action</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table> 
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade in" id="news">
                    <div class="tab-content">
                        <div class="tab-pane fade in active">
                            <p style="margin-top: 15px;">
                                <button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#largeModal-news">Add News</button>  
                            </p>
                            <p>
                                <button type="button" class="btn btn-xs btn-primary"  data-toggle="modal" onclick="window.location = '<?php echo site_url("admin/cms/report_pdf_news"); ?>'">Export to PDF</button>             
                                <button type="button" class="btn btn-xs btn-primary"  data-toggle="modal" onclick="window.location = '<?php echo site_url("admin/cms/report_excel_news"); ?>'">Export to Excel</button>            
                            </p>        
                            <table id="news_table" class="table table-striped" width="100%" cellspacing="0" style="table-layout: fixed; width: 100%">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Summary</th>
                                        <th>Created By</th>
                                        <th>News Date</th>
                                        <th>Registration Date</th>
                                        <th>Last Update Date</th>
                                        <th>Last Updated By</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade modal-wide" id="largeModal" role="dialog" data-width="760" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">CMS - Add Contents</h4>
            </div>
            <div class="modal-body">
                 <form id="uploadimage3" action="" method="post" enctype="multipart/form-data">
                    <strong>Image:</strong>
                    <div id="selectImage">
                        <br/>
                        <input type="file" name="file3" id="file3" required />
                        <input type="submit" value="Upload" class="submit" />
                    </div>                   
                </form>
                <div id="message3"> </div>
                <form id="form-add" class="form-horizontal">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <td><strong>Page Name:</strong></td>
                                <td>
                                    <div class="form-group col-sm-4">
                                    <?php echo (isset($pages) ? $pages : ''); ?>
                                    </div>  
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Title:</strong></td>
                                <td>
                                    <div class="form-group col-sm-4">
                                        <input type="text" class="form-control" value="" name="title" id="title" placeholder="Title" 
                                               required autofocus maxlength="150">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Body:</strong></td>
                                <td>
                                    <div class="col-sm-14">
                                        <div class="textarea-custom" id="cms_body"></div>
                                    </div>
                                </td>
                            </tr>			
                        </thead>
                        <tbody>
                        </tbody>
                    </table>					
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary" id="btn-save">Save Now</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- Add news content start -->
<div class="modal fade modal-wide" id="largeModal-news" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="javascript:close_cancel_sister_city();">&times;</button>
                <h4 class="modal-title" id="myModalLabel">CMS - Add News</h4>
            </div>
            <div class="modal-body">
                <div id="add-news-msg"></div>
                <form id="uploadimage2" action="" method="post" enctype="multipart/form-data">
                    <strong>Image:</strong>
                    <div id="selectImage">
                        <br/>
                        <input type="file" name="file2" id="file2" required />
                        <input type="submit" value="Upload" class="submit" />
                    </div>                   
                </form>
            <div id="message2"> 			
            </div>
               <hr id="line">  
                <form id="form-add-news" class="form-horizontal" data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
                    data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
                    data-bv-feedbackicons-validating="glyphicon glyphicon-refresh">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <td><strong>Title:</strong></td>
                                <td>
                                    <div class="form-group col-sm-10">
                                        <input type="text" class="form-control" value="" name="news_title" id="news_title" placeholder="Title" 
                                               required autofocus maxlength="150" data-bv-notempty-message="* Title is required and cannot be empty">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>News date:</strong></td>
                                <td>
                                    <div class="form-group col-sm-2">
                                        <input type="date" class="form-control" value="" name="news_date" id="news_date" placeholder="News date" 
                                               required autofocus maxlength="10" data-bv-notempty-message="* Date is required and cannot be empty">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Summary:</strong></td>
                                <td>
                                    <div class="form-group col-sm-10">
                                        <input type="text" class="form-control" value="" name="news_summary" id="news_summary" placeholder="Summary" 
                                               required autofocus maxlength="150" data-bv-notempty-message="* Summary is required and cannot be empty">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Content:</strong></td>
                                <td>
                                    <div class="col-sm-14">
                                        <div class="textarea-custom" id="news_body"></div>	
                                        <small id="news-content-error-msg" class="help-block has-error" style="color:#ff4136;"> </small>
                                    </div>
                                </td>
                            </tr>	
                        </thead>
                        <tbody>
                        </tbody>
                    </table>					
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="javascript:close_cancel_sister_city();">Cancel</button>
                <button type="submit" class="btn btn-primary" id="btn-save">Save Now</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- Add news content end -->

<!-- Update news content start -->
<div class="modal fade modal-wide" id="largeModal-update-news" role="dialog" data-width="760" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">CMS - Update News</h4>
            </div>
            <div class="modal-body">
                <div id="update-news-msg"></div>
                <form id="form-update-news" class="form-horizontal" data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
                    data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
                    data-bv-feedbackicons-validating="glyphicon glyphicon-refresh">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <td><strong>Image:</strong></td>
                                <td>
                                    <div class="form-group col-sm-4">
                                      
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Title:</strong></td>
                                <td>
                                    <div class="form-group col-sm-10">
                                        <input type="text" class="form-control" value="" name="update_news_title" id="update_news_title" placeholder="Title" 
                                               required autofocus maxlength="150" data-bv-notempty-message="* Title is required and cannot be empty">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>News date:</strong></td>
                                <td>
                                    <div class="form-group col-sm-2">
                                        <input type="date" class="form-control" value="" name="update_news_date" id="update_news_date" placeholder="News date" 
                                               required autofocus maxlength="10" data-bv-notempty-message="* Date is required and cannot be empty">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Summary:</strong></td>
                                <td>
                                    <div class="form-group col-sm-10">
                                        <input type="text" class="form-control" value="" name="update_news_summary" id="update_news_summary" placeholder="Summary" 
                                               required autofocus maxlength="150" data-bv-notempty-message="* Summary is required and cannot be empty">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Content:</strong></td>
                                <td>
                                    <div class="col-sm-14">
                                        <div class="textarea-custom" id="update_news_body"></div>	
                                        <small id="news-content-error-msg" class="help-block has-error" style="color:#ff4136;"> </small>
                                    </div>
                                </td>
                            </tr>	
                        </thead>
                        <tbody>
                        </tbody>
                    </table>					
            </div>
             <input type="hidden" value="" name="news_id" id="hidden-news_id">  
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary" id="btn-save">Save Now</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- Update news content end -->
<!-- Update cms page content start -->
<div class="modal fade modal-wide" id="largeModal-update-cms" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" id="close_update" onclick="javascript:close_update();" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">CMS - Update Content</h4>
            </div>
            <div class="modal-body">
                <h3></h3>
                <div id="update-cms-msg"></div>
                <form id="form-update-cms" class="form-horizontal" data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
                    data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
                    data-bv-feedbackicons-validating="glyphicon glyphicon-refresh">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <td><strong>Page Name:</strong></td>
                                <td> <div class="page_id form-group col-sm-4">
                                     </div>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Title:</strong></td>
                                <td>
                                    <div class="form-group col-sm-4">
                                       <input type="text" class="form-control" value="" name="title_update" id="title_update" placeholder="Title" 
                                               required autofocus maxlength="150">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Body:</strong></td>
                                <td>
                                    <div class="col-sm-14">
                                        <div class="textarea-custom" id="body_description" name="body_description"></div>
                                    </div>
                                </td>
                            </tr> 				
                        </thead>
                        <tbody>
                        </tbody>
                    </table>					
                    <input type="hidden" value="" name="cms_id" id="hidden-cms_id">  
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="btn-update">Update Now</button>
                    </div>	  
                </form>
            </div>
        </div>
        </div>
    </div>
<!-- Update cms page content end -->
<!-- Update cms status content start -->
<div class="modal fade" id="largeModal-active-inactive-cms" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" id="close_update" onclick="javascript:close_active_inactive();" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Update Page Status</h4>
            </div>
            <div class="modal-body">
                <div id="update-active-inactive-cms-msg"></div>
                <form id="form-update-active-inactive-cms">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <td><span id="current_status"></span> 
                                    Are you sure you want to set the status of this page to 
                                    <span id="status_action"></span>? </td>
                            </tr>   				
                        </thead>
                        <tbody>
                        </tbody>
                    </table>					  
                    <input type="hidden" value="" name="action" id="hidden-page-action">  
                    <input type="hidden" value="" name="cms_id" id="hidden-page-id_selected">  
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">OK</button>
                    </div>	  
                </form>
            </div>
        </div>
  </div>
</div>
<!-- Update cms status content end -->
<!-- Add Sister city start -->
<div class="modal fade modal-wide" id="largeModal-city" role="dialog" aria-labelledby="largeModal-city" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="javascript:close_cancel_sister_city();">&times;</button>
                <h4 class="modal-title" id="myModalLabel">CMS - Add Sister City</h4>
            </div>
            <div class="modal-body">
                <div id="add-city-error-message"></div>
                <h1 class="heading">Google Map</h1>
                <div align="center">Right Click to Drop a New Marker</div>
                <div id="google_map" style="width: 800px; height: 500px">
                </div>
                <input id="pac-input"  />
                 <hr id="line">  
                <form id="uploadimage" action="" method="post" enctype="multipart/form-data">
                    <strong>Image:</strong>
                    <div id="selectImage">
                        <br/>
                        <input type="file" name="file" id="file" required />
                        <input type="submit" value="Upload" class="submit" />
                    </div>                   
                </form>
            <div id="message"> 			
            </div>
                <form id="form-add-city" method="post" class="form-horizontal" data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
                      data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
                      data-bv-feedbackicons-validating="glyphicon glyphicon-refresh"> 
                    <table class="table table-striped" style="margin-top:20px;">
                        <thead>
                            <tr>
                                <td><strong>City Name:</strong></td>
                                <td>
                                    <div class="form-group col-sm-4">
                                        <input type="text" class="form-control" value="" name="city_name" id="city_name" placeholder="City Name" 
                                               required autofocus maxlength="150" data-bv-notempty-message="* City name is required and cannot be empty">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>City Description Page:</strong></td>
                                <td>
                                    <div class="col-sm-14">
                                        <div class="textarea-custom" id="city_description"></div>	
                                        <small id="content-error-msg" class="help-block has-error" style="color:#ff4136;"> </small>
                                    </div>
                                </td>
                            </tr>
                            
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="javascript:close_cancel_sister_city();">Cancel</button>
                <button type="submit" class="btn btn-primary" id="btn-save">Save Now</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- Add Sister city end -->

<!-- Update Sister city start -->
<div class="modal fade modal-wide" id="largeModal-update-sistercity" role="dialog" aria-labelledby="largeModal-city" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="javascript:close_cancel_sister_city();">&times;</button>
                <h4 class="modal-title" id="myModalLabel">CMS - Update Sister City</h4>
            </div>
            <div class="modal-body">
                <div id="update-city-error-message"></div>
                <h1 class="heading">Google Map</h1>
                <div align="center">Right Click to Drop a New Marker</div>
                <div id="edit_map" style="width: 800px; height: 500px">
                </div>
                <input id="city_map_addr" />
                 <hr id="line">  
                 <strong>Image:</strong>
                <div id="image_preview"><img id="previewing" width="200" height="200" src="" />
                    <p>File name:</p> <span id="previewing_update"></span></div>
                <form id="uploadimage_update" action="" method="post" enctype="multipart/form-data">
                    <div id="selectImage">
                        <br/>
                        <input type="file" name="file_update" id="file_update" required /> <p> Uploading new image will remove the previous image. </p>
                        <input type="submit" value="Upload" class="submit" />
                    </div>    
                 <input type="hidden" value="" name="id_update" id="id_update">  
                </form>
            <div id="message_update"> 			
            </div>
                <form id="form-update-city" method="post" class="form-horizontal" data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
                      data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
                      data-bv-feedbackicons-validating="glyphicon glyphicon-refresh"> 
                    <table class="table table-striped" style="margin-top:20px;">
                        <thead>
                            <tr>
                                <td><strong>City Name:</strong></td>
                                <td>
                                    <div class="form-group col-sm-4">
                                        <input type="text" class="form-control" value="" name="update_city_name" id="update_city_name" placeholder="City Name" 
                                               required autofocus maxlength="150" data-bv-notempty-message="* City name is required and cannot be empty">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>City Description Page:</strong></td>
                                <td>
                                    <div class="col-sm-14">
                                        <div class="textarea-custom" id="city_update_description"></div>	
                                        <small id="content-error-msg" class="help-block has-error" style="color:#ff4136;"> </small>
                                    </div>
                                </td>
                            </tr>

                        </thead>
                        <tbody>
                        </tbody>
                    </table>
            </div>
            <input type="hidden" value="" name="city_id" id="hidden-city_id">  
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="javascript:close_cancel_sister_city();">Cancel</button>
                <button type="submit" class="btn btn-primary" id="btn-save">Update Now</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- Update Sister city end -->

<!-- Update Sister city status content start -->
<div class="modal fade" id="largeModal-active-inactive-sistercity" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" id="close_update" onclick="javascript:close_active_inactive();" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Update Sister City</h4>
            </div>
            <div class="modal-body">
                <div id="update-active-inactive-sistercity"></div>
                <form id="form-update-active-inactive-sistercity">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <td><span id="current_status"></span> 
                                    Are you sure you want to set the status of this sister city to 
                                    <span id="city_status_action"></span>? </td>
                            </tr>   				
                        </thead>
                        <tbody>
                        </tbody>
                    </table>					  
                    <input type="hidden" value="" name="action" id="hidden-city-action">  
                    <input type="hidden" value="" name="city_id" id="hidden-city-id_selected">  
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">OK</button>
                    </div>	  
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Update Sister city status content end -->

<!-- overlay -->
<div class="modal modal-static fade" id="processing-modal" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center">
                    <div class="progress progress-striped progress-success active">
                        <div class="progress-bar" style="width: 100%;"></div>
                    </div>
                    <h4>Processing...</h4>
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- For other status alert -->
    <div id="alert-status" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span> <span class="sr-only">close</span></button>
                        <h4 id="alert-modal-title" class="modal-title">Change User Status</h4>
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



