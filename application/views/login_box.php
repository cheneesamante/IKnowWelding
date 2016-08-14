<link href="<?php echo CSS_PATH; ?>login.css" rel="stylesheet" type="text/css">
<section class="loginbox login-container">
    <div class="login">
      <h1>Login to IKnowWelding</h1>

      <form name="loginform" id="loginform" method="post" action="<?php echo site_url('login/check'); ?>">
        <div id="frm-msg"></div>
        <p><input type="text" name="username" id="username" class="form-control" placeholder="Username or Email" required autofocus></p>
        <p><input type="password" name="password" id="password" class="form-control" placeholder="Password" required></p>
        <p class="submit">        <p>
            <button type="button" class="btn btn-xs btn-primary add-subject" data-toggle="modal" data-target="#largeModal" onclick="javascript:add_user();">Add User</button>
        </p> <input class="btn btn-blue" type="submit" name="commit" value="Sign in"></p>
      </form>
    </div>
</section>


<script>$("#loginform").submit(function(){
                var frm = $('#loginform').serialize();
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('login/check'); ?>",
                    data: frm
                }).done(function(data) {
                    var obj = jQuery.parseJSON (data);
                    console.log(data);
                    if (obj.err == true) {
                        $('#frm-msg').html(obj.msg);
                        $('#frm-msg').addClass('err');
                    } else {
                        $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('login'); ?>",
                    data: frm
                }).done(function(data) {
                    var content = data;
                    location.reload();
                    document.getElementsByTagName("body")[0].innerHTML = content;
                });
                return false;
                    }


                });
                return false;
 });
</script>
