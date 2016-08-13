<script>

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
                    <form role="form">
                      <div class="box-body">
                        <div class="form-group">
                            <label for="name">Page</label>
                            <input type="text" class="form-control" id="name" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="surname">Title</label>
                            <input type="text" class="form-control" id="surname" placeholder="">
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select id="status" name="status" class="form-control select2" style="width: 100%;">
                                <option selected="selected">Inactive</option>
                                <option value="">Active</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Content</label>
                            <div class="box-body pad">
                              <form>
                                <textarea id="editor" name="editor" rows="120" cols="100">
                                    This is my textarea to be replaced with CKEditor.
                                </textarea>
                              </form>
                            </div>
                        </div>
                         
                    </div>
                    <br/>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
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