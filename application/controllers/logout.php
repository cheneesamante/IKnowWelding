<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Logout extends CI_Controller {

    public function __construct() {
        //$this->load->helper('url');
        //$this->output->set_template('default');
        parent::__construct();
        // Your own constructor code
    }

    public function index() {
        $user_data = $this->session->all_userdata();
        foreach ($user_data as $key => $value) {
            if ($key != 'session_id' && $key != 'ip_address' && $key != 'user_agent' && $key != 'last_activity') {
                $this->session->unset_userdata($key);
            }
        }
        $this->session->sess_destroy();
        redirect('home');
    }

}
