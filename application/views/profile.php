<script>
    $(document).ready(function(e) {
        $("#uploadimage").on('submit', (function(e) {
            e.preventDefault();
            $("#message").empty();
            $('#loading').show();
            $.ajax({
                url: "<?php echo site_url('profile/image_upload'); ?>", // Url to which the request is send
                type: "POST", // Type of request to be send, called as method
                data: new FormData(this), // Data sent to server, a set of key/value pairs representing form fields and values 
                contentType: false, // The content type used when sending data to the server. Default is: "application/x-www-form-urlencoded"
                cache: false, // To unable request pages to be cached
                processData: false, // To send DOMDocument or non processed data file it is set to false (i.e. data should not be in the form of string)
                success: function(data)  		// A function to be called if request succeeds
                {
                    $('#loading').hide();
                    $("#message").html(data);
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                }
            });
        }));

// Function to preview image
        $(function() {
            $("#file").change(function() {
                $("#message").empty();         // To remove the previous error message
                var file = this.files[0];
                var imagefile = file.type;
                var match = ["image/jpeg", "image/png", "image/jpg"];
                if (!((imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2])))
                {
                    $('#previewing').attr('src', '<?php echo UPLOAD_IMG_PATH . 'noimage.png'; ?>');
                    $("#message").html("<p id='error'>Please Select A valid Image File</p>" + "<h4>Note</h4>" + "<span id='error_message'>Only jpeg, jpg and png Images type allowed</span>");
                    return false;
                }
                else
                {
                    var reader = new FileReader();
                    reader.onload = imageIsLoaded;
                    reader.readAsDataURL(this.files[0]);
                }
            });
        });
        function imageIsLoaded(e) {
            $("#file").css("color", "green");
            $('#image_preview').css("display", "block");
            $('#previewing').attr('src', e.target.result);
            $('#previewing').attr('width', '250px');
            $('#previewing').attr('height', '230px');
        }
        ;
      //For update display
    $('#form-update-reg').submit(function(e) {
        e.preventDefault();
        var error = '';
        var username = $('#username').val();
        var gender_id = $('.gender_id select').val(); //bug cannot get latest value
        console.log($('.gender_id select').val());
        var page_id = $('.page_id select').val();
        var email_address = $('#email_address').val();
        var first_name = $('#first_name').val();
        var middle_name = $('#middle_name').val();
        var last_name = $('#last_name').val();
        var birth_date = $('#birth_date').val();

        if (username == '') {
            error += '* Username is required. <br />';
        }

        if (error != '') {
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
                url: "<?php echo site_url('admin/register/update_user2'); ?>",
                data: frm + "&gender_id=" + gender_id + "&page_id=" + page_id
            }).done(function(data) {
                $('#processing-modal').modal('hide');
                if (data != 0) {
                    //$('#form-update-reg')[0].reset();
                    msg = '<div class="alert alert-success">Successfully saved changes.</div>';
                }
                $('#alert-modal-title').html('Update Profile');
                $('#user-info-alert-msg').html(msg);
                $('#alert-status').modal();
//						setTimeout(function(){ window.location.reload(); }, 1000);											
            });
        }
    });   
      //For update password
    $('#form-update-pass').submit(function(e) {
   // alert('211');
        e.preventDefault();
        var error = '';
        var curr_password = $('#curr_password').val();
        var new_password = $('#new_password').val();
        var conf_password = $('#conf_password').val();
        
        if (curr_password == '') {
            error += '* Current Password is required. <br />';
        }
        if (new_password == '') {
            error += '* New Password is required. <br />';
        }
        if (conf_password == '') {
            error += '* Confirm Password is required. <br />';
        }

        if (error != '') {
            var err_msg = '<div class="alert alert-warning"><strong>Warning!</strong><br /><br />';
            err_msg += error;
            err_msg += '</div>';

            $('#update-password').html(err_msg);
        } else {
            var frm = $('#form-update-pass').serialize();
            var msg = '<div class="alert alert-danger">Failed to update.</div>';
            $('#largeModal-update').modal('hide');
            $('#processing-modal').modal();
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('admin/register/update_password'); ?>",
                data: frm
            }).done(function(data) {
                $('#processing-modal').modal('hide');
                if (data == 1) {
                    //$('#form-update-reg')[0].reset();
                    msg = '<div class="alert alert-success">Successfully saved changes.</div>';
                } else {
                    msg = '<div class="alert alert-danger">'+data+'</div>';
                }
                 $('#update-password').html(msg);
                $('#alert-modal-title').html('Update Password');
                $('#user-info-alert-msg').html(msg);
                $('#alert-status').modal();
//						setTimeout(function(){ window.location.reload(); }, 1000);											
            });
        }
    });      
    });
    
    function refresh_page(){
        setTimeout(function(){ window.location.reload(); }, 1000);	
    }
    
    function close_image_upload() {
        setTimeout(function() {
            window.location.reload();
        }, 1000);
    }
    function update_pass(param) {
 $('#hidden-user_id_pass').val(param);
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
            $('input[name="username"]').val(json.username);
            $('input[name="email_address"]').val(json.email_address);
            $('input[name="first_name"]').val(json.first_name);
            $('input[name="middle_name"]').val(json.middle_name);
            $('input[name="last_name"]').val(json.last_name);
            $('input[name="birth_date"]').val(json.birthdate);
            $('.gender_id option[value=' + json.gender + ']').attr('selected', 'selected');
            $('#hidden-user_id').val(param);
        });
    }
        
</script>
<div id="content" class="col-lg-10 col-sm-10">
    <!-- content starts -->

    <div class=" row col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0">
        <br/>
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">My Profile</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-3" align="center"> 
      
                        <a href="#largeModal-image" data-toggle="modal" role="button"> <img alt="User Pic" width="100" height="100" src="<?php echo UPLOAD_IMG_PATH . $profile['image']; ?>" class="img-circle"> </a> </div>
                    <div class=" col-md-9 col-lg-9 "> 
                        <table class="table table-user-information">
                            <tbody>
                                <tr>
                                    <td>Username:</td>
                                    <td><?php echo $profile['username']; ?></td>
                                </tr>
                                <?php if($this->session->userdata('info')['user_type_id'] == SISTER_LGU): ?>
                                <tr>
                                    <td>City Name:</td>
                                    <td><?php echo $profile['city_name']; ?></td>
                                </tr>
                                <?php endif; ?>
                                <tr>
                                    <td>First Name:</td>
                                    <td><?php echo $profile['first_name']; ?></td>
                                </tr>
                                <tr>
                                    <td>Middle Name:</td>
                                    <td><?php echo $profile['middle_name']; ?></td>
                                </tr>
                                <tr>
                                    <td>Last Name:</td>
                                    <td><?php echo $profile['last_name']; ?></td>
                                </tr>
                                <tr>
                                    <td>Gender:</td>
                                    <td><?php echo ($profile['gender'] == 0) ? 'Female' : 'Male'; ?></td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td><?php echo $profile['email_address']; ?></td>
                                </tr>
                                <tr>
                            <td>Birth Date:</td>
                            <td><?php echo $profile['birthdate']; ?></td>
                                </tr>
                                <tr>
                                    <td>
                                        <button type='button' onclick='javascript:update_pass("<?php echo $profile['user_id']; ?>");' data-toggle='modal' data-target='#largeModal-pass' class="btn btn-xs btn-primary">Change Password</button>
                                    </td>
                                    <td>
                                        <button type='button' onclick='javascript:update_reg("<?php echo $profile['user_id']; ?>");' data-toggle='modal' data-target='#largeModal-update' class="btn btn-xs btn-primary">Update</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>


                    </div>


                </div>
            </div>

        </div>

    </div>

</div>
<!-- For image upload start -->
<div id="largeModal-image" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" onclick="javascript:close_image_upload();"><span aria-hidden="true">�</span> <span class="sr-only">close</span></button>
                <h4 class="modal-title">Select Your Image</h4>
            </div>
            <form id="uploadimage" action="" method="post" enctype="multipart/form-data">
                <label>  </label>
                <div id="image_preview"><img id="previewing" width="200" height="200" src="<?php echo UPLOAD_IMG_PATH . $profile['image'] ?>" /></div>
                <h4 id='loading' style="display:none;">loading...</h4>
                <hr id="line">    
                <div id="selectImage">
                    <br/>
                    <input type="file" name="file" id="file" required />
                    <input type="submit" value="Upload" class="submit" />
                </div>                   
            </form>		

            <div id="message"> 			
            </div>
        </div>
    </div>
</div>
<!-- For image upload end -->
<!-- For the update -->
<div class="modal fade" id="largeModal-update" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content" style="max-height:760px; overflow:auto;">
                <div class="modal-header">
                <button type="button" class="close" id="close_update" onclick="javascript:close_image_upload();" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Update User Information</h4>
                </div>
                <div class="modal-body">
                <div id="update-msg"></div>

                <form id="form-update-reg" class="form-horizontal" data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
                      data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
                      data-bv-feedbackicons-validating="glyphicon glyphicon-refresh">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <td><strong>Username*:</strong></td>
                                <td>
                                    <div class="form-group col-sm-8">
                                        <input class="form-control" type="text" value="" name="username" id="username" 
                                               placeholder="Username" required autofocus maxlength="150" 
                                               data-bv-notempty-message="* Username is required">
                        </div>
                                    <small id="content-error-msg" class="help-block has-error" style="color:#ff4136;"> </small>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Email Address*:</strong></td>
                                <td>
                                    <div class="form-group col-sm-8">
                                        <input class="form-control" type="email" value="" name="email_address" id="email_address"
                                               placeholder="Email Address" required autofocus maxlength="150"
                                               data-bv-emailaddress-message="The value is not a valid email address"
                                               data-bv-notempty-message="* Email Address is required">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>First Name*:</strong></td>
                                <td>
                                    <div class="form-group col-sm-8">
                                        <input class="form-control" type="text" value="" name="first_name" id="first_name" 
                                               placeholder="First Name" required autofocus maxlength="150"
                                               data-bv-notempty-message="* First Name is required">
                                    </div>
                                </td>
                            </tr>	
                            <tr>
                                <td><strong>Middle Name*:</strong></td>
                                <td>
                                    <div class="form-group col-sm-8">
                                        <input class="form-control"  type="text" value="" name="middle_name" id="middle_name" 
                                               placeholder="Middle Name" required autofocus maxlength="150"
                                               data-bv-notempty-message="* Middle Name is required">
                                    </div>
                                </td>
                            </tr>   
                            <tr>
                                <td><strong>Last Name*:</strong></td>
                                <td>
                                    <div class="form-group col-sm-8">
                                        <input class="form-control"  type="text" value="" name="last_name" id="last_name" 
                                               placeholder="Last Name" required autofocus maxlength="150"
                                               data-bv-notempty-message="* Last Name is required">
                                    </div>
                                </td>
                            </tr>   
                            <tr>
                                <td><strong>Birth Date:</strong></td>
                                <td>
                                    <div class="form-group col-sm-8">
                                        <input class="form-control"  type="date" name="birth_date" id="birth_date" 
                                               min="<?php echo date('Y-m-d'); ?>" required
                                               data-bv-notempty-message="* Birth Date is required">
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
                <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="btn-update">Update Now</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
<!-- For the update password -->
<div class="modal fade" id="largeModal-pass" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content" style="max-height:760px; overflow:auto;">
            <div class="modal-header">
                <button type="button" class="close" id="close_update" onclick="javascript:close_image_upload();" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Change Password</h4>
            </div>
            <div class="modal-body">
                <div id="update-password"></div>
                <form id="form-update-pass" class="form-horizontal" data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
                      data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
                      data-bv-feedbackicons-validating="glyphicon glyphicon-refresh">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <td><strong>Current Password*:</strong></td>
                                <td>
                                    <input type="password" class="form-control" name="curr_password" placeholder="Current Password" required>
                                    <small id="content-error-msg" class="help-block has-error" style="color:#ff4136;"> </small>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>New Password*:</strong></td>
                                <td>
                                    <div class="form-group col-sm-8">
                                        <input class="form-control" type="password" value="" name="new_password" id="new_password"
                                               placeholder="New Password" required autofocus maxlength="15"
                                               data-bv-notempty-message="* New Password is required">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Confirm Password*:</strong></td>
                                <td>
                                    <div class="form-group col-sm-8">
                                        <input class="form-control" type="password" value="" name="conf_password" id="conf_password"
                                               placeholder="Confirm Password" required autofocus maxlength="15"
                                               data-bv-notempty-message="* Confirm Password is required">
                                    </div>
                                </td>
                            </tr>	

                        <tbody>
                        </tbody>
                    </table>					
                    <input type="hidden" value="" name="user_id" id="hidden-user_id_pass">  
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="btn-update-password">Change Password</button>
                    </div>	  
                </form>
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
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">�</span> <span class="sr-only">close</span></button>
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
