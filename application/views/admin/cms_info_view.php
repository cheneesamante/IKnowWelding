<script>
    $(document).ready(function () {
        $("#form-update-cms").validate({
            
            rules: {
                name: "required",
                title: "required",
              },
            messages: {
      name: "Please enter page name",
      title: "Please enter page title",
            },
            submitHandler: function(form) {
              var error = '';
            var msg = '<div class="alert alert-danger">Failed to update.</div>';

            $('#processing-modal').modal();
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('admin/cms/update_page_info'); ?>",
                data: $("#form-update-cms").serialize()
            }).done(function (data) {
                $('#processing-modal').modal('hide');

                var json_data = JSON.parse(data);
                if (json_data.status != false) {
                    msg = '<div class="alert alert-success">Successfully updated.</div>';
                }
                $('#update-msg').html(msg);
                $('#update-successful').modal();
            });
            }
          });
       

        $('.btn-refresh').click(function (e) {
            window.location.reload();
        });

    });
</script>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Content Management System
        </h1>
        <ol class="breadcrumb">
          <!--<li><a href="#"><i class="fa fa-dashboard"></i> Registered Users</a></li>
          <li><a href="#">Tables</a></li>
          <li class="active">Data tables</li>-->
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Page Information</h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            <form role="form" name="form-update-cms" id="form-update-cms">
                <div class="box-body">
                    <div class="form-group">
                        <label for="name">Page</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="" value="<?php echo isset($cms['page_name']) ? $cms['page_name'] : "" ?>">
                    </div>
                    <div class="form-group">
                        <label for="surname">Title</label>
                        <input type="text" class="form-control" name="title" id="title" placeholder="" value="<?php echo isset($cms['title']) ? $cms['title'] : "" ?>">
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select id="status" name="status" class="form-control select2" style="width: 100%;">
                            <option <?php echo isset($cms['active']) && $cms['active'] == 0 ? "selected='selected'" : "" ?> value="0">Inactive</option>
                            <option <?php echo isset($cms['active']) && $cms['active'] == 1 ? "selected='selected'" : "" ?> value="1">Active</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Order</label>
                        <select id="order" name="order" class="form-control select2" style="width: 100%;">
                            <?php foreach (range(1, $count) as $ord): ?>
                                <option <?php echo isset($cms['ord']) && $cms['ord'] == $ord ? "selected='selected'" : "" ?> value="<?php echo $ord; ?>"><?php echo $ord; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Content</label>
                        <div class="box-body pad">
                            <textarea id="editor" name="editor" rows="120" cols="100">
                                <?php echo isset($cms['body']) ? $cms['body'] : "" ?>
                            </textarea>
                        </div>
                    </div>

                </div>
                <br/>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                </div>
            </form>
        </div>
    </section>	
</div><!-- /.col (right) -->

<script>
    $(function () {
        // Replace the <textarea id="editor1"> with a CKEditor
        // instance, using default configuration.
        CKEDITOR.replace('editor');
        CKEDITOR.config.height = 550;
    });
</script>

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

<!-- For update info alert -->
<div id="update-successful" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span> <span class="sr-only">close</span></button>
                <h4 class="modal-title">Update Page Info</h4>
            </div>
            <div class="modal-body">
                <div id="update-msg"></div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-default btn-refresh" data-dismiss="modal">OK</button>
            </div>	  

        </div>
    </div>
</div>
