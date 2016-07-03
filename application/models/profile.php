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
    });
    function close_image_upload() {
        setTimeout(function() {
            window.location.reload();
        }, 1000);
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
                            <td>Birth Date:</td>
                            <td><?php echo $profile['birthdate']; ?></td>
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
                <button type="button" class="close" data-dismiss="modal" onclick="javascript:close_image_upload();"><span aria-hidden="true">×</span> <span class="sr-only">close</span></button>
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


