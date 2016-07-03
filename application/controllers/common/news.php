<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class News extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('common');
        $this->load->model('common_model');
    }

    public function index() {
             $data['menu'] =  $this->common->_menu();
             $this->load->view('header',$data);
        $events = $this->common_model->view_events();
       
        $data['load_events'] = json_encode($events);

        $this->load->view('events_view', $data);
        $this->load->view('footer');
    }
	
	
	

}
