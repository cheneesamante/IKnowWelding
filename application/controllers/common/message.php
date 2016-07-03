<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Message extends CI_Controller {

     public function __construct()
     {
         //$this->load->helper('url');
        //$this->output->set_template('default');
	parent::__construct();
		// Your own constructor code
                $this->load->helper('url');
                $this->load->model('mahana_model', 'message');
                $this->load->library('mahana_messaging');
     }
     public function index()
     {
         $user_id = $this->session->userdata('info')['user_id'];
         if($user_id) {
//	 $data['msg'] = $this->mahana_messaging->get_message(1, 1);
        $msg = array_slice($this->mahana_messaging->get_all_threads_grouped($user_id, true, 'DESC'), 0, MSG_DISP_LIMIT);
        $send = array_slice($this->mahana_messaging->get_all_send($user_id, true, 'DESC'), 0, MSG_DISP_LIMIT);
             
	 $data['msgs'] = $msg;
	 $data['send'] = $send;
         $inbox = $this->mahana_messaging->get_all_threads_grouped($user_id, true, 'DESC');
         if(array_key_exists("retval", $inbox)){
             $data['total_msgs'] = count($inbox['retval']);
         } else {
             $data['total_msgs'] = 0;
         }
	 $data['total_send'] = count($this->mahana_messaging->get_all_send($user_id, true, 'DESC'));

        // print_r($data['send']);
         $sender = $this->message->get_recipient_id();
         $data_select1 = "<select name = 'recipient_id' id = 'recipient_id'>";
         foreach ($sender as $key => $val){
            $data_select1 .= "<option id = ".$val['user_id']."> ".$val['first_name']." ".$val['last_name']."</option> " ; 
              
         }
          $data_select1 .= "</select>";
          $data['recipient'] = $data_select1;
         
        
         $this->load->view('header_main');
         $this->load->view('message_view',$data);
         } else {
             $this->load->library('common');  
             $data['menu'] =  $this->common->_menu();
             $this->load->view('header', $data);
             $this->load->view('error_page_view'); 
         }
         $this->load->view('footer');
     }
     public function auto_complete_recipient(){
             $getdata = sanitize_mix_post($_GET);
             $get_input = $getdata['q'];
             $data = $this->message->get_recipient_find($get_input);
             
             //get the name 
             foreach($data as $key => $val){
                 echo $val['name']."\n";
             }
            // var_dump($data);  //$val[0]['name'];
             
         
     }
     public function send(){

            $page_name = 'page_name'; // username or email address
//            $to = $this->input->post('to'); // to
//            $subj = $this->input->post('subject'); // username or email address
//            $prio = $this->input->post('priority'); // username or email address
//            $message = $this->input->post('message');
            $postdata = sanitize_mix_post($_POST);
            $to = $postdata['to']; // to
            $subj =  $postdata['subject']; // username or email address
            $prio = $postdata['priority']; // username or email address
            $message = $postdata['message'];
            $check_to = $this->message->get_recipient_findv2($to);
            if(!$check_to){
                //check if the user exist
                echo 2;
            }
            elseif(!$subj){
                echo 3;
            } elseif(!$message){
                echo 4;
            } else {
            $user_id = $this->session->userdata('info')['user_id'];
            $data['result'] = $this->mahana_messaging->send_new_message($user_id, $to, $subj, $message, $prio);
 
            if($data['result']['msg'] == 'Success'){
                echo true;
            } else {
                echo false;
            }
     }
     }
     public function get_inbox($param_user_id){
            $data = array();
            if($param_user_id) {
            $data['messages'] = $this->mahana_messaging->get_all_threads($param_user_id);
            }  
            return $data;
     }
     //delete message start
     public function delete(){

            $postdata = sanitize_mix_post($_POST);
            $data['result'] = $this->message->_delete_message($postdata['thread_id']); // delete
 
            if($data['result'] == true){
                echo true;
            } else {
                echo false;
            }
     }
     //delete message end
     public function retrieve_messages(){
         $postdata = sanitize_mix_post($_POST);
         $user_id = $this->session->userdata('info')['user_id'];
         $type = $postdata['type'];
         $next = isset($postdata['next']) ? $postdata['next'] : 0;
         $content;
         if($user_id) {
             if($type == 0){
                $data = $this->mahana_messaging->get_all_threads_grouped($user_id, true, 'DESC');
                $msg = array_slice($data, $postdata['start'], MSG_DISP_LIMIT);
                $id = "inbox";
             } else if($type == 1) {
                $data = $this->mahana_messaging->get_all_send($user_id, true, 'DESC');
                if($next){
                   $start_num = $postdata['next'] - MSG_DISP_LIMIT; 
                } else {
                   $start_num = $postdata['start']; 
                }
                $msg = array_slice($data, $start_num, MSG_DISP_LIMIT);
//                var_dump($msg);
                $id = "sent";

             }
         }
         $num_msg = count($msg);
         $content = NULL;
         $total = count($data);
         
         if(($num_msg > 0 && array_key_exists("retval", $msg)) && $type == 0){

            foreach($msg['retval'] as $key => $val): 
                $content .= '<div class="panel" style="border-color: transparent">
                    <div class="panel-heading clickable">
                            <span class="glyphicon glyphicon-user"></span>
                            <span class="name ellipsis" original-title="'.$val['messages'][0]['sender_name'].'">
                                    &nbsp; '.$val['messages'][0]['sender_name'].'
                            </span> 
                            <span class="ellipsis" original-title="'.$val['messages'][0]['subject'].'">
                                '.$val['messages'][0]['subject'].'</span>
                            <span class="text-muted ellipsis" style="font-size: 11px;">
                                    - '.substr(strip_tags($val['messages'][0]['body']), 0, 25).'
                            </span>
                            <span class="pull-right badge">'.$val['messages'][0]['cdate'].'</span> 
                    </div>
                    <div class="panel-body well" style="margin-top: 25px; border:0px;">
                        <p>Subject: '.$val['messages'][0]['subject'].'</p>
                        <p>Message: '.$val['messages'][0]['body'].'</p>

                        <a style="" href="#largeModal" class="btn btn-sm btn-primary" data-toggle="modal" role="button">
                            <i class="glyphicon glyphicon-share-alt"></i> REPLY
                        </a>

                        <a href="#largeModal-delete" class="btn btn-sm btn-primary" onclick="javascript:get_data('.$val['messages'][0]['id'].')"  
                           data-toggle="modal" role="button">  <i class="glyphicon glyphicon-trash"></i> DELETE </a>
                    </div>
                </div>';
            endforeach;
         } else if(($num_msg > 0 && $msg != "Error") && $type == 1){
            foreach($msg as $key => $val): 
                $content .= '<div class="panel" style="border-color: transparent">
                    <div class="panel-heading clickable">
                            <span class="glyphicon glyphicon-user"></span>
                            <span class="name ellipsis" original-title="'.$val['to_name'].'">
                                    &nbsp; '.$val['to_name'].'
                            </span> 
                            <span class="ellipsis" original-title="'.$val['subject'].'">
                                '.$val['subject'].'</span>
                            <span class="text-muted ellipsis" style="font-size: 11px;">
                                    - '.substr(strip_tags($val['body']), 0, 25).'
                            </span>
                            <span class="pull-right badge">'.$val['cdate'].'</span> 
                    </div>
                    <div class="panel-body well" style="margin-top: 25px; border:0px;">
                        <p>Subject: '.$val['subject'].'</p>
                        <p>Message: '.$val['body'].'</p>

                        <a style="" href="#largeModal" class="btn btn-sm btn-primary" data-toggle="modal" role="button">
                            <i class="glyphicon glyphicon-share-alt"></i> REPLY
                        </a>

                        <a href="#largeModal-delete" class="btn btn-sm btn-primary" onclick="javascript:get_data('.$val['id'].')"  
                           data-toggle="modal" role="button">  <i class="glyphicon glyphicon-trash"></i> DELETE </a>
                    </div>
                </div>';
            endforeach;
         } else {
             $content = '<div class="well text-center"><p><i>No Message</i></p></div>';
         }
         
         $content .= '</div>
                </div>';
         
        echo json_encode(array(
            'content' => $content,
            'total' => $total,
            'number_of_msg' => $num_msg
        ));
         
     }
}

?>
