
  
<div id="content" class="col-lg-10 col-sm-10">
            <!-- content starts -->
<div class="row">
    <div class="box col-md-4">
        <div class="box-inner homepage-box">
            <div class="box-header well">
                <h2><i class="glyphicon glyphicon-th"></i> Message Summary</h2>
                <div class="box-icon">
                    <a href="#" class="btn btn-minimize btn-round btn-default"><i
                            class="glyphicon glyphicon-chevron-up"></i></a>
                    <a href="#" class="btn btn-close btn-round btn-default"><i
                            class="glyphicon glyphicon-remove"></i></a>
                </div>
            </div>
            <div class="box-content">
                <ul class="nav nav-tabs" id="myTab">
                    <li class="active"><a href="#info">Recent Msg</a></li>
                    <li><a href="#custom">Recent Sent Msg</a></li>
                </ul>

                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane active" id="info">
                        <?php 
                           $subject_recent_msg = 'N/A';
                           $sender_recent_msg = 'N/A';
                           $body_recent_msg = 'N/A';
                           $cdate_recent_msg = 'N/A';
                           $subject_sent_msg = 'N/A';
                           $sender_sent_msg = 'N/A';
                           $body_sent_msg = 'N/A';
                           $cdate_sent_msg = 'N/A';
                           if(isset($recent_msg['subject'])) {
                            $subject_recent_msg = $recent_msg['subject'];
                           }
                           if(isset($recent_msg['sender_name'])) {
                            $sender_recent_msg = $recent_msg['to_name'];
                           }
                           if(isset($recent_msg['body'])) {
                            $body_recent_msg = $recent_msg['body'];
                           }
                           if(isset($recent_msg['cdate'])) {
                            $cdate_recent_msg = $recent_msg['cdate'];
                           }
                           if(isset($recent_sent_msg['subject'])) {
                            $subject_sent_msg = $recent_sent_msg['subject'];
                           }
                           if(isset($recent_sent_msg['sender_name'])) {
                            $sender_sent_msg = $recent_sent_msg['sender_name'];
                           }
                           if(isset($recent_sent_msg['body'])) {
                            $body_sent_msg = $recent_sent_msg['body'];
                           }
                           if(isset($recent_sent_msg['cdate'])) {
                            $cdate_sent_msg = $recent_sent_msg['cdate'];
                           }
                           ?>
                        <p>Subject: <?php echo $subject_sent_msg; ?>
                        </p>
                        <small>From: <?php echo $sender_sent_msg; ?> </small>
                        <p>Message: <?php echo $body_sent_msg; ?></p>
                        <p>Date: <?php echo $cdate_sent_msg; ?></p>
                        <br>
                    </div>
                    <div class="tab-pane" id="custom">
                        <p>Subject: <?php echo $subject_recent_msg; ?>
                        </p>
                        <small>To: <?php echo $sender_recent_msg; ?> </small>
                        <p>Message: <?php echo $body_recent_msg; ?></p>
                        <p>Date: <?php echo $cdate_recent_msg; ?></p>
                        <br>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!--/span-->

    <div class="box col-md-4">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-user"></i> Users Counter </h2>

                <div class="box-icon">
                    <a href="#" class="btn btn-minimize btn-round btn-default"><i
                            class="glyphicon glyphicon-chevron-up"></i></a>
                    <a href="#" class="btn btn-close btn-round btn-default"><i
                            class="glyphicon glyphicon-remove"></i></a>
                </div>
            </div>
            <div class="box-content">
                <div class="box-content">
                    <ul class="dashboard-list">
                        <li> 
                            <a href="#">          
                            <i class="glyphicon glyphicon-user"></i>
                            <span class="green"><?php echo $admin_cnt; ?></span>
                            Administrator
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="glyphicon glyphicon-user"></i>
                            <span class="red"><?php echo $ird_cnt; ?></span>
                            IRD Employee
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="glyphicon glyphicon-user"></i>
                            <span class="yellow"><?php echo $sister_cnt; ?></span>
                            Sister LGU
                        </a>
                    </li>
                          
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!--/span-->

    <div class="box col-md-4">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-list-alt"></i> Today's Reservation</h2>
                <div class="box-icon">
                    <a href="#" class="btn btn-minimize btn-round btn-default"><i
                            class="glyphicon glyphicon-chevron-up"></i></a>
                    <a href="#" class="btn btn-close btn-round btn-default"><i
                            class="glyphicon glyphicon-remove"></i></a>
                </div>
            </div>
            <div class="box-content">
                <div class="box-content">
                    <?php 
                    if(0 == count($today_reserve)){
                    	echo "<i> No data available for display </i>";
                    } else {
                    ?>
                    <ul class="dashboard-list">
                        <?php foreach($today_reserve as $key => $value): ?>
                        <li> 
                            <strong>Reservation Name: </strong> <a href="#"><?php echo  $value['reservation_name']; ?>
                            </a><br>
                            <strong>Reserved By: </strong><?php echo  $value['reserve_by']; ?><br>
                            <strong>Approved By: </strong> <?php echo  $value['approved_by']; 
                            if($value['status'] == 1){ $status = 'Needs Action'; } 
                            elseif($value['status'] == 2){ $status = 'Reserved';} 
                            elseif($value['status'] == 3){ $status = 'Rejected';} 
                            else { $status = 'Pending'; }  
                            ?> <br />
                            <strong>Status: </strong> <span class="label-success label label-default"><?php echo  $status; ?></span>
                        </li>
                        <?php endforeach; ?>
        </ul>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <!-- My Reservation  -->
    <div class="box col-md-4">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-list-alt"></i>My Reservation for <?php echo date("F")?></h2>
                <div class="box-icon">
                    <a href="#" class="btn btn-minimize btn-round btn-default"><i
                            class="glyphicon glyphicon-chevron-up"></i></a>
                    <a href="#" class="btn btn-close btn-round btn-default"><i
                            class="glyphicon glyphicon-remove"></i></a>
                </div>
            </div>
            <div class="box-content">
                <div class="box-content">
                    <?php 
                    if(0 == count($my_reserve)){
                    	echo "<i> No data available for display </i>";
                    } else {
                    ?>
                    <ul class="dashboard-list">
                        <?php foreach($my_reserve as $key => $value): ?>
                        <li> 
                            <strong>Reservation Name: </strong> <a href="#"><?php echo  $value['reservation_name']; ?>
                            </a><br>
                            <strong>Reservation Date: </strong><?php echo date("F d, Y", strtotime($value['reservation_date'])); ?><br>
                            <strong>Approved By: </strong> <?php echo  $value['approved_by']; 
                            if($value['status'] == 1){ $status = 'Needs Action'; $stat_class = 'label-warning label label-default';} 
                            elseif($value['status'] == 2){ $status = 'Reserved'; $stat_class = 'label-success label label-default';} 
                            elseif($value['status'] == 3){ $status = 'Rejected'; $stat_class = 'label-default label label-danger';} 
                            else { $status = 'Pending'; $stat_class = 'label-warning label label-default'; }  
                            ?> <br />
                            <strong>Status: </strong> <span class="<?php echo $stat_class; ?>"><?php echo  $status; ?></span>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                    <?php
                    }
                    ?>
      </div>
    </div>
        </div>
    </div>
    <!--/span-->
</div><!--/row-->
    </div>
    </div>
