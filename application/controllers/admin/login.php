<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        
//$this->output->set_template('default');
	parent::__construct();
        $this->load->helper('url');
        $this->load->library('common');
        $this->load->model('admin_model', 'Admin');
        $this->load->model('common_model');
		// Your own constructor code
     }

    public function index() {
         //$this->authentication();
		 $this->load->view('admin/header');
		 $this->load->view('admin/login_view');
     }
     
     public function display() {
         $this->load->view('login_box');
     }
     
     public function check() {
        $username = $this->input->post('username'); // username or email address
        $password = $this->input->post('password');
        $view = 'home_view';
		    $error = false;
        if ($username) {
                    if ($password) {
                        $this->load->model('admin_model', 'Admin');
                        $data = $this->Admin->check_user(array('username_email' => $username, 'password' => $password));
                        if (count($data) > 0) {
                            $check_view = $this->common->_get_view();
                            if ($data['active'] == 0) {
                                $error = 2;
                            } else {
                            /* check user_type */
                            $check_view = $this->common->_get_view($data['user_type_id']);
                                if ($view == $check_view) {
                                    $error = 4;
                                }
                            }
                            $view = $check_view;
                        } else {
                            $error = 1;
                        }
                    }
        } else {
            $error = 3;
        }
        switch ($error) {
                    case 1:
                        $error = 'Invalid Email Address and Password';
                        break;
                    /* account deactivated */
                    case 2:
                        $error = 'You are not allowed to login as your account is de-activated.';
                        break;
                    case 3:
                       $error = 'You are not registered user!';
                        break;
                    case 4:
                        $error = 'Please contact the system administrator.';
                        break;
                }
        
        if (false != $error){
            echo json_encode(array('err'=>true, 'msg'=>$error));
        } else {
            echo json_encode(array('err'=>false));
        }
        
     }

     private function authentication() {
        try {

            $username = $this->input->post('username'); // username or email address
            $password = $this->input->post('password');
            $view = 'home_view';
            $header = 'header';
            $error = false;
            $menu = array();
            if ($this->session->userdata('info')['user_id'] == true) {
                /* check user_type */
                  $header = 'header_main';   
                  $sess_user_type_id = $this->session->userdata('info')['user_type_id'];
                  $check_view = $this->common->_get_view($sess_user_type_id);
                  $data['menu'] = $this->common->_menu($sess_user_type_id);
                $view = $check_view;
             
            } else {
                if ($username) {
                    if ($password) {
                        $this->load->model('admin_model', 'Admin');
                        $data = $this->Admin->check_user(array('username_email' => $username, 'password' => $password));
                        if (count($data) > 0) {
                            $menu =$this->common->_menu($data['user_type_id']);
                            $this->session->set_userdata(array('menu'=>$menu));
                            $this->session->set_userdata(array('info'=>$data));
                            $header = 'header_main';
                            $check_view = $this->common->_get_view();
                            if ($data['active'] == 0) {
                                $header = 'header';
                                $error = 2;
                            } else {
                            /* check user_type */
                            $check_view = $this->common->_get_view($data['user_type_id']);
                                if ($view == $check_view) {
                                 $header = 'header';
                                    $error = 4;
                                } else {
                                    $menu = $this->common->_menu($data['user_type_id']);
                                    $this->session->set_userdata(array('menu' => $menu));
                                    $this->session->set_userdata(array('info' => $data));
                                }
                            }
                            $view = $check_view;
                        } else {
                            $header = 'header';
                            $error = 1;
                        }
                    }
                } else if($this->session->userdata('info')['user_id'] && $this->session->userdata('info')['user_type_id']){
                 $header = 'header_main';
                  $sess_user_type_id = $this->session->userdata('info')['user_type_id'];
                  $check_view = $this->common->_get_view($sess_user_type_id);
                  $view = $check_view;
                  $data['menu'] =$this->common->_menu($sess_user_type_id);
                } else {
                    //not registered user get lost
                    $view = $this->common->_get_view();
                    $error = 3;
                }
                switch ($error) {
                    case 1:
                        $error = 'Invalid Email Address and Password';
                        $menu =$this->common->_menu();
                        break;
                    /* account deactivated */
                    case 2:
                        $error = 'You are not allowed to login as your account is de-activated.';
                       $menu =$this->common->_menu();
                        break;
                    case 3:
                       $error = 'You are not registered user!';
                       $menu =$this->common->_menu();
                        break;
                    case 4:
                        $error = 'Please contact the system administrator.';
                        $menu = $this->common->_menu();
                        break;
                }
                $data['message'] = $error;
                $data['menu'] = $menu;
                
            }
                /* render here */
              if($view == "admin/home_view"){
              $sess_user_type_id = $this->session->userdata('info')['user_id'];     
             $this->load->model('mahana_model', 'message');
             $this->load->model('Reservation_model', 'reserve');
             $data['recent_sent_msg'] = $this->message->_recent_sent_message($sess_user_type_id);
             $data['recent_msg'] = $this->message->_recent_message($sess_user_type_id);
             $data['admin_cnt'] = $this->common_model->_count_user(ADMIN);
             $data['ird_cnt'] = $this->common_model->_count_user(IRD_EMP);
             $data['sister_cnt'] = $this->common_model->_count_user(SISTER_LGU);
             $data['today_reserve'] = $this->reserve->_today_reserve();
             $data['my_reserve'] = $this->reserve->_my_reservation($sess_user_type_id);
            } elseif($view == "ird/home_view"){
             $sess_user_type_id = $this->session->userdata('info')['user_id'];     
             $this->load->model('mahana_model', 'message');
             $this->load->model('Reservation_model', 'reserve');
             $data['recent_sent_msg'] = $this->message->_recent_sent_message($sess_user_type_id);
             $data['recent_msg'] = $this->message->_recent_message($sess_user_type_id);
             $data['admin_cnt'] = $this->common_model->_count_user(ADMIN);
             $data['ird_cnt'] = $this->common_model->_count_user(IRD_EMP);
             $data['sister_cnt'] = $this->common_model->_count_user(SISTER_LGU);
             $data['today_reserve'] = $this->reserve->_today_reserve();
             $data['my_reserve'] = $this->reserve->_my_reservation($sess_user_type_id);
            }
                $this->load->view($header, $data);
                $this->load->view($view, $data);
                $this->load->view('footer');
        } catch (Exception $ex) {
            log_message("error", "Catch Exception:" . $ex->getMessage());
        }

    }


}
