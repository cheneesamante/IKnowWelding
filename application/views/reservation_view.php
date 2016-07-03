<div id="content" class="col-lg-10 col-sm-10">
    <!-- content starts -->
    <div class=" row">
        <div id="my-calendar">
        </div>
        <div class="col-xs-6 col-xs-offset-1">
        </div>
    </div>
</div>


<div id="addReservation" class="modal fade modal-wide">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span> <span class="sr-only">close</span></button>
                <h4 id="addReservation-modalTitle" class="modal-title"></h4>
            </div>
            <div id="data-reservation-msg"></div>
            <div id="addReservation-modalBody" class="modal-body">
                <div id="add-reservation-msg"></div>
				<div id="update-msg"></div>
                <div id="save_reservation-msg"></div>
                <form id="form-reservation-add">
                    <table class="table table-striped" id="table-striped">
                        <thead>
                            <tr>
                                <td width="32%"><strong>Reservation Name:</strong></td>
                                <td>
                                    <div class="col-sm-12">
                                    <input type="text" class="form-control" value="" name="reserve_name" id="reserve_name" 
                                           placeholder="Reservation Name" required autofocus maxlength="200">
                                    </div>
                                </td>
                            <tr>
                                <td> <strong>Reservation Description:</strong> </td>
                                <td>
                                    <div class="col-sm-12">
                                    <textarea name="reserve_desc" class="form-control" id="reserve_desc"> </textarea>
                                    </div>
                                </td>
                            </tr>
                        </thead>
                    </table>
            </div>
            <div id="footer" class="modal-footer">
     
            </div>
            </form>
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

<script type="application/javascript">
    $(document).ready(function () {

    $(".modal-wide").on("show.bs.modal", function() {
        var height = $(window).height() - 200;
        $(this).find(".modal-body").css("max-height", height);
    });

    $("#my-calendar").zabuto_calendar({
    action: function () {
    return myDateFunction(this.id, false);
    },
    action_nav: function () {
    return myNavFunction(this.id);
    },
    ajax: {
    url: '<?php echo site_url('common/reservation/get_calendar'); ?>',
    // modal: true
    },
    legend: [
    {type: "text", label: "Pending/Reserved     ", badge: "00"}
    ]
    });
    $("#modal-content").hide();
    $("#modal-dialog").hide();
    });

    function myDateFunction(id, fromModal) {
    $("#modal-content").hide();
    $("#modal-dialog").hide();
    $("#date-popover").hide();
     var reserve_flag = false;
             $('#table-striped').show();
    if (fromModal) {
    $("#" + id + "_modal").modal("hide");
    }
    var date = $("#" + id).data("date");

    $("#date_id").val(id);

    var frm = $('#form-event-edit').serialize();
    $.ajax({
    modal: true,
    type: "POST",
    url: "<?php echo site_url('common/reservation/create_days'); ?>",
    data: frm+"&date="+date
    }).done(function(data) {
    if (data == 0){
        var footer = '';
        
        footer += '<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>';
        footer +=  '<button type="button" class="btn btn-primary" onclick="javascript:save_reservation(\'' + date + '\');">Reserve</button>';
         $('#add-reservation-msg').html("");
        $('#addReservation-modalTitle').html('Reserve for '+date);
        $('#addReservation-modalBody').html();
        $('#footer').html(footer);
        $('#reservation_date').text(date);
        $('#addReservation').modal();
    }  else {
     var json = $.parseJSON(data);
     var msg = '';
     var footer = '';
     var ctr = 1;
     
     
     $.each(json,function(index, val){

    // within val you'll get each 
    // data object
    
       msg += '<div id=res_'+json[index].reserve_id+'><strong>'+ctr+'. Reservation Name: </strong>'+json[index].reservation_name+'</div>';
       msg += '<div id=desc_'+json[index].reserve_id+'> <strong>Reservation Desc:  </strong>'+json[index].reservation_desc+'</div>';
       msg += '<div id=reserve_'+json[index].reserve_id+'> <strong>Reserved By:  </strong>'+json[index].reserve_by+'</div>';
       msg += '<div id=appr_'+json[index].reserve_id+'> <strong>Approved By:  </strong>'+json[index].approved_by+'</div>';
    //   msg += '<input type="hidden" value='' name='+json[index].reserve_id+' id='+json[index].reserve_id+' />';
        if(json[index].status == 1){
         msg += '<div id=stat_'+json[index].reserve_id+'><strong>Status: </strong> Needs Action</div><p></p>';
         if(<?php echo $this->session->userdata('info')['user_type_id']; ?> == 1 || <?php echo $this->session->userdata('info')['user_type_id']; ?> == 2) {
         msg += '<div id=app_rej_'+json[index].reserve_id+'><button type="button" class="btn btn-primary" onclick="javascript:reject_reservation(\'' + date + '\',\'' +json[index].reserve_id+ '\');">Reject</button>';
         msg += '                         <button type="button" class="btn btn-primary" onclick="javascript:approve_reservation(\'' + date + '\',\'' +json[index].reserve_id+ '\');">Approve</button></div><p></p>';
        }
       } else if(json[index].status == 2) {
         msg += '<div id=stat_'+json[index].reserve_id+'> <strong>Status: </strong> Reserved</div><p></p>'; 
         reserve_flag = true;
       } else if(json[index].status == 3) {
         msg += '<div id=stat_'+json[index].reserve_id+'> <strong>Status: </strong> Rejected</div><p></p>'; 
       }
       ctr++;
     });
     if(reserve_flag == false) { 
        footer += '<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>';
        footer +=  '<button  type="button" class="btn btn-primary" onclick="javascript:save_reservation(\'' + date + '\');">Reserve</button><p></p>';
    } else {
        $('#table-striped').hide();
     }
        $('#addReservation-modalTitle').html('Reserve for '+date);
        $('#add-reservation-msg').html(msg);
        $('#footer').html(footer);
        $('#reservation_date').text(date);
        $('#addReservation').modal();
      }
    });
    return true;
    }

     function refresh_page() {
        setTimeout(function() {
            window.location.reload();
        }, 1000);
    }

    function myNavFunction(id) {
    $("#date-popover").hide();
    var nav = $("#" + id).data("navigation");
    var to = $("#" + id).data("to");
    console.log('nav ' + nav + ' to: ' + to.month + '/' + to.year);
    }

    function save_reservation(date){
    // alert(date);
    // alert(document.getElementById('reserve_name')[0].value);
    // alert(document.getElementByName('reserve_name')[0].value);
      var reserve_name = $('#reserve_name').val();
      var reserve_desc = $('#reserve_desc').val();
      var error = '';
     if(reserve_name == '') {
	error += '* Reservation Name is required. <br />';
     }

     if(reserve_desc == '') {
	error += '* Reservation Description is required. <br />';
     }
     if(error != '') {				
	var err_msg = '<div class="alert alert-warning"><strong>Warning!</strong><br /><br />';
	err_msg += error;
	err_msg += '</div>';
	$('#save_reservation-msg').html(err_msg);
   } else {
    $('#addReservation').modal('hide');
            $('#processing-modal').modal();
    $.ajax({
    url:'<?php echo site_url('common/reservation/save_calendar'); ?>',
    type: 'POST',
    dataType: "json",
    data: {
    reserve_date: date,
    user_id: '<?php echo $this->session->userdata('info')['user_id']; ?>',
    reserve_name: reserve_name,
    reserve_desc: reserve_desc
    },
    success: function(data){
    $('#processing-modal').modal('hide');
    if (data != 0) {			
    msg = '<div class="alert alert-success">Successfully saved changes.</div>';	
    }						
    $('#save_reservation-msg').html(msg);
    $('#reserve_name').val('');
    $('#reserve_desc').val('')
    
    $('#alert-modal-title').html('Reservation');
                $('#user-info-alert-msg').html(msg);
                $('#alert-status').modal();
    
    
    //setTimeout(function(){ window.location.reload(); }, 1000);	
    }
    });
    }
    }
    function approve_reservation(date, id){
    $('#addReservation').modal('hide');
    $('#processing-modal').modal();
    
    $.ajax({
    url:'<?php echo site_url('common/reservation/approve_calendar'); ?>',
    type: 'POST',
    dataType: "json",
    data: {
    reserve_date: date,
    reserve_id: id,
    approved_by: '<?php echo $this->session->userdata('info')['user_id']; ?>'
    },
    success: function(data){
     $('#processing-modal').modal('hide');
    if (data == true) {			
    msg = '<div class="alert alert-success">Successfully Approved the reservation.</div>';	
    } else {
    msg = '<div class="alert alert-warning"><strong>Warning!</strong><br /> You dont have rights to approve this reservation. <br /></div>';
    }						
    $('#update-msg').html(msg);
     $('#alert-modal-title').html('Approve Reservation');
                $('#user-info-alert-msg').html(msg);
                $('#alert-status').modal();
    //setTimeout(function(){ window.location.reload(); }, 1000);	
    }
    });
    }    
    function reject_reservation(date, id){
    $('#addReservation').modal('hide');
    $('#processing-modal').modal();
            
    $.ajax({
    url:'<?php echo site_url('common/reservation/reject_calendar'); ?>',
    type: 'POST',
    dataType: "json",
    data: {
    reserve_date: date,
    reserve_id: id,
    approved_by: '<?php echo $this->session->userdata('info')['user_id']; ?>'
    },
    success: function(data){
    $('#processing-modal').modal('hide');
    if (data == true) {				
    msg = '<div class="alert alert-success">Successfully Rejected the reservation.</div>';	
    } else {
    msg = '<div class="alert alert-warning"><strong>Warning!</strong><br /> You dont have rights to reject this reservation.<br /> </div>';
    }						
    $('#update-msg').html(msg);
    $('#alert-modal-title').html('Reject Reservation');
                $('#user-info-alert-msg').html(msg);
                $('#alert-status').modal();
    //setTimeout(function(){ window.location.reload(); }, 1000);	
    }
    });
    }	
</script>

<div id="addReservation" class="modal fade modal-wide">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span> <span class="sr-only">close</span></button>
                <h4 id="addReservation-modalTitle" class="modal-title"></h4>
            </div>
            <div id="data-reservation-msg"></div>
            <div id="addReservation-modalBody" class="modal-body">
                <div id="add-reservation-msg"></div>
				<div id="update-msg"></div>
                <div id="save_reservation-msg"></div>
                <form id="form-reservation-add">
                    <table class="table table-striped" id="table-striped">
                        <thead>
                            <tr>
                                <td width="32%"><strong>Reservation Name:</strong></td>
                                <td>
                                    <div class="col-sm-12">
                                    <input type="text" class="form-control" value="" name="reserve_name" id="reserve_name" 
                                           placeholder="Reservation Name" required autofocus maxlength="200">
                                    </div>
                                </td>
                            <tr>
                                <td> <strong>Reservation Description:</strong> </td>
                                <td>
                                    <div class="col-sm-12">
                                    <textarea name="reserve_desc" class="form-control" id="reserve_desc"> </textarea>
                                    </div>
                                </td>
                            </tr>
                        </thead>
                    </table>
            </div>
            <div id="footer" class="modal-footer">
     
            </div>
            </form>
        </div>
    </div>
</div>
