      
    <!-- jQuery 2.1.4 -->
    <script src="<?php echo ADMIN_PLUGIN_PATH; ?>jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo ADMIN_BOOSTRAP_PATH; ?>js/bootstrap.min.js"></script>
    <!-- DataTables -->
    <script src="<?php echo ADMIN_PLUGIN_PATH; ?>datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo ADMIN_PLUGIN_PATH; ?>datatables/dataTables.bootstrap.min.js"></script>
    <!-- SlimScroll -->
    <script src="<?php echo ADMIN_PLUGIN_PATH; ?>slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="<?php echo ADMIN_PLUGIN_PATH; ?>fastclick/fastclick.min.js"></script>

    <!-- page script -->
    <script>
      $(function () {
        $("#example1").DataTable();
        $('#example2').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "ordering": true,
          "info": true,
          "autoWidth": false
        });
      });
    </script>
  </body>
</html>