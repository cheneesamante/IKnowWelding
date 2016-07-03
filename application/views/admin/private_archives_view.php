<div id="content" class="col-lg-10 col-sm-10">

    <!-- content starts -->

    <div class=" row">
    <!-- insert the page content here -->

        What month and year would you like to lookup?
       
        <select id="search_month" name="search_month"  class="selectpicker">
            <?php for($month = 1; $month <= 12; ++$month): ?>
            <option><?php echo date('m', mktime(0, 0, 0, $month, 1)); ?></option>
            <?php endfor; ?>
        </select>

        <select id="search_year" name="search_year"  class="selectpicker">
            <?php for($year = date("Y"); $year > date("Y") - 20; $year--): ?>
            <option><?php echo $year; ?></option>
            <?php endfor; ?>

        </select>
          
        <button type="button" id="search_data" name="search_data" class="btn btn-xs btn-primary">Search</button> 
            <form id="upload_file" action="" method="post" enctype="multipart/form-data"> 
                <div id="message">                </div>	
                <div id="selectImage">
                    <br/>
                    <p>Upload documents Eg. .doc, txt, pdf or excel file </p>
                    <input type="file" name="file" id="file" required />
                    <input type="submit" value="Upload" class="submit" />
                </div>
            </form>			
    </div>

<div id="content" class="col-lg-10 col-sm-10">
            <!-- content starts -->
            <div class=" row">
        <!-- insert the page content here -->
    <h1>List of Private Archives</h1>


    <table id="private_archives" class="table table-striped"  width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>File Id</th>
                <th>File Name</th>
                <th>Uploaded By</th>
                <th>Registered Date</th>
            </tr>
         
        </thead>
        <tbody>
        
        </tbody>
    </table> 
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
                        <h4 id="alert-modal-title" class="modal-title">Upload</h4>
                    </div>
                    <div class="modal-body">
                        <div id="upload-info-alert-msg"></div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-default" onclick="javascript:refresh_page()">OK</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- For other status alert -->
    <div id="upload-err" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span> <span class="sr-only">close</span></button>
                        <h4 id="alert-modal-title" class="modal-title">Upload</h4>
                    </div>
                    <div class="modal-body">
                        <div id="upload-err-msg"></div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-default">OK</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

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
    
<script>   
$(document).ready(function() {
        $("#upload_file").on('submit', (function(e) {
            e.preventDefault();
            $("#message").empty();
            $('#processing-modal').modal();
            $.ajax({
                url: "<?php echo site_url('admin/private_archives/upload_document'); ?>", // Url to which the request is send
                type: "POST", // Type of request to be send, called as method
                data: new FormData(this), // Data sent to server, a set of key/value pairs representing form fields and values 
                contentType: false, // The content type used when sending data to the server. Default is: "application/x-www-form-urlencoded"
                cache: false, // To unable request pages to be cached
                processData: false, // To send DOMDocument or non processed data file it is set to false (i.e. data should not be in the form of string)
                success: function(data)  		// A function to be called if request succeeds
                {
                    $('#processing-modal').modal('hide');
                    var check_length = data.length;
                    if(check_length > 50){

	                $('#upload-err-msg').html(data);
	                $('#upload-err').modal();
	             } else {
	             	$('#upload-info-alert-msg').html(data);
	                $('#alert-status').modal();
	             }
                     /*
                    if(check_length > 50){
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                    }
                    */
                    
                }
            });
        }));
        
        //first load
        var currentMonth = (new Date).getMonth() + 1;

       var search_month = $('#search_month').val(currentMonth);
       var search_year = $('#search_year').val();

         $('#private_archives').dataTable({
            "bProcessing" : true,
            "bServerSide" : true,
            "sAjaxSource" : "<?php echo site_url('admin/private_archives/display_data'); ?>",
            "fnServerParams": function ( aoData ) {
               aoData.push( { "name": "search_month", "value": search_month } );
               aoData.push( { "name": "search_year", "value": search_year} );
            },
            "bDestroy": true, 
            "iDisplayStart" : 0,
            "iDisplayLength": 10,
            "sPaginationType": "full_numbers",
            "autoWidth": true,
            "order": [[ 0, "desc" ]],
            "bLengthChange": false,
            "aoColumnDefs": [
                {"bSortable": true, "aTargets": [0, 1, 2, 3]}
              ], 
            "aaSorting": [[ 0, "desc" ]], // Sort by first column descending
            "fnServerData": function(sSource, aoData, fnCallback){
                $.ajax(
                {
                    'dataType': 'json',
                    'type' : 'POST',
                    'url' : sSource,
                    'data' : aoData,
                    'success' : fnCallback
                    }
                );
            }
        });
       $('#search_data').click(function(e) {
        e.preventDefault();
       var search_month = $('#search_month').val();
       var search_year = $('#search_year').val();

        $('#private_archives').dataTable({
            "bProcessing" : true,
            "bServerSide" : true,
            "sAjaxSource" : "<?php echo site_url('admin/private_archives/display_data'); ?>",
            "fnServerParams": function ( aoData ) {
               aoData.push( { "name": "search_month", "value":search_month } );
               aoData.push( { "name": "search_year", "value":search_year } );
            },
            "bDestroy": true, 
            "iDisplayStart" : 0,
            "iDisplayLength": 10,
            "sPaginationType": "full_numbers",
            "autoWidth": true,
            "order": [[ 0, "desc" ]],
            "bLengthChange": false,
            "aoColumnDefs": [
                {"bSortable": true, "aTargets": [0, 1, 2, 3]}
              ], 
            "aaSorting": [[ 0, "desc" ]], // Sort by first column descending
            "fnServerData": function(sSource, aoData, fnCallback){
                $.ajax(
                {
                    'dataType': 'json',
                    'type' : 'POST',
                    'url' : sSource,
                    'data' : aoData,
                    'success' : fnCallback
                    }
                );
            }
        });
       });

    });


    function refresh_page() {
        setTimeout(function() {
            window.location.reload();
        }, 1000);
    }
       
</script>
