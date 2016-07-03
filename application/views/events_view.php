    <!-- For other status alert -->
    <div id="alert-status" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span> <span class="sr-only">close</span></button>
                        <h4 id="alert-modal-title" class="modal-title">Add Event</h4>
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
    //Add Events start
    //Delete end
    $('#close').click(function(e) {

    e.preventDefault();
    setTimeout(function(){ window.location.reload(); }, 1000);

    });
    $('#form-event-add').submit(function(e) {

    e.preventDefault();
    var error = '';
    var event_name = $('#event_name').val();

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
     $('#addEvent').modal('hide');
            $('#processing-modal').modal();
    $.ajax({
    type: "POST",
    url: "<?php echo site_url('common/news_events/validate_event'); ?>",
    data: frm 
    }).done(function(data) {
     $('#processing-modal').modal('hide');
    
    if (data == 2){
    var msg = '<div class="alert alert-danger">Failed to insert data.<br /><br />\n\
    \n\
    Invalid Date time.</div>';
    }  else if (data == 3){
    var msg = '<div class="alert alert-danger">Failed to insert data.<br /><br />\n\
    \n\
    Not valid user.</div>';
    }  
    else if (data == 1) {
    $('#form-event-add')[0].reset();
    var msg = '<div class="alert alert-success">Successfully saved.</div>';
      $('#alert-modal-title').html('Add New Event');
                $('#user-info-alert-msg').html(msg);
                $('#alert-status').modal();
                
    //setTimeout(function(){ window.location.reload(); }, 1000);
    }
    $('#add-event-msg').html(msg);

    });
    }
    });
    //Add Events end
    //Delete start
    $('#btn-delete').click(function(e) {
    e.preventDefault();

    var frm = $('#form-event-edit').serialize();
 $('#addEvent').modal('hide');
            $('#processing-modal').modal();
    $.ajax({
    type: "POST",
    url: "<?php echo site_url('common/news_events/delete_event_update'); ?>",
    data: frm 
    }).done(function(data) {
    $('#processing-modal').modal('hide');
    if (data == 2){
    var msg = '<div class="alert alert-danger">Failed to insert data.<br /><br />\n\
    \n\
    Invalid Date time.</div>';
    }  else if (data == 3){
    var msg = '<div class="alert alert-danger">Failed to insert data.<br /><br />\n\
    \n\
    Not valid user.</div>';
    }  
    else if (data == 1) {
    $('#form-event-edit')[0].reset();
    var msg = '<div class="alert alert-success">Successfully deleted.</div>';
     $('#alert-modal-title').html('Delete Event');
                $('#user-info-alert-msg').html(msg);
                $('#alert-status').modal();
    
    //setTimeout(function(){ window.location.reload(); }, 1000);
    }
    $('#edit-event-msg').html(msg);

    });
    });

    //Update Events start
    $('#form-event-edit').submit(function(e) {

    e.preventDefault();
    var error = '';
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
 $('#edit-event-msg').modal('hide');
            $('#processing-modal').modal();
    $.ajax({
    type: "POST",
    url: "<?php echo site_url('common/news_events/validate_event_update'); ?>",
    data: frm 
    }).done(function(data) {
        $('#processing-modal').modal('hide');
    if (data == 2){
    var msg = '<div class="alert alert-danger">Failed to insert data.<br /><br />\n\
    \n\
    Invalid Date time.</div>';
    }  else if (data == 3){
    var msg = '<div class="alert alert-danger">Failed to insert data.<br /><br />\n\
    \n\
    Not valid user.</div>';
    }  
    else if (data == 1) {
    $('#form-event-edit')[0].reset();
    var msg = '<div class="alert alert-success">Successfully updated.</div>';
         $('#alert-modal-title').html('Update Event');
                $('#user-info-alert-msg').html(msg);
                $('#alert-status').modal();
    //setTimeout(function(){ window.location.reload(); }, 1000);
    }
    $('#edit-event-msg').html(msg);

    });
    }
    });
    //Delete end

    $('#largeModal').hide();
    $('#calendar').fullCalendar({
    
    header: {
    left: '',
    center: 'prev,title,next',
    right: '',
    },
    
    dayClick: function(date) {
    var ss = date.utc().format("YYYY-MM-DD hh:mm:ss");
    $(".form_datetime").attr('data-date',ss);
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
    $('.event_name_class #event_name').val(calEvent.title);

    $('.form_datetime #event_time').val(s);
    $('#dtp_input-edit').val(ss);
    $('#event_id-edit').val(calEvent.event_id);
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

    function refresh_page() {
        setTimeout(function() {
            window.location.reload();
        }, 1000);
    }

</script>
