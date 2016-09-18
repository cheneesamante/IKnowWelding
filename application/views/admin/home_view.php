<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper" style="min-height: 1096px;">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Dashboard
            <small>Control panel</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">

          <!-- Small boxes (Stat box) -->
          <div class="row">
              <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                  <div class="inner">
                    <h3><?php echo $total_users; ?></h3>
                    <p>Registered Users</p>
                  </div>
                  <a href="<?php echo site_url('admin/users'); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
              </div><!-- ./col -->
          </div><!-- /.row -->
          <br/>
          <?php if($total_new > 0): ?>
          <div class="row">
            <div class="col-md-12">
                  <!-- USERS LIST -->
                  <div class="box box-danger">
            <div class="box-header with-border">
            
                      <h3 class="box-title">Latest Members</h3>
              <div class="box-tools pull-right">
                        <span class="label label-danger"><?php echo $total_new?> Active New Members</span>
              </div>
                    </div><!-- /.box-header -->
                    <div class="box-body no-padding">
                      <ul class="users-list clearfix">
                        <?php  foreach($users as $user): ?>
                        <li>
                          <img src="<?php echo ADMIN_DIST_PATH; ?>/img/user1-128x128.jpg" alt="User Image">
                          <a class="users-list-name"><?php echo $user['name']; ?></a>
                          <span class="users-list-date"><?php echo $user['reg']; ?></span>
                        </li>
                        <?php endforeach; ?>
                      </ul><!-- /.users-list -->
            </div><!-- /.box-body -->
                    <div class="box-footer text-center">
                      <a href="<?php echo site_url('admin/users'); ?>" class="uppercase">View All Users</a>
            </div><!-- /.box-footer-->
          </div><!-- /.box -->
                </div><!-- /.col -->
          </div>
          <?php endif; ?>
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
