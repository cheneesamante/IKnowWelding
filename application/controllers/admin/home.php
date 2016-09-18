<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('common');
        $this->load->model('common_model');
        $this->load->model('users_model', 'Users');
        $this->load->helper('url');
        // Your own constructor code
        $this->load->library('session');
        $user = $this->session->userdata('username');
        if(!$user){
        	redirect('admin/login');
        }
    }

    public function index() {
    	$this->dashboard();
    }
    
    public function dashboard() {
    	$count = $this->Users->count_users();
    	$data['total_users']  = $count->total;
    	$where = ' WHERE active = 1 ';
    	$limit = ' LIMIT 0, 10 ';
    	$order = ' ORDER BY reg_date DESC ';
    	$users = $this->Users->view_users($where, $order, $limit);

    	foreach($users as $user){
    		$data['users'][] = array(
    			'name' =>  $user['first_name'] . ' ' . $user['last_name'],
    			'image'	=> $user['img_url'],
    			'reg' => date_format(new DateTime($user['reg_date']), 'F d')
    		);
    	}

    	$data['total_new'] = empty($users) ? 0 : count($users);
        $this->load_view('home_view', $data);
    }

    public function users() {
        $this->load_view('users_view');
    }

    public function cms() {
        $this->load_view('cms_view');
    }

    private function load_view($view, $data = NULL) {
        $data['menu'] = $this->common_model->get_menu('ADMIN');
        $data['img'] = $this->session->userdata('img');
        $data['name'] = $this->session->userdata('account_name');
        $this->load->view('admin/header_main', $data);
        $this->load->view('admin/side_menu_view', $data);
        $this->load->view('admin/' . $view);
        $this->load->view('admin/footer');
    }

    public function logout(){
    	$this->session->sess_destroy();
    	redirect('admin/login');
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
