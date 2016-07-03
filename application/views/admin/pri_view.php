<script>   
$(document).ready(function() {

        //first load
       var search_month = $('#search_month').val();
       var search_year = $('#search_year').val();
         $('#private_archives').dataTable({
            "bProcessing" : true,
            "bServerSide" : true,
            "sAjaxSource" : "<?php echo site_url('admin/pri/display_data'); ?>",
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
                {"bSortable": true, "aTargets": [0, 1, 2, 3, 4]}
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
            "sAjaxSource" : "<?php echo site_url('admin/pri/display_data'); ?>",
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
                {"bSortable": true, "aTargets": [0, 1, 2, 3, 4]}
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
function report_pdf(){
       var search_month = $('#search_month').val();
       var search_year = $('#search_year').val();
 window.location.href = "<?php echo site_url('admin/pri/report_pdf?search_month='); ?>"+search_month+"&search_year="+search_year;

 }
function report_excel(){
       var search_month = $('#search_month').val();
       var search_year = $('#search_year').val();
 window.location.href = "<?php echo site_url('admin/pri/report_excel?search_month='); ?>"+search_month+"&search_year="+search_year;

 }
</script>

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
   
    </div>

<div id="content" class="col-lg-10 col-sm-10">
            <!-- content starts -->
            <div class=" row">
        <!-- insert the page content here -->
    <h1>List of Private Archives</h1>
    <p>
        <!--<button type="button" class="btn btn-xs btn-primary"  data-toggle="modal" onclick="window.location='<?php echo site_url("admin/pri/report_pdf");?>';">Export to PDF</button>-->             
        <button type="button" class="btn btn-xs btn-primary"  data-toggle="modal" onclick="javascript:report_pdf();">Export to PDF</button>             

        <!--<button type="button" class="btn btn-xs btn-primary"  data-toggle="modal" onclick="window.location='<?php echo site_url("admin/pri/report_excel");?>'">Export to Excel</button>-->             
        <button type="button" class="btn btn-xs btn-primary"  data-toggle="modal" onclick="javascript:report_excel();">Export to Excel</button>             
    </p>

    <table id="private_archives" class="table table-striped"  width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>Event Id</th>
                <th>Event Name</th>
                <th>Event Date</th>
                <th>Event Time</th>
                <th>Registered By</th>
                <th>Registered Date</th>
                <th>Update By</th>
                <th>Update Date</th>
                <th>Status</th>
            </tr>
         
        </thead>
        <tbody>
          
        </tbody>
    </table> 
</div>
</div>
