<script>
    $(document).ready(function() {
        $('#tbl-cms').dataTable({
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource" : "<?php echo site_url('admin/cms/getAllCMS'); ?>",
            "iDisplayStart": 0,
            "iDisplayLength": 10,
            "sPaginationType": "full_numbers",
            "autoWidth": true,
            "order": [[0, "desc"]],
            "bLengthChange": false,
            "aoColumnDefs": [
                {"bSortable": true, "aTargets": [0, 1, 2, 3]},
                {"bSortable": false, "aTargets": [4]}
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
        
        
        $('.btn-refresh').click(function(e) {	
            window.location.reload();
        });

        });

</script>
	  <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper"  style="min-height: 1096px;">
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

          <!-- Default box -->
              <div class="box">
                <div class="box-header">
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="tbl-cms" class="table table-bordered table-striped">
            <thead>
                <tr>
                        <th>Page</th>
                    <th>Title</th>
                        <th>Last Modified</th>
                    <th>Status</th>
                        <th>&nbsp;</th>
                </tr>
            </thead>

                    </table>					
                </div><!-- /.box-body -->
              </div><!-- /.box -->
       </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

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



