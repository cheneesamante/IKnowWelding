<script>
    $(document).ready(function () {  
    	$("#frm-login").submit(function(){
    		var frm = $('#frm-login').serialize();
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('admin/login/check'); ?>",
                data: frm
            }).done(function(data) {
                var obj = jQuery.parseJSON (data);
                
                if(obj.err == 'true'){
                	console.log('error');
                } else {
                	window.location = "<?php echo site_url('admin/home'); ?>"
                }
            });
            return false;   
    	});
    });

</script>

  <body class="hold-transition login-page">
    <div class="login-box">
      <div class="login-logo">
        <a href="<?php echo site_url('admin/login'); ?>"><b>IknowWelding </b> Admin</a>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <p class="login-box-msg">Log in</p>
        <form id="frm-login" method="post">
          <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Username" name="username">
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" placeholder="Password" name="password">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-12">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
            </div><!-- /.col -->
          </div>
        </form>
      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->
  </body>
</html>
