<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {
		parent::__construct();
                $this->load->library('common');
                $this->load->model('common_model');
		// Your own constructor code
	}
	
    public function index() {
                $view = 'home_view';
				
                $data['menu'] = $this->common_model->get_menu('GUEST');

        if ($this->session->userdata('user_id')) {
            $sess_user_type_id = $this->session->userdata('user_id');
					$check_view = $this->common->_get_view($sess_user_type_id);
					$view = $check_view;
					if($user == 'USER'){
						$this->load->view('user/header_main',$data);
						$this->load->view('user/home_view',$data);
						$this->load->view('user/footer',$data);
						$data['menu'] = $this->common_model->get_menu('USER');
					} else if($user == 'ADMIN') {
						$this->load->view('admin/header_main',$data);
						$this->load->view('admin/home_view',$data);
						$this->load->view('admin/footer',$data);
						$data['menu'] = $this->common_model->get_menu('ADMIN');
					}
                    $this->load->view('header_main',$data);
                    $this->load->view($view,$data);
                } else {
				$this->load->view('header',$data);
				$this->load->view('home_view');
			}       
		$this->load->view('footer');
    } 

    public function signup() {
				
        $data['menu'] = $this->common_model->get_menu('GUEST');
		$this->load->view('header',$data);

		$this->load->view('signup_view');
		$this->load->view('footer');
    } 
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
