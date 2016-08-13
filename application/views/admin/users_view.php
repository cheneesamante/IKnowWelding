<script>
    $(document).ready(function() {
        $('#tbl-users').dataTable({
            "bProcessing" : true,
            "bServerSide" : true,
            "sAjaxSource" : "<?php echo site_url('admin/users/getAllUsers'); ?>",
            "iDisplayStart" : 0,
            "iDisplayLength": 10,
            "sPaginationType": "full_numbers",
            "autoWidth": true,
            "order": [[ 0, "desc" ]],
            "bLengthChange": false,
            "aoColumnDefs": [
                {"bSortable": true, "aTargets": [0, 1, 2, 3, 4]},
                {"bSortable": false, "aTargets": [5]}
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
        

        $('#form-reset-pwd').submit(function(e) {	
            e.preventDefault();	
            var error = '';
            var frm = $(this).serialize();
            var msg = '<div class="alert alert-danger">Failed to reset password.</div>';
            $('#largeModal-reset').modal('hide');
            $('#processing-modal').modal();
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('admin/users/reset_password'); ?>",
                data: frm
            }).done(function( data ) {		
                $('#processing-modal').modal('hide');
                var json_data = JSON.parse(data)
                if (json_data.status != false) {			
                    msg = '<div class="alert alert-success">Password has been reset successfully.</div>';	
                }
                $('#email_addr').html(json_data.email);
                $('#reset-password-alert-msg').html(msg);
                $('#password-reset-successful').modal();
            });
            
        });
        
        $(document).on("click", ".btn-reset", function () {
            var userId = $(this).data('id');
            $(".modal-body #reset_user_id").val( userId );
        });
        
        $('.btn-refresh').click(function(e) {	
			window.location.reload();
        });
        
        $(document).on("click", ".btn-update-status", function () {
            var userId = $(this).data('id');
            var userAction = $(this).data('action');
            var userStatus = $(this).data('status');
            $(".modal-body #update_user_id").val( userId );
            $(".modal-body #action").html( userAction );
            $('#btn-update-user-status').data('id', userId);
            $('#btn-update-user-status').data('status', userStatus);
        });
        
        $('#btn-update-user-status').click(function(e) {	
            var error = '';
            var msg = '<div class="alert alert-danger">Failed to update status.</div>';
            $('#largeModal-active-inactive').modal('hide');
            $('#processing-modal').modal();
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('admin/users/update_user_status'); ?>",
                data: {id: $(this).data('id'), status: $(this).data('status')}
            }).done(function( data ) {		
                $('#processing-modal').modal('hide');
                
                var json_data = JSON.parse(data);
                if (json_data.status != false) {			
                    msg = '<div class="alert alert-success">Status has been successfully changed.</div>';	
                }
                $('#update-active-inactive-msg').html(msg);
                $('#active-inactive-successful').modal();
            });
            return false;
            
        });
		
    });

</script>
	  <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Registered Users
          </h1>
          <ol class="breadcrumb">
            <!--<li><a href="#"><i class="fa fa-dashboard"></i> Registered Users</a></li>
            <li><a href="#">Tables</a></li>
            <li class="active">Data tables</li>-->
          </ol>
        </section>
         <!-- Main content -->
        <section class="content">

          <!-- Default box -->
              <div class="box">
                <div class="box-header">
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="tbl-users" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Email Address</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Status</th>
                        <th>Member Since</th>
                        <th>&nbsp;</th>
                      </tr>
                    </thead>
                   
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
       </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
	
	<!-- Modal HTML -->
    <div id="myModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Confirmation</h4>
                </div>
                <div class="modal-body">
                    <p>Do you want to save changes you made to document before closing?</p>
                    <p class="text-warning"><small>If you don't save, your changes will be lost.</small></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
	
	<!-- For reset password -->
    <div id="largeModal-reset" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="form-reset-pwd">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span> <span class="sr-only">close</span></button>
                        <h4 class="modal-title">Reset password</h4>
                    </div>
                    <div class="modal-body">
                        <div id="reset-password-msg"></div>
                        Are you sure you want to reset the password for this user?
                        <input type="hidden" id="reset_user_id" name="user_id" value=""/>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-default">OK</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- For reset password alert -->
    <div id="password-reset-successful" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
   
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span> <span class="sr-only">close</span></button>
                    <h4 class="modal-title">Reset password</h4>
                </div>
                <div class="modal-body">
                    <div id="reset-password-alert-msg"></div>
                    An email has been sent to <span id="email_addr"> </span> 
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-default btn-refresh" data-dismiss="modal">OK</button>
                </div>	  

            </div>
        </div>
    </div>
    
    <!--Approve/Deactivate/Reactivate User-->
<div class="modal fade" id="largeModal-active-inactive" tabindex="-1" role="dialog" aria-labelledby="largeModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" id="close_update" onclick="javascript:close_active_inactive();" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Update User's Status</h4>
                    </div>	  
            <div class="modal-body">
                <form id="form-update-active-inactive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <td><strong>Are you sure you want to <span id="action"></span> this user? </strong></td>
                            </tr>   				
                           
                        </thead>
                        <tbody>
                        </tbody>
                    </table>					  
                    <input type="hidden" value="" name="action" id="hidden-action">  
                    <input type="hidden" name="user_id" id="update_user_id" value=""> 
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" data-id="" id="btn-update-user-status" class="btn btn-primary" id="btn-update">OK</button>
                    </div>	  
                </form>
            </div>
        </div>
    </div>
    </div>
	
    <!-- For update status alert -->
    <div id="active-inactive-successful" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
         
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span> <span class="sr-only">close</span></button>
                    <h4 class="modal-title">Update User's Status</h4>
                </div>
                <div class="modal-body">
                    <div id="update-active-inactive-msg"></div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-default btn-refresh" data-dismiss="modal">OK</button>
                </div>	  
      
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
