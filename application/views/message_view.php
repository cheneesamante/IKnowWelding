<script type="text/javascript" src="<?php echo JS_PATH; ?>jquery.autocomplete.js"></script>
<script>
    $(document).ready(function() {
        
         $("#tag").autocomplete("<?php echo site_url('common/message/auto_complete_recipient'); ?>", {                     
        selectFirst: true
         });

//       $('select[name=recipient_id]').change(function(){
//               var id = $(this).find(':selected')[0].id;
//               $('#to_recipient').val(id);
//         });
      $('#tag').bind('change', function(){
          
            var newvalue = $(this).val();
        });
       $('#tag').blur(function(){
            var id = $('#tag').val();
             var arr = id.split('-');
             var newvalueid = $.trim(arr[1]);
            $('#to_recipient').val(newvalueid);
            
         });
        //show full messages
         $(".full-message").hide('slow');
               $(".list-group-item").click(function() {
                  $(".full-message").hide();
                  $(this).parent().children(".full-message").slideToggle(500);
          });
          

        $('#form-message').submit(function(e) {
            e.preventDefault();
            var error = '';
            //var page = $('#t').editable('getText');
//            var textarea = $('#textarea_message').editable('getText');
            var textarea = $('#textarea_message').val();
            var subject = $('#subject').val();
            var to = $('#to_recipient').val();
            $('#largeModal').modal('hide');
            if (textarea == '') {
                error += 'Message is required. <br />';
            }
            if (subject == '') {
                error += 'Subject is required. <br />';
            }
            if (to == '') {
                error += 'The recipient doesnt exist. <br />';
            }

            if (error != '') {
                
                var err_msg = '<div class="alert alert-warning"><strong>Warning!</strong><br /><br />';
                err_msg += error;
                err_msg += '</div>';

                //$('#add-msg').html(err_msg);
                $('#err-info-alert-msg').html(err_msg);
                 $('#err-status').modal();
            } else {
                $('#processing-modal').modal();
                var frm = $('#form-message').serialize();
                var to = $('#to_recipient').val();
                var subject = $('#subject').val();
                var priority = $('#priority').val();
//                var message = $('#textarea_message').editable('getHTML');
                var message = $('#textarea_message').val();
                var msg = '<div class="alert alert-danger">Failed to insert data.</div>';
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('common/message/send'); ?>",
                    data: frm + "&to=" + to + "&subject=" + subject + "&priority=" + priority + "&message=" + message
                }).done(function(data) {
                    $('#processing-modal').modal('hide');
                    if (data == 1) {
                        $('#form-message')[0].reset();
                        msg = '<div class="alert alert-success">Successfully send message.</div>';
                    }else if (data == 2) {
                       // $('#form-message')[0].reset();
                        msg = '<div class="alert alert-danger">Failed to send message. <br /> The recipient doesnt exist.</div>';
                    }else if (data == 3) {
                     //   $('#form-message')[0].reset();
                        msg = '<div class="alert alert-danger">Failed to send message. <br />Subject cannot be empty.</div>';
                    } else if (data == 4) {
                     //   $('#form-message')[0].reset();
                        msg = '<div class="alert alert-danger">Failed to send message. <br />Message cannot be empty.</div>';
                    }
                    $('#add-msg').html(msg);
                    $('#alert-modal-title').html('Compose');
                    $('#user-info-alert-msg').html(msg);
                    $('#alert-status').modal();
                });
            }
        });
        //delete start
          $('#form-delete-msg').submit(function(e) {	
            e.preventDefault();	
            var frm = $(this).serialize();
            var msg = '';
         //   $('#largeModal-delete').modal('hide');
            $('#processing-modal').modal();
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('common/message/delete'); ?>",
                data: frm
            }).done(function( data ) {		
                $('#processing-modal').modal('hide');
          
                if (data == 1) {			
                    msg = '<div class="alert alert-success">Message has been successfully deleted.</div>';
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                }  else {
                    msg = '<div class="alert alert-danger">Failed to delete message.</div>';
                 }
                $('#delete-msg').html(msg);
            });
            
        });
        //delete end
        
        $(".modal-wide").on("show.bs.modal", function() {
            var height = $(window).height() - 200;
            $(this).find(".modal-body").css("max-height", height);
            $('#form-delete-msg')[0].reset();
        });
        
       initialize_panel();

        
        $(document).on('click', '.panel-heading', function(e){
            var $this = $(this);
            if(!$this.hasClass('panel-collapsed')) {
                    initialize_panel();
                    $this.parents('.panel').find('.panel-body').slideUp();
                    $this.addClass('panel-collapsed');
                    $this.parents('.panel').find('.panel-body').css('height', '');
            } else {
                    $this.parents('.panel').find('.panel-body').slideDown();
                    $this.removeClass('panel-collapsed');
            }
        });
        
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            var target = $(e.target).attr("href") // activated tab
            var tab = getSelectedTabIndex();
            var start;
            
            if (tab == 0) {
                $("#msg_start").html($("#inbox").data("msg_start"));
                $("#msg_end").html($("#inbox").data("msg_end"));
                $("#total_msg").html($("#inbox").data("total_msg"));
                div = $('#inbox_msgs');
                start = parseInt($("#inbox").data("msg_start"));
            } else if (tab == 1) {
                $("#msg_start").html($("#sent").data("msg_start"));
                $("#msg_end").html($("#sent").data("msg_end"));
                $("#total_msg").html($("#sent").data("total_msg"));
                div = $('#sent_msgs');
                start = parseInt($("#sent").data("msg_start"));
            }
            
           
            
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('common/message/retrieve_messages'); ?>",
                data: { type: tab, start:start-1 },
                success: function( data ){
                    console.log(data);
                    var json_data = JSON.parse(data);
                    if(json_data.number_of_msg == 0){
                         div.html('<div class="well text-center"><p><i>No Message</i></p></div>');
                    } else {
                        div.html(json_data.content);    
                    }
                    initialize_panel();
                    if (tab == 0) {
                        $("#inbox_msgs .panel:not(:first-child)").css("margin-top", "-25px");
                        $("#inbox_msgs .panel-body").collapse("hide");
                    } else if (tab == 1) {
                        $("#sent_msgs .panel:not(:first-child)").css("margin-top", "-25px");
                        $("#sent_msgs .panel-body").collapse("hide");
                    }
                    
                    
                }
            });
            return false;
            
        });
        
    });
    
    function display_form(frm){
        $('#largeModal').modal();
        $('#err-status').modal('hide');
    }
    
    function initialize_panel(){
        $("#inbox_msgs .panel-body").collapse("hide");
        $("#sent_msgs .panel-body").collapse("hide");
        
        $("#inbox").data("msg_start", <?=($total_msgs == 0 ? 0 : 1)?>);
        $("#inbox").data("msg_end", <?=($total_msgs > MSG_DISP_LIMIT) ? MSG_DISP_LIMIT : (count($total_msgs) == 0 ? 0 : $total_msgs); ?>);
        $("#inbox").data("total_msg", <?=$total_msgs?>);

        $("#sent").data("msg_start", <?=($total_send == 0 ? 0 : 1)?>);
        $("#sent").data("msg_end", <?=($total_send > MSG_DISP_LIMIT) ? MSG_DISP_LIMIT : (count($total_send) == 0 ? 0 : $total_send); ?>);
        $("#sent").data("total_msg", <?=$total_send?>);
    }

    function get_data(id){
        $('#thread_id').val(id);
    }
   function close_delete(){     
         $('#form-delete-msg')[0].reset();
          setTimeout(function() {
           window.location.reload();
         }, 1000); 
     }
   function close_message(){     
         $('#form-message')[0].reset();
          setTimeout(function() {
           window.location.reload();
         }, 1000); 
     }
     
    function refresh_page() {
        setTimeout(function() {
            window.location.reload();
        }, 1000);
    }
     
    function retrieveMessages(navigation) { 

       var type = getSelectedTabIndex();
       var start;
       var prev;
       var next;
       var nav = 0;
       var LIMIT = 10;
       
       if(0 == navigation){
           start =  parseInt($('#msg_start').text());
           next = (start > LIMIT) ? start - 1 : '';
           nav = 1;
       } else if (1 == navigation) {
           start =  parseInt($('#msg_end').text());

           prev = (start > LIMIT) ? start + 1 : '';
       }
       
       
       if(start > 0 && start >= LIMIT){
           $.ajax({
                type: "POST",
                url: "<?php echo site_url('common/message/retrieve_messages'); ?>",
                data: { type: type, start:start, next:next, prev:prev, nav:nav },
                success: function( data ){
                    var json_data = JSON.parse(data);
                    if(json_data.number_of_msg > 0){
                        
                        initialize_panel();
                        
                        if(0 == navigation){
                            $('#msg_start').text((next - json_data.number_of_msg == 0) ? 1 : next - json_data.number_of_msg);
                            $('#msg_end').text(next);
                        } else if (1 == navigation) {
                            $('#msg_start').text(start + 1);
                            $('#msg_end').text(start + json_data.number_of_msg);
                        }
                        $('#total_msg').text(json_data.total);
 
                        if (type == 0) {
                            $('#inbox_msgs').html(json_data.content);
                            $("#inbox_msgs .panel:not(:first-child)").css("margin-top", "-25px");
                            $("#inbox_msgs .panel-body").collapse("hide");
                        } else if (type == 1) {
                            $('#sent_msgs').html(json_data.content);
                            $("#sent_msgs .panel:not(:first-child)").css("margin-top", "-25px");
                            $("#sent_msgs .panel-body").collapse("hide");
                        }
                    }
                }
            });
            return false;
       }
    }
    
    function getSelectedTabIndex() { 
        var current_tab = $('#tabs .active');
        return current_tab.index();
    }
     
        
</script>

<div id="content" class="col-lg-10 col-sm-10">
    <!-- content starts -->
    <!-- insert the page content here -->
    <h2>Messages</h2>
    
    <div class="row">
        <div class="col-sm-3 col-md-2" style="margin-top:20px;">
            <a style="" href="#largeModal" class="btn btn-primary btn-sm btn-block" data-toggle="modal" role="button">
                <i class="glyphicon glyphicon-edit"></i> Compose
            </a>
        </div>
    </div>
    <hr>
    <div id="tabs" class="row">
        <div class="col-sm-12 col-md-12">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#inbox" data-toggle="tab" style="margin-bottom: 0px;">
                        <span class="glyphicon glyphicon-inbox"></span> Inbox
                    </a>
                </li>
                <li>
                    <a href="#sent" data-toggle="tab" >
                        <span class="glyphicon glyphicon-send"></span> Sent
                    </a>
                </li>
                <div class="pull-right">
                    <span class="text-muted">
                        <b><span id="msg_start"><?=($total_msgs == 0 ? 0 : 1)?></span></b>–
                        <b><span id="msg_end"><?=($total_msgs > MSG_DISP_LIMIT) ? MSG_DISP_LIMIT : (count($total_msgs) == 0 ? 0 : $total_msgs); ?></span></b> of 
                        <b><span id="total_msg"><?=$total_msgs?></span></b>
                    </span>
                    <div class="btn-group btn-group-sm">
                        <button type="button" class="btn btn-default" onclick="javascript:retrieveMessages(0)">
                            <span class="glyphicon glyphicon-chevron-left"></span>
                        </button>
                        <button type="button" class="btn btn-default" onclick="javascript:retrieveMessages(1)">
                            <span class="glyphicon glyphicon-chevron-right"></span>
                        </button>
                    </div>
                </div>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane fade in active" id="inbox">
                    <div class="tab-content">
                        <div class="tab-pane fade in active">
                            <a class="list-group-item">
                                <span class="glyphicon glyphicon-envelope"></span>
                                <span class="name" style="min-width: 120px; display: inline-block;">
                                    &nbsp; From
                                </span> 
                                <span class=""></span>
                                    Subject
                                </span> 
                                <span class="badge"></span> 
                                <span class="pull-right">Date & Time</span>
                            </a>
                            <div id="inbox_msgs">
                            <?php if(isset($msgs['retval'])) {
                                foreach($msgs['retval'] as $key => $val): ?>    
                                    <div class="panel" style="border-color: transparent;">
                                        <div class="panel-heading clickable" style="margin-bottom: -25px;">
                                                <span class="glyphicon glyphicon-user"></span>
                                                <span class="name ellipsis" original-title="<?php echo $val['messages'][0]['sender_name']; ?>">
                                                        &nbsp; <?php echo $val['messages'][0]['sender_name']; ?>
                                                </span> 
                                                <span class="ellipsis" original-title="<?php echo $val['messages'][0]['subject']; ?>">
                                                    <?php echo $val['messages'][0]['subject']; ?></span>
                                                <span class="text-muted ellipsis" style="font-size: 11px;">
                                                        - <span style="text-overflow: ellipsis;"> <?php echo strip_tags($val['messages'][0]['body']) ?>
                                                        </span>
                                                </span>
                                                <span class="pull-right badge"><?php echo $val['messages'][0]['cdate']; ?></span> 
                                        </div>
                                        <div class="panel-body well" style="margin-top: 25px; border:0px;">
                                            <p>Subject: <?php echo $val['messages'][0]['subject']; ?> </p>
                                            <p>Message: <?php echo $val['messages'][0]['body']; ?> </p>
                                            
                                            <a style="" href="#largeModal" class="btn btn-sm btn-primary" data-toggle="modal" role="button">
                                                <i class="glyphicon glyphicon-share-alt"></i> REPLY
                                            </a>

                                            <a href="#largeModal-delete" class="btn btn-sm btn-primary" onclick="javascript:get_data('<?php echo $val['messages'][0]['id']; ?>')"  
                                               data-toggle="modal" role="button">  <i class="glyphicon glyphicon-trash"></i> DELETE </a>
                                        </div>
                                    </div>
                                <?php endforeach; } else { ?>
                                <div class="well text-center"> 
                                    <p><i>No Message</i></p>
                                </div>
                                <?php  } ?>
                            </div>
             
			</div>
                    </div>
                </div>
                <div class="tab-pane fade in" id="sent">
                    <div class="tab-content">
                        <div class="tab-pane fade in active">
                            <a class="list-group-item">
                                <span class="glyphicon glyphicon-envelope"></span>
                                <span class="name" style="min-width: 120px; display: inline-block;">
                                        &nbsp; To
                                </span> 
                                <span class=""></span>
                                        Subject
                                </span> 
                                <span class="badge"></span> 
                                <span class="pull-right">Date & Time</span>
                            </a>
                            <div id="sent_msgs">
                            <?php if(isset($send)) {
                                foreach($send as $key => $val): ?>    
                                    <div class="panel" style="border-color: transparent;">
                                        <div class="panel-heading clickable" style="margin-bottom: -25px;">
                                                <span class="glyphicon glyphicon-user"></span>
                                                <span class="name ellipsis" original-title="<?php echo $val['to_name']; ?>">
                                                        &nbsp; <?php echo $val['to_name']; ?>
                                                </span> 
                                                <span class="ellipsis" original-title="<?php echo $val['subject']; ?>">
                                                    <?php echo $val['subject']; ?></span>
                                                <span class="text-muted ellipsis" style="font-size: 11px;">
                                                        - <?php echo substr(strip_tags($val['body']), 0, 25); ?>
                                                </span>
                                                <span class="pull-right badge"><?php echo $val['cdate']; ?></span> 
                                        </div>
                                        <div class="panel-body well" style="margin-top: 25px; border:0px;">
                                            <p>Subject: <?php echo $val['subject']; ?> </p>
                                            <p>Message: <?php echo $val['body']; ?> </p>
                                                
                                            <a style="" href="#largeModal" class="btn btn-sm btn-primary" data-toggle="modal" role="button">
                                                <i class="glyphicon glyphicon-share-alt"></i> REPLY
                                            </a>

                                            <a href="#largeModal-delete" class="btn btn-sm btn-primary" onclick="javascript:get_data('<?php echo $val['id']; ?>')"  
                                               data-toggle="modal" role="button">  <i class="glyphicon glyphicon-trash"></i> DELETE </a>
                                        </div>
                                    </div>
                                <?php endforeach; } else { ?>
                                <div class="well text-center"> 
                                    <p><i>No Message</i></p>
                                </div>
                            <?php  } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



 <!-- For delete -->
<div id="largeModal-delete" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="form-delete-msg">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" onclick="javascript:close_delete();"><span aria-hidden="true">×</span> <span class="sr-only">close</span></button>
                    <h4 class="modal-title">Delete Message</h4>
                </div>
                <div class="modal-body">
                    <div id="delete-msg"></div>
                    Are you sure you want to delete this message?
                    <input type="hidden" name="thread_id" id="thread_id" value=""/>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="javascript:close_delete();">Cancel</button>
                    <button type="submit" class="btn btn-default">OK</button>
                </div>
            </form>
        </div>
    </div>
</div>
 <!-- delete end -->
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
</div><!-- Compose message modal start -->

    <div class="modal" id="largeModal" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" id="close_update" onclick="javascript:close_message();" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4></span>&nbsp; Compose Message</h4>
                </div>
                <div id="add-msg"></div>
                <div class="modal-body">
                    <form id="form-message" name="form-message" class="form-horizontal">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <td width="10%"><strong>To:</strong></td>
                                <td>
                                    <div class="col-sm-12">
                                    <input type="text" class="form-control" value="" name="tag" id="tag" size="20" />
                                        <input type="hidden" value="" name="to_recipient" id="to_recipient" />
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Subject:</strong></td>
                                <td> 
                                    <div class="col-sm-12">
                                        <input class="form-control" type="text" value="" name="subject" 
                                           id="subject" placeholder="Subject" required autofocus maxlength="150">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Message:</strong></td>
                                <td> 
                                    <div class="col-sm-12 ">
                                        <textarea class="form-control" name="textarea_message" id="textarea_message" style="width: 750px; height: 240px;"></textarea>	
                                    </div>
                                </td>
                            </tr>
                        </thead>
                    </table>
                    
                    <!--
                    <div class="form-group">
                        <label class="col-sm-2" for="inputTo"><span class="glyphicon glyphicon-user"></span>&nbsp; To</label>
                        <div class="col-sm-10"><?php echo (isset($recipient) ? $recipient : ''); ?>
                        <input type="hidden" value="" name="to_recipient" id="to_recipient" /></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2" for="inputSubject"><span class="glyphicon glyphicon-list-alt"></span>&nbsp; Subject</label>
                        <div class="col-sm-10"><input class="form-control" type="text" value="" name="subject" id="subject" placeholder="Subject" required autofocus maxlength="150"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12" for="inputBody"><span class="glyphicon glyphicon-list"></span>&nbsp; Message</label>
                        <div class="col-sm-12"><div class="textarea-custom" id="textarea_message"></div>	</div>
                    </div>
                    -->
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary ">Send</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button> 
                </div>    
            </div>
        </div>
    </div>
</form>
<!-- Compose message modal end -->

    <!-- For other status alert -->
    <div id="alert-status" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span> <span class="sr-only">close</span></button>
                        <h4 id="alert-modal-title" class="modal-title">Compose Message</h4>
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
    
        <!-- For other status alert -->
    <div id="err-status" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span> <span class="sr-only">close</span></button>
                        <h4 id="error-modal-title" class="modal-title">Error</h4>
                    </div>
                    <div class="modal-body">
                        <div id="err-info-alert-msg"></div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" onclick="javascript:display_form()">OK</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

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
