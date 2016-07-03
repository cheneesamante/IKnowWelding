<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class News_events extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('common');
        $this->load->model('common_model');
    }

    public function index() {
        if ($this->session->userdata('info')['user_id'] == true) {
        $this->load->view('header_main');
        //check who is the 
        $events = $this->common_model->view_events();

        foreach($events as $key => $val){
          $button_events = '';
          $events_name = '<input type="text" value="'.$val['title'].'" id="event_name"  name="event_name"  placeholder="Event Name" required autofocus maxlength="200" readonly="readonly">';
            if($val['user_id'] == $this->session->userdata('info')['user_id']){
                $events_name = '<input type="text" value="'.$val['title'].'" id="event_name"  name="event_name"  placeholder="Event Name" required autofocus maxlength="200">';
                $button_events = '
                    <button class="btn btn-primary" onclick="javascript:update_event();">Update Event</button>
                    <button  class="btn btn-primary btn-delete" id="btn-delete" name="btn-delete" onclick="javascript:delete_event();">Delete Event</button>
                ';
            } elseif ($this->session->userdata('info')['user_type_id'] == ADMIN || $this->session->userdata('info')['user_type_id'] == IRD_EMP) {
                $events_name = '<input type="text" value="'.$val['title'].'" id="event_name"  name="event_name"  placeholder="Event Name" required autofocus maxlength="200">';
                $button_events = '
                    <button class="btn btn-primary" onclick="javascript:update_event();">Update Event</button>
                    <button class="btn btn-primary btn-delete" id="btn-delete" name="btn-delete" onclick="javascript:delete_event();">Delete Event</button>';
            }
            $val['button_access'] = $button_events;
            $val['events_name'] = $events_name;
            $array_string[] = $val; 
        }

        $data['load_events'] = json_encode($array_string);
        $this->load->view('news_events_view', $data);
        } else {
         $data['menu'] =  $this->common->_menu();
         $this->load->view('header', $data);
         $this->load->view('error_page_view');
        }
        $this->load->view('footer');
    }

    public function validate_event() {
        $postdata = sanitize_mix_post($_POST);
        try {
            $event_name = $postdata['event_name'];
            $event_datetime = $postdata['dtp_input1'];
            $event_desc = $postdata['event_desc'];
            $user_id = $this->common->check_session_info('user_id');
            $event_date_check = $this->check_datetime_exist($event_datetime, $user_id);
            if ($user_id) {
                if (!$event_date_check) {
                    if (!empty($postdata)) {
                        if ($event_desc != '' || $event_desc != null) {
                        $data = array(
                            'event_name' => $event_name,
                            'event_datetime' => date('Y-m-d H:i',strtotime($event_datetime)),
                            'user_id' => $user_id,
                            'event_desc' => $event_desc,
                            'reg_date' => date('Y-m-d H:i:s'),
                            'update_date' => date('Y-m-d H:i:s')
                        );
                        $is_saved = $this->common_model->save_event($data);
                        if ($is_saved) {
                            echo $is_saved;
                        } else {
                            echo 4;
                        }
                        } else {
                            echo 5;
                        }
                    }
                } else {
                    echo 2;
                }
            } else {
                echo 3;
            }
        } catch (Exception $e) {
            
        }
    }

    public function validate_event_update() {
        $postdata = sanitize_mix_post($_POST);
        try {
            $event_id = $postdata['event_id-edit'];
            $event_name = $postdata['event_name'];
            $event_desc = $postdata['event_desc_edit'];
            $event_datetime = $postdata['dtp_input-edit'];
            $user_id = $this->common->check_session_info('user_id');
            if ($user_id) {
                    if (!empty($postdata)) {
                        if ($event_desc != '' || $event_desc != null) {
                        $data = array(
                            'event_id' => $event_id,
                            'event_name' => $event_name,
                            'event_datetime' => date('Y-m-d H:i',strtotime($event_datetime)),
                            'update_id' => $user_id,
                            'event_desc' => $event_desc,                            
                            'update_date' => date('Y-m-d H:i:s')
                        );
                        $is_saved = $this->common_model->update_event($data);
                        if ($is_saved) {
                            echo $is_saved;
                        } else {
                            echo 4;
                        }
                        } else {
                            echo 5;
                    }
                }
            } else {
                echo 3;
            }
        } catch (Exception $e) {
            
        }
    }

    private function check_datetime_exist($param_event_datetime = null, $param_user_id = null){
        try {
            $result = false;
            if($param_event_datetime != null){
                $f_param_event_datetime = date('Y-m-d H:i',strtotime($param_event_datetime));
                $result =  $this->common_model->check_datetime($f_param_event_datetime, $param_user_id);
            }
            return $result;
        } catch (Exception $ex) {
            
        }
    }


    public function delete_event_update() {
        $postdata = sanitize_mix_post($_POST);
        try {
            $event_id = $postdata['event_id-edit'];
            $event_datetime = $postdata['dtp_input-edit'];
            $user_id = $this->common->check_session_info('user_id');
            //$event_date_check = $this->check_datetime_exist($event_datetime);
            if ($user_id) {
                    if (!empty($postdata)) {
                        $data = array(
                            'event_id' => $event_id,
                            'event_datetime' => date('Y-m-d H:i',strtotime($event_datetime)),
                            'update_id' => $user_id,
                            'update_date' => date('Y-m-d H:i:s')
                        );
                        $is_saved = $this->common_model->delete_event($data);
                        if ($is_saved) {
                            echo $is_saved;
                        } else {
                            echo 4;
                        }
                    }
            } else {
                echo 3;
            }
        } catch (Exception $e) {
            
        }
    }    

}
