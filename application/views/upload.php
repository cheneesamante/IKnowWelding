<!DOCTYPE HTML>
<html lang="en">
    <head>
    </head>
    <body>
        <form enctype="multipart/form-data" action="<?php echo site_url('uploading'); ?>" method="post" >
            <input type="file" name="files[]" multiple />
            <input type="submit" name="fileSubmit" value="submit" />
            <p> <?=isset($message) ? $message : ""?> </p>
        </form>
    </body>
</html>
