<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Chat extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Your own constructor code
        $this->load->helper('url');
    }

    public function index() {
        $user_id = $this->session->userdata('info')['user_id'];
    
    }

  
    public function send() {

 
    }

    public function get_messages($param_user_id) {
       
    }

    //delete message start
    public function delete() {

        $postdata = sanitize_mix_post($_POST);
        $data['result'] = $this->message->_delete_message($postdata['thread_id']); // delete

        if ($data['result'] == true) {
            echo true;
        } else {
            echo false;
        }
    }

    //delete message end
    public function retrieve_messages() {
        $postdata = sanitize_mix_post($_POST);
        $user_id = $this->session->userdata('info')['user_id'];
        $type = $postdata['type'];
        $next = isset($postdata['next']) ? $postdata['next'] : 0;
        $content;
        if ($user_id) {
            if ($type == 0) {
                $data = $this->mahana_messaging->get_all_threads_grouped($user_id, true, 'DESC');
                $msg = array_slice($data, $postdata['start'], MSG_DISP_LIMIT);
                $id = "inbox";
            } else if ($type == 1) {
                $data = $this->mahana_messaging->get_all_send($user_id, true, 'DESC');
                if ($next) {
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

        if (($num_msg > 0 && array_key_exists("retval", $msg)) && $type == 0) {

            foreach ($msg['retval'] as $key => $val):
                $content .= '<div class="panel" style="border-color: transparent">
                    <div class="panel-heading clickable">
                            <span class="glyphicon glyphicon-user"></span>
                            <span class="name ellipsis" original-title="' . $val['messages'][0]['sender_name'] . '">
                                    &nbsp; ' . $val['messages'][0]['sender_name'] . '
                            </span> 
                            <span class="ellipsis" original-title="' . $val['messages'][0]['subject'] . '">
                                ' . $val['messages'][0]['subject'] . '</span>
                            <span class="text-muted ellipsis" style="font-size: 11px;">
                                    - ' . substr(strip_tags($val['messages'][0]['body']), 0, 25) . '
                            </span>
                            <span class="pull-right badge">' . $val['messages'][0]['cdate'] . '</span> 
                    </div>
                    <div class="panel-body well" style="margin-top: 25px; border:0px;">
                        <p>Subject: ' . $val['messages'][0]['subject'] . '</p>
                        <p>Message: ' . $val['messages'][0]['body'] . '</p>

                        <a style="" href="#largeModal" class="btn btn-sm btn-primary" data-toggle="modal" role="button">
                            <i class="glyphicon glyphicon-share-alt"></i> REPLY
                        </a>

                        <a href="#largeModal-delete" class="btn btn-sm btn-primary" onclick="javascript:get_data(' . $val['messages'][0]['id'] . ')"  
                           data-toggle="modal" role="button">  <i class="glyphicon glyphicon-trash"></i> DELETE </a>
                    </div>
                </div>';
            endforeach;
        } else if (($num_msg > 0 && $msg != "Error") && $type == 1) {
            foreach ($msg as $key => $val):
                $content .= '<div class="panel" style="border-color: transparent">
                    <div class="panel-heading clickable">
                            <span class="glyphicon glyphicon-user"></span>
                            <span class="name ellipsis" original-title="' . $val['to_name'] . '">
                                    &nbsp; ' . $val['to_name'] . '
                            </span> 
                            <span class="ellipsis" original-title="' . $val['subject'] . '">
                                ' . $val['subject'] . '</span>
                            <span class="text-muted ellipsis" style="font-size: 11px;">
                                    - ' . substr(strip_tags($val['body']), 0, 25) . '
                            </span>
                            <span class="pull-right badge">' . $val['cdate'] . '</span> 
                    </div>
                    <div class="panel-body well" style="margin-top: 25px; border:0px;">
                        <p>Subject: ' . $val['subject'] . '</p>
                        <p>Message: ' . $val['body'] . '</p>

                        <a style="" href="#largeModal" class="btn btn-sm btn-primary" data-toggle="modal" role="button">
                            <i class="glyphicon glyphicon-share-alt"></i> REPLY
                        </a>

                        <a href="#largeModal-delete" class="btn btn-sm btn-primary" onclick="javascript:get_data(' . $val['id'] . ')"  
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
