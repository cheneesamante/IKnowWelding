            <script>
    $(document).ready(function() {
    //Add Events start
    //Delete end
//        $('#close').click(function(e) {
//
//        e.preventDefault();
//        setTimeout(function(){ window.location.reload(); }, 1000);
    //            
//        });

    $('#form-event-add').submit(function(e) {

    e.preventDefault();
            var error = ''; //<!-- var event_name = $('.event_name_class #event_name').val(); -->
            var event_name = $('#event_name').val();
//            var event_desc = $('#event_desc').editable('getHTML');
            var event_desc = $('#event_desc').val();
            if (event_name == '') {
    error += '* Event Name is required. <br />';
    }
    if (error != '') {
    var err_msg = '<div class="alert alert-warning"><strong>Warning!</strong><br /><br />';
                err_msg += error;
                err_msg += '</div>';
                $('#add-event-msg').html(err_msg);
        } else {
        var frm = $('#form-event-add').serialize();
                $.ajax({
                type: "POST",
                        url: "<?php echo site_url('common/news_events/validate_event'); ?>",
                        data: frm + "&event_desc=" + event_desc
                }).done(function(data) {
        if (data == 2){
        var msg = '<div class="alert alert-danger">Failed to insert data.<br /><br />\n\
                                \n\
                                Invalid Date time.</div>';
        } else if (data == 3){
        var msg = '<div class="alert alert-danger">Failed to insert data.<br /><br />\n\
                                \n\
                                Not valid user.</div>';
        } else if (data == 5){
        var msg = '<div class="alert alert-danger">Failed to insert data.<br /><br />\n\
                                \n\
                                Not Event Description.</div>';
        }
        else if (data == 1) {
        $('#form-event-add')[0].reset();
                var msg = '<div class="alert alert-success">Successfully saved.</div>';
                setTimeout(function(){ window.location.reload(); }, 1000);
        }
        $('#add-event-msg').html(msg);
        });
        }
        });
                //Add Events end
                //Delete start
//        $('#btn-delete').click(function(e) {
//            e.preventDefault();
//
//                var frm = $('#form-event-edit').serialize();
//
//                $.ajax({
//                    type: "POST",
//                    url: "<?php echo site_url('common/news_events/delete_event_update'); ?>",
//                    data: frm 
//                }).done(function(data) {
//                    if (data == 2){
//                     var msg = '<div class="alert alert-danger">Failed to insert data.<br /><br />\n\
//                                \n\
//                                Invalid Date time.</div>';
//                    }  else if (data == 3){
//                     var msg = '<div class="alert alert-danger">Failed to insert data.<br /><br />\n\
//                                \n\
//                                Not valid user.</div>';
//                    }  
//                    else if (data == 1) {
//                        $('#form-event-edit')[0].reset();
//                       var msg = '<div class="alert alert-success">Successfully deleted.</div>';
//                       setTimeout(function(){ window.location.reload(); }, 1000);
//                    }
//                    $('#edit-event-msg').html(msg);
//
//                });
//        });

                //Update Events start
//        $('#form-event-edit').submit(function(e) {
//
//            e.preventDefault();
//            var error = '';
//            var event_name = $('.event_name_class #event_name').val();
//
//            if (event_name == '') {
//                error += '* Event Name is required. <br />';
//            }
//            if (error != '') {
//                var err_msg = '<div class="alert alert-warning"><strong>Warning!</strong><br /><br />';
//                err_msg += error;
//                err_msg += '</div>';
//
//                $('#edit-event-msg').html(err_msg);
//            } else {
//                var frm = $('#form-event-edit').serialize();
//
//                $.ajax({
//                    type: "POST",
//                    url: "<?php echo site_url('common/news_events/validate_event_update'); ?>",
//                    data: frm 
//                }).done(function(data) {
//                    if (data == 2){
//                     var msg = '<div class="alert alert-danger">Failed to insert data.<br /><br />\n\
//                                \n\
//                                Invalid Date time.</div>';
//                    }  else if (data == 3){
//                     var msg = '<div class="alert alert-danger">Failed to insert data.<br /><br />\n\
//                                \n\
//                                Not valid user.</div>';
//                    }  
//                    else if (data == 1) {
//                        $('#form-event-edit')[0].reset();
//                       var msg = '<div class="alert alert-success">Successfully updated.</div>';
//                       setTimeout(function(){ window.location.reload(); }, 1000);
//                    }
//                    $('#edit-event-msg').html(msg);
//
//                });
//            }
//        });
                //Delete end

                $('#largeModal').hide();
//         m = $('#calendar').fullCalendar('getDate');
//         console.log(m);
                $('#calendar').fullCalendar({

        header: {
        left: 'prev,next',
                center: 'title',
                right: ''
        },
//               select: function(start, end, jsEvent, view) {
//         // start contains the date you have selected
//         // end contains the end date. 
//         // Caution: the end date is exclusive (new since v2).
//         var allDay = !start.hasTime() && !end.hasTime();
//         alert(["Event Start date: " + moment(start).format(),
//                "Event End date: " + moment(end).format(),
//                "AllDay: " + allDay].join("\n"));
//    },
                dayClick: function(date) {
                var ss = date.utc().format("YYYY-MM-DD hh:mm:ss");
                        //var add_time = date.utc().format("HH:mm");
                        $(".form_datetime").attr('data-date', ss);
                        //$(".form_datetime #add_time").val(add_time);
                        //for date picker
                        $('.form_datetime').datetimepicker({
                //language:  'fr',
                weekStart: 1,
                        todayBtn: 1,
                        autoclose: 1,
                        todayHighlight: 1,
                        startView: 1,
                        minView: 0,
                        maxView: 1,
                        forceParse: 0,
                        pickerPosition: "bottom-left"
                });
                        $('#addEvent-modalTitle').html();
                        $('#addEvent-modalBody').html();
                        $('#addEvent').modal();
                        console.log('a day has been clicked!');
                },
                eventClick: function(calEvent, jsEvent, view) {
                //for date picker
                $('.form_datetime').datetimepicker({
                //language:  'fr',
                weekStart: 1,
                        todayBtn: 1,
                        autoclose: 1,
                        todayHighlight: 1,
                        startView: 1,
                        minView: 0,
                        maxView: 1,
                        forceParse: 0,
                        pickerPosition: "bottom-left"
                });
                        var m = moment(calEvent.start);
                        var ss = m.utc().format("YYYY-MM-DD HH:mm");
                        var s = m.utc().format("HH:mm");
                        var city = '';
                        $('.event_name_class #event_name').val(calEvent.title);
                        $('#event_time').val(s);
                        $('#dtp_input-edit').val(ss);
                        $('#event_id-edit').val(calEvent.event_id);
                        $('#modal-footer').html(calEvent.button_access);
                        $('#event_name_class').html(calEvent.events_name);
                        $('#reg_date_class').text(calEvent.reg_date);
                        $('#event_by_class').text(calEvent.reg_by);
                        $('#event_desc_edit').val(calEvent.event_desc);
                        //alert(calEvent.event_desc);
                        // $('#event_desc_edit').val(calEvent.event_desc);

                        if (calEvent.city_name == 0 || calEvent.city_name == '' || calEvent.city_name == null){
                var city = 'N/A';
                } else {
                var city = calEvent.city_name;
                }
                $('#city_name_class').text(city);
                        $('#editEvent').modal();
//                console.log('Event: ' + calEvent.title);
//                console.log('Date: ' + calEvent.start);
//                console.log('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
//                console.log('View: ' + view.name);

                        // change the border color just for fun
                        //$(this).css('border-color', 'red');
                },
                events:
<?php
echo $load_events;
?>
        });
        });
                function report_pdf(){
                var search_month = $('#search_month').val();
                        var search_year = $('#search_year').val();
                        window.location.href = "<?php echo site_url('admin/private_archives/report_pdf?search_month='); ?>" + search_month + "&search_year=" + search_year;
                }
        function report_excel(){
        var search_month = $('#search_month').val();
                var search_year = $('#search_year').val();
                window.location.href = "<?php echo site_url('admin/private_archives/report_excel?search_month='); ?>" + search_month + "&search_year=" + search_year;
        }
        function delete_event(){
        //  e.preventDefault();

        var frm = $('#form-event-edit').serialize();
                $.ajax({
                type: "POST",
                        url: "<?php echo site_url('common/news_events/delete_event_update'); ?>",
                        data: frm
                }).done(function(data) {
        if (data == 2){
        var msg = '<div class="alert alert-danger">Failed to insert data.<br /><br />\n\
                                \n\
                                Invalid Date time.</div>';
        } else if (data == 3){
        var msg = '<div class="alert alert-danger">Failed to insert data.<br /><br />\n\
                                \n\
                                Not valid user.</div>';
        }
        else if (data == 1) {
        $('#form-event-edit')[0].reset();
                var msg = '<div class="alert alert-success">Successfully deleted.</div>';
                setTimeout(function(){ window.location.reload(); }, 1000);
        }
        $('#edit-event-msg').html(msg);
        });
        }
        //update event 
        function update_event(){
        var error = '';
                var event_desc_edit = $('#event_desc_edit').val();
                var event_name = $('.event_name_class #event_name').val();
                if (event_name == '') {
        error += '* Event Name is required. <br />';
        }
        if (error != '') {
        var err_msg = '<div class="alert alert-warning"><strong>Warning!</strong><br /><br />';
                err_msg += error;
                err_msg += '</div>';
                $('#edit-event-msg').html(err_msg);
        } else {
        var frm = $('#form-event-edit').serialize();
                $.ajax({
                type: "POST",
                        url: "<?php echo site_url('common/news_events/validate_event_update'); ?>",
                        data: frm + "&event_desc_edit=" + event_desc_edit
                }).done(function(data) {
        if (data == 2){
        var msg = '<div class="alert alert-danger">Failed to insert data.<br /><br />\n\
                                \n\
                                Invalid Date time.</div>';
        } else if (data == 3){
        var msg = '<div class="alert alert-danger">Failed to insert data.<br /><br />\n\
                                \n\
                                Not valid user.</div>';
        } else if (data == 5){
        var msg = '<div class="alert alert-danger">Failed to insert data.<br /><br />\n\
                                \n\
                                Not Event Description.</div>';
        }
        else if (data == 1) {
        $('#form-event-edit')[0].reset();
                var msg = '<div class="alert alert-success">Successfully updated.</div>';
                       setTimeout(function(){ window.location.reload(); }, 1000);
                    }
                    $('#edit-event-msg').html(msg);

                });
            }
    }
    function close_button(){
            $('#form-event-add')[0].reset();
            $('#form-event-edit')[0].reset();
            $('#edit-event-msg').html('');
            $('#add-event-msg').html('');
    }
</script>
<div id="content" class="col-lg-10 col-sm-10">
    <!-- content starts -->
    <div class=" row">
        <p>
            <!--<button type="button" class="btn btn-xs btn-primary"  data-toggle="modal" onclick="window.location='<?php echo site_url("admin/private_archives/report_pdf"); ?>';">Export to PDF</button>       
            <button type="button" class="btn btn-xs btn-primary"  data-toggle="modal" onclick="javascript:report_pdf();">Export to PDF</button>             
    
            <button type="button" class="btn btn-xs btn-primary"  data-toggle="modal" onclick="window.location='<?php echo site_url("admin/private_archives/report_excel"); ?>'">Export to Excel</button>             
            <button type="button" class="btn btn-xs btn-primary"  data-toggle="modal" onclick="javascript:report_excel();">Export to Excel</button>  -->           
        </p>      
    </div>
    <div class="row">
        <div class="box-content">
            <div id="calendar"></div>
            <div class="clearfix"></div>
            <input type="hidden" id="search_month" name="search_month" value="" />
            <input type="hidden" id="search_year" name="search_year" value="" />
        </div>
    </div>



    <div id="addEvent" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" id="close" name="close" class="close" data-dismiss="modal" onclick="javascript:close_button();"><span aria-hidden="true">×</span> <span class="sr-only">close</span></button>
                    <h4 id="addEvent-modalTitle" class="modal-title">Add Event</h4>
                </div>
                <div id="addEvent-modalBody" class="modal-body">
                    <div id="add-event-msg"></div>
                    <form id="form-event-add">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <td width="25%"><strong>Event Name:</strong></td>
                                    <td><input type="text" value="" class="form-control" name="event_name" id="event_name" placeholder="Event Name" required autofocus maxlength="200">
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Event Description:</strong></td>
                                    <td>
                                        <textarea name="event_desc" class="form-control" id="event_desc"> </textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td> <strong>Time:</strong> </td>
                                    <td> <div class="input-group date form_datetime col-md-5" data-date="" data-date-format="hh:ii" data-link-field="dtp_input1">
                                            <input class="form-control" id="add_time" name="add_time" size="16" type="text" value="" readonly />
                                            <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                                            <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                                        </div>
                                        <input type="hidden" id="dtp_input1" name="dtp_input1" value="" /><br/>
                                    </td>
                                </tr>
                            </thead>
                        </table>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" >Add Event</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <div id="editEvent" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" id="close" name="close" class="close" data-dismiss="modal" onclick="javascript:close_button();"><span aria-hidden="true">×</span> <span class="sr-only">close</span></button>
                    <h4 class="modal-title">View Event</h4>
                </div>
                <div id="editEvent-modalBody" class="modal-body">
                    <div id="edit-event-msg"></div>
                    <form id="form-event-edit">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <td><strong>Event By:</strong></td>
                                    <td>
                                        <div class="event_by_class" name="event_by_class" id="event_by_class" readonly="readonly">
                                        </div>
                                    </td>
                                </tr>   
                                <tr>
                                    <td><strong>City Name:</strong></td>
                                    <td>
                                        <div class="city_name_class" name="city_name_class" id="city_name_class" readonly="readonly">
                                        </div>
                                    </td>
                                </tr>   
                                <tr>
                                    <td><strong>Register Date:</strong></td>
                                    <td>
                                        <div class="reg_date_class" name="reg_date_class" id="reg_date_class" readonly="readonly">
                                        </div>
                                    </td>
                                </tr>   
                                <tr>
                                    <td><strong>Event Name:</strong></td>
                                    <td>
                                        <div class="event_name_class" name="event_name_class" id="event_name_class">
                                        </div>
                                    </td>
                                </tr>   
                                <tr>
                                    <td><strong>Event Description:</strong></td>
                                    <td>
                                        <textarea name="event_desc_edit" id="event_desc_edit"> </textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td> <strong>Time:</strong> </td>
                                    <td> 
                                         <input class="form-control" id="event_time"  size="16" type="text" value="" readonly="readonly" style="width: 80px;" />
                                        <input type="hidden" id="dtp_input-edit" name="dtp_input-edit" value="" /><br/>
                                        <input type="hidden" id="event_id-edit" name="event_id-edit" value="" /><br/>
                                    </td>
                                </tr>
                            </thead>
                        </table>
                </div>
                <div class="modal-footer" name="modal-footer" id="modal-footer">
                </div>  
                </form>
            </div>
        </div>
    </div>
</div>
