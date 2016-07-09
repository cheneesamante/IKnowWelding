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
        $this->load_view('home_view');
    }
    
    public function users(){
        $this->load_view('users_view');
    }  


    public function load_view($view){
        $data['menu'] = $this->common_model->get_menu('ADMIN');
        $this->load->view('admin/header_main');
        $this->load->view('admin/side_menu_view', $data);
        $this->load->view('admin/'.$view);
        $this->load->view('admin/footer');
    
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
