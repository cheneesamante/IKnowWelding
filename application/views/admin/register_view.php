<script>
    $(document).ready(function() {
        $('#city_div').hide(); //hide city division
        $('#largeModal').hide();
        $('#largeModal-update').hide();
        $('#largeModal-active-inactive').hide();
        $('select[name=u_type_id]').change(function() {
            var id = $(this).find(':selected')[0].id;
            $('#u_id').val(id);
        });
//        $('#close').click(function(e) {
//                e.preventDefault();
//             // reload content
//                    setTimeout(function() {
//                        window.location.reload();
//                    }, 1000); 
//        });

        $.validator.addMethod("maxDate", function(value, element) {
            var curDate = new Date();
            var inputDate = new Date(value);
            if (inputDate < curDate)
                return true;
            return false;
        }, "Date should not be a future date");   // error message
        
        $("#form-add").validate({
            onkeyup: false,
            rules: {
                birth_date: {
                    required: true,
                    date: true,
                    maxDate: true
                },
                email_address: {
                    required: true,
                    email: true,
                    remote: {
                        url: "<?php echo site_url('admin/register/check_email_address');?>",
                        type: "post",
                            data: {
                                email_address: function(){ return $("#email_address").val(); }
                            } 
                    }
                },
                username: {
                    required: true,
                    remote: {
                        url: "<?php echo site_url('admin/register/check_username');?>",
                        type: "post",
                            data: {
                                username: function(){ return $("#username").val(); }
                            } 
                    }
                },
                first_name : "required",
                middle_name : "required",
                last_name  : "required"
            }, 
            messages:{
                email_address: {
                    remote: 'Email is already registered'
                },
                username: {
                    remote: 'Username already exists'
                }
            },

            submitHandler: function(form) {
                var id = $('select[name=u_type_id]').find(':selected')[0].id;
                $('#u_id').val(id);
                var frm = $("#form-add").serialize();
                var msg = '<div class="alert alert-danger">Failed to add user.</div>';
                $('#largeModal').modal('hide');
                $('#processing-modal').modal();
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('admin/register/save'); ?>",
                    data: frm
                }).done(function(data) {
                    $('#processing-modal').modal('hide');
                    if (data == 1) {
                        $('#form-add')[0].reset();
                        msg = '<div class="alert alert-success">Successfully saved.</div>';
                    }
                    $('#alert-modal-title').html('Add User');
                    $('#user-info-alert-msg').html(msg);
                    $('#alert-status').modal();
                });
                return false;
            } 
            
            
        });
        
        $("#form-update-reg").validate({
            onkeyup: false,
            rules: {
                upd_birth_date: {
                    required: true,
                    date: true,
                    maxDate: true
                },
                upd_email_address: {
                    required: true,
                    email: true,
                    remote: {
                        url: "<?php echo site_url('admin/register/check_other_email_address');?>",
                        type: "post",
                            data: {
                                email_address: function(){ return $("#upd_email_address").val(); },
                                id: function(){ return $('#hidden-user_id').val(); }
                            } 
                    }
                },
                upd_username: {
                    required: true,
                    remote: {
                        url: "<?php echo site_url('admin/register/check_other_username');?>",
                        type: "post",
                            data: {
                                username: function(){ return $("#upd_username").val(); },
                                id: function(){ return $('#hidden-user_id').val(); }
                            } 
                    }
                },
                upd_first_name : "required",
                upd_middle_name : "required",
                upd_last_name  : "required"
            }, 
            messages:{
                upd_email_address: {
                    remote: 'Email is already registered'
                },
                upd_username: {
                    remote: 'Username already exists'
                }
            },

            submitHandler: function(form) {
                var gender_id =  $('.gender_id select').val(); //bug cannot get latest value
                var page_id =  $('.page_id select').find(':selected')[0].id;
                var frm = $("#form-update-reg").serialize();
                var msg = '<div class="alert alert-danger">Failed to update user information.</div>';
                $('#largeModal-update').modal('hide');
                $('#processing-modal').modal();
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('admin/register/update_user'); ?>",
                    data: frm+"&gender_id="+gender_id+"&page_id="+page_id
                }).done(function(data) {
                    $('#processing-modal').modal('hide');
                    if (data == 1) {
                        $('#form-update-reg')[0].reset();
                        msg = '<div class="alert alert-success">Successfully updated.</div>';
                    }
                    $('#alert-modal-title').html('Update User Information');
                    $('#user-info-alert-msg').html(msg);
                    $('#alert-status').modal();
                });
                return false;
            } 
            
            
        });
        
        
        /*
        $('#form-add').submit(function(e) {
            e.preventDefault();
            var error = '';
            //var page = $('#t').editable('getText');
            var email_address = $('#email_address').val();

            if (email_address == '') {
                error += '* Email Address is required. <br />';
            }
            if (error != '') {
                var err_msg = '<div class="alert alert-warning"><strong>Warning!</strong><br /><br />';
                err_msg += error;
                err_msg += '</div>';

                $('#add-msg').html(err_msg);
            } else {
                var frm = $('#form-add').serialize();
                var msg = '<div class="alert alert-danger">Failed to insert data.</div>';

                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('admin/register/save'); ?>",
                    data: frm
                }).done(function(data) {
                    if (data == 1) {
                        $('#form-add')[0].reset();
                        msg = '<div class="alert alert-success">Successfully saved.</div>';
                        setTimeout(function() {
                            window.location.reload();
                        }, 1000);
                    }
                    $('#add-msg').html(msg);

                });
            }
        });*/

        $('#user_table').dataTable({
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": "<?php echo site_url('admin/register/display_data'); ?>",
            "iDisplayStart": 0,
            "iDisplayLength": 10,
            "sPaginationType": "full_numbers",
            "autoWidth": true,
            "order": [[0, "desc"]],
            "bLengthChange": false,
            "aoColumnDefs": [
                {"bSortable": true, "aTargets": [0, 1, 2, 3, 4, 5, 6, 7]},
                {"bSortable": false, "aTargets": [9, 10]}
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
        
        /*  
         //For update display
         $('#form-update-reg').submit(function(e) {	
         e.preventDefault();				
         var error = '';
         var username =  $('#username').val();
         var gender_id =  $('.gender_id select').val(); //bug cannot get latest value
         console.log($('.gender_id select').val());
         var page_id =  $('.page_id select').val();
         var email_address =  $('#email_address').val();
         var first_name = $('#first_name').val();
         var middle_name =  $('#middle_name').val();
         var last_name = $('#last_name').val();
         var birth_date = $('#birth_date').val();
         
         if(username == '') {
         error += '* Username is required. <br />';
         }
         
         if(error != '') {				
         var err_msg = '<div class="alert alert-warning"><strong>Warning!</strong><br /><br />';
         err_msg += error;
         err_msg += '</div>';
         
         $('#update-msg').html(err_msg);
         } else {				
         var frm = $('#form-update-reg').serialize();	
         var msg = '<div class="alert alert-danger">Failed to update.</div>';
         $('#largeModal-update').modal('hide');
         $('#processing-modal').modal();
         $.ajax({
         type: "POST",
         url: "<?php echo site_url('admin/register/update_user'); ?>",
         data: frm+"&gender_id="+gender_id+"&page_id="+page_id
         }).done(function( data ) {						
         $('#processing-modal').modal('hide');
         if (data != 0) {				
         //$('#form-update-reg')[0].reset();
         msg = '<div class="alert alert-success">Successfully saved changes.</div>';	
         }						
         $('#alert-modal-title').html('Update User Information');
         $('#user-info-alert-msg').html(msg);
         $('#alert-status').modal();
         setTimeout(function(){ window.location.reload(); }, 1000);											
         });
         }
         });
         */

        //For update user status
        $('#form-update-active-inactive').submit(function(e) {
            e.preventDefault();
            var frm = $('#form-update-active-inactive').serialize();
            var msg = '<div class="alert alert-danger">Failed to update.</div>';
            $('#largeModal-active-inactive').modal('hide');
            $('#processing-modal').modal();

            $.ajax({
                type: "POST",
                url: "<?php echo site_url('admin/register/update_user_status'); ?>",
                data: frm
            }).done(function(data) {
                $('#processing-modal').modal('hide');
                if (data != 0) {
                    //$('#form-update-reg')[0].reset();
                    msg = '<div class="alert alert-success">Successfully saved changes.</div>';
                }
                $('#alert-modal-title').html('Update User Status');
                $('#user-info-alert-msg').html(msg);
                $('#alert-status').modal();
//						setTimeout(function(){ window.location.reload(); }, 1000);											
            });

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
                url: "<?php echo site_url('admin/register/reset_password'); ?>",
                data: frm
            }).done(function(data) {
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

        $('input[type=date]').datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            maxDate: new Date
        });

        $(".modal-wide").on("show.bs.modal", function() {
            var height = $(window).height() - 200;
            $(this).find(".modal-body").css("max-height", height);
            $('#form-add')[0].reset();
            $('#form-update-reg')[0].reset();
        });
        
    });

    $(document).on("click", ".open-reset-password-dialog", function() {
        var userId = $(this).data('id');
        $(".modal-body #user_id").val(userId);
    });

    function refresh_page() {
        setTimeout(function() {
            window.location.reload();
        }, 1000);
    }
    //for the add user
    function add_user() {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('admin/register/get_add_user'); ?>",
        }).done(function(data) {
            var json = $.parseJSON(data);
            $('#sister_hood_city').html(json.city);
        });
    }
    //for the update
    function update_reg(param) {

        $.ajax({
            type: "POST",
            url: "<?php echo site_url('admin/register/get_update_user'); ?>",
            data: {reg_id: param}
        }).done(function(data) {
            var json = $.parseJSON(data);
            $('.page_id option[value=' + json.user_type_id + ']').attr('selected', 'selected');
            $("#upd_username").val(json.username);
            $("#upd_email_address").val(json.email_address);
            $("#upd_first_name").val(json.first_name);
            $("#upd_middle_name").val(json.middle_name);
            $("#upd_last_name").val(json.last_name);
            $("#upd_birth_date").val(json.birthdate);
            $('.gender_id option[value=' + json.gender + ']').attr('selected', 'selected');
            $('#hidden-user_id').val(param);
            
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('admin/register/get_add_user'); ?>",
            }).done(function(data) {
                var json = $.parseJSON(data);
                $('#sister_hood_city_update').html(json.city);
            });
            return false;
        });
    }
    //for the update status
    function update_user_status(param) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('admin/register/get_update_user'); ?>",
            data: {reg_id: param}
        }).done(function(data) {
            var json = $.parseJSON(data);
            $('#hidden-username').val(json.username);
            $('#hidden-email_address').val(json.email_address);
            $('#hidden-first_name').val(json.first_name);
            $('#hidden-middle_name').val(json.middle_name);
            $('#hidden-last_name').val(json.last_name);
            $('#hidden-user_id_stat').val(param);
            if (json.active == '1') {
                $('#active_inactive').text('Inactive');
                $('#stat_action').html('Inactive');
                $('#hidden-action').val('0');
            }
            else if (json.active == '0') {
                $('#active_inactive').text('Active');
                $('#stat_action').html('Active');
                $('#hidden-action').val('1');
            }
        });
    }
    function close_update() {
        $('#form-update-reg')[0].reset();
        $("#user_table").dataTable().fnDraw();
    }
    function close_active_inactive() {
        $('#form-update-active-inactive')[0].reset();
        $("#user_table").dataTable().fnDraw();
    }
    function close_save() {
        $('#form-add')[0].reset();
        $("#user_table").dataTable().fnDraw();
    }
</script>
<div id="content" class="col-lg-10 col-sm-10">
    <!-- content starts -->
    <div class=" row">
        <!-- insert the page content here -->
        <h1>User Management</h1>
        <p>
            <button type="button" class="btn btn-xs btn-primary add-subject" data-toggle="modal" data-target="#largeModal" onclick="javascript:add_user();">Add User</button>             
        </p>
        <p>
            <button type="button" class="btn btn-xs btn-primary"  data-toggle="modal" onclick="window.location = '<?php echo site_url("admin/register/report_pdf"); ?>'">Export to PDF</button>             

            <button type="button" class="btn btn-xs btn-primary"  data-toggle="modal" onclick="window.location = '<?php echo site_url("admin/register/report_excel"); ?>'">Export to Excel</button>             
        </p>
        <table id="user_table" class="table table-striped"  width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Email Address</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Middle Name</th>
                    <th>Birthdate</th>
                    <th>Gender</th>
                    <th>User Type</th>
                    <th>Status</th>
                    <th>Status Action</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table> 
    </div>
</div>
<div class="modal fade modal-wide" id="largeModal" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" id="close" aria-hidden="true" onclick="javascript:close_save();">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Register User - Add Users</h4>
            </div>
            <div class="modal-body">
                <div id="add-msg"></div>
                <form id="form-add" class="form-horizontal">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <td width="25%"><strong>User Type*:</strong></td>
                                <td>
                                    <div class="form-group col-sm-5">
                                        <select class="form-control" name = 'u_type_id' id = 'u_type_id'> 
                                            <option id='1'>Administrator</option>
                                            <option id='2'>Makati IRD Employee</option>
                                            <option id='3'>Sister City LGU </option>
                                        </select>
                                        <input type="hidden" value="" name="u_id" id="u_id" />
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Username*:</strong></td>
                                <td>
                                    <div class="form-group col-sm-8">
                                        <input class="form-control" type="text" value="" id="username" name="username" placeholder="Username" 
                                               required autofocus maxlength="50">
                                    </div>
                                </td>
                            </tr>
                        <div class="city_div">
                            <tr>
                                <td><strong>City*:</strong></td>
                                <td>
                                    <div class="form-group col-sm-8" id="sister_hood_city" name="sister_hood_city">
                                    </div>
                                </td>
                            </tr>
                        </div>                            
                        <tr>
                            <td><strong>Email Address*:</strong></td>
                            <td>
                                <div class="form-group col-sm-8">
                                    <input class="form-control" type="email" value="" name="email_address" id="email_address" 
                                           placeholder="Email Address" required autofocus maxlength="150">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>First Name*:</strong></td>
                            <td>
                                <div class="form-group col-sm-8">
                                    <input class="form-control" type="text" value="" name="first_name" placeholder="First Name" 
                                           required autofocus maxlength="150">
                                </div>
                            </td>
                        </tr>	
                        <tr>
                            <td><strong>Middle Name*:</strong></td>
                            <td>
                                <div class="form-group col-sm-8">
                                    <input class="form-control" type="text" value="" name="middle_name" placeholder="Middle Name" 
                                           required autofocus maxlength="150">
                                </div>
                            </td>
                        </tr>   
                        <tr>
                            <td><strong>Last Name*:</strong></td>
                            <td>
                                <div class="form-group col-sm-8">
                                    <input class="form-control" type="text" value="" name="last_name" placeholder="Last Name" 
                                           required autofocus maxlength="150">
                                </div>
                            </td>
                        </tr>   
                        <tr>
                            <td><strong>Birth Date*:</strong></td>
                            <td>
                                <div class="form-group col-sm-8">
                                    <input class="form-control" type="date" placeholder="yyyy-mm-dd" name="birth_date" id="from">
                                </div>
                            </td> 
                        </tr>   
                        <tr>
                            <td><strong>Gender*:</strong></td>
                            <td>
                                <div class="form-group col-sm-4">
                                    <select class="form-control"  name = 'gender' id = 'gender'> 
                                        <option id='0'>Female</option>
                                        <option id='1'>Male</option>
                                    </select>
                                </div>
                            </td>
                        </tr>                                
                        </thead>
                        <tbody>
                        </tbody>
                    </table>					
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="javascript:close_save();">Cancel</button>
                <button type="submit" class="btn btn-primary" id="btn-save">Save Now</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- For the update -->
<div class="modal fade modal-wide" id="largeModal-update" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" id="close_update" onclick="javascript:close_update();" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Update User Information</h4>
            </div>'
            <div class="modal-body">
                <div id="update-msg"></div>

                <form id="form-update-reg" class="form-horizontal">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <td width="25%"><strong>User Type:</strong></td>
                                <td> <div class="page_id form-group col-sm-5">
                                        <select class="form-control">
                                            <option id='1'>Administrator</option>
                                            <option id='2'>Makati IRD Employee</option>
                                            <option id='3'>Sister City LGU </option>
                                        </select>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Username*:</strong></td>
                                <td>
                                    <div class="form-group col-sm-8">
                                        <input class="form-control" type="text" value="" name="upd_username" id="upd_username" 
                                               placeholder="Username" required autofocus maxlength="150">
                                    </div>
                                    <small id="content-error-msg" class="help-block has-error" style="color:#ff4136;"> </small>
                                </td>
                            </tr>
                            <div class="city_div">
                                <tr>
                                    <td><strong>City*:</strong></td>
                                    <td>
                                        <div class="form-group col-sm-8" id="sister_hood_city_update" name="sister_hood_city">
                                        </div>
                                    </td>
                                </tr>
                            </div>     
                            <tr>
                                <td><strong>Email Address*:</strong></td>
                                <td>
                                    <div class="form-group col-sm-8">
                                        <input class="form-control" type="email" value="" name="upd_email_address" id="upd_email_address"
                                               placeholder="Email Address" required autofocus maxlength="150">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>First Name*:</strong></td>
                                <td>
                                    <div class="form-group col-sm-8">
                                        <input class="form-control" type="text" value="" name="upd_first_name" id="upd_first_name" 
                                               placeholder="First Name" required autofocus maxlength="150">
                                    </div>
                                </td>
                            </tr>	
                            <tr>
                                <td><strong>Middle Name*:</strong></td>
                                <td>
                                    <div class="form-group col-sm-8">
                                        <input class="form-control"  type="text" value="" name="upd_middle_name" id="upd_middle_name" 
                                               placeholder="Middle Name" required autofocus maxlength="150">
                                    </div>
                                </td>
                            </tr>   
                            <tr>
                                <td><strong>Last Name*:</strong></td>
                                <td>
                                    <div class="form-group col-sm-8">
                                        <input class="form-control"  type="text" value="" name="upd_last_name" id="upd_last_name" 
                                               placeholder="Last Name" required autofocus maxlength="150">
                                    </div>
                                </td>
                            </tr>   
                            <tr>
                                <td><strong>Birth Date:</strong></td>
                                <td>
                                    <div class="form-group col-sm-8">
                                        <input class="form-control"  type="date" name="upd_birth_date" id="upd_birth_date" required>
                                    </div>
                                </td>
                            </tr>   
                            <tr>
                                <td><strong>Gender:</strong></td>
                                <td>
                                    <div class="gender_id form-group col-sm-4">
                                        <select class="form-control" >
                                            <option value='0'>Female</option>
                                            <option value='1'>Male</option>
                                        </select>
                                    </div>
                                </td>
                            </tr>   				
                        </thead>
                        <tbody>
                        </tbody>
                    </table>					
                    <input type="hidden" value="" name="user_id" id="hidden-user_id">  
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="btn-update">Update Now</button>
                    </div>	  
                </form>
            </div>
        </div>
    </div>

    <!--Activate Inactive-->
    <div class="modal fade" id="largeModal-active-inactive" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" id="close_update" onclick="javascript:close_active_inactive();" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Change User Status</h4>
                </div>	  
                <div class="modal-body">
                    <div id="update-active-inactive-msg"></div>
                    <form id="form-update-active-inactive">
                        Are you sure you want to change the status of this user to <span id="stat_action"> </span>?</td>
                        <input type="hidden" value="" name="user_id" id="hidden-user_id_stat" readonly="readonly"> 
                        <input type="hidden" class="form-control" value="" name="username" id="hidden-username" readonly="readonly">
                        <input type="hidden" class="form-control" value="" name="email_address" id="hidden-email_address" readonly="readonly">  
                        <input type="hidden" class="form-control" value="" name="first_name" id="hidden-first_name" readonly="readonly">  
                        <input type="hidden" class="form-control" value="" name="middle_name" id="hidden-middle_name" readonly="readonly">  
                        <input type="hidden" class="form-control" value="" name="last_name" id="hidden-last_name" readonly="readonly">  

                        <input type="hidden" value="" name="action" id="hidden-action">  
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary" id="btn-update">CHANGE TO <span id= "active_inactive"></span></button>
                        </div>	  
                    </form>
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
                        <input type="hidden" name="user_id" id="user_id" value=""/>
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
                <form id="form-reset-pwd">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span> <span class="sr-only">close</span></button>
                        <h4 class="modal-title">Reset password</h4>
                    </div>
                    <div class="modal-body">
                        <div id="reset-password-alert-msg"></div>
                        An email has been sent to <span id="email_addr"> </span> 
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-default" data-dismiss="modal">OK</button>
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
