<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pages extends CI_Controller {

     public function __construct()
     {
         //$this->load->helper('url');
        //$this->output->set_template('default');
	parent::__construct();
		// Your own constructor code
        $this->load->library('common');
        $this->load->helper('url');
         $this->load->model('admin_model', 'admin');
     }
     public function index($id = false)
     {
       
         $cms_data = $this->admin->view_cms($id);
         $data['title'] = null;
         $data['body'] = null;
         if(count($cms_data) > 0 ){
            $data['title'] = $cms_data['title'];
            $data['body'] = $cms_data['body'];
         }

         if($data['title'] == null){
             $data['title'] = 'No Title save and active in this page';
         }
         if($data['body'] == null){
              $data['body'] = 'No Body save and active in this page';            
         }
         if($this->session->userdata('info')['user_id']&& $this->session->userdata('info')['user_type_id']){
                  $sess_user_type_id = $this->session->userdata('info')['user_type_id'];
                  $check_view = $this->common->_get_view($sess_user_type_id);
                  $view = $check_view;
                  $data['menu'] =  $this->common->_menu($sess_user_type_id);
                       $this->load->view('header_main',$data);
         } else {
             $data['menu'] =  $this->common->_menu();
             $this->load->view('header',$data);
         }
         
         $this->load->view('pages_view',$data);   
         $this->load->view('footer');
     }
	
     public function sister_cities($id)
     {
       
         $cms_data = $this->admin->view_sister_city($id);

         $data['body'] = null;
		 $data['menu'] =  $this->common->_menu();
		 $this->load->view('header',$data); 
         if(count($cms_data) > 0 && $cms_data['active'] == 1){
            
			$data['city'] = $cms_data;
			$this->load->view('sisterhood_view',$data);  
			$this->load->view('footer');
         } else {
			$this->index(0);           
		 }
		 
		 
     }
	 
     
     public function news($id)
     {
       if($id != null){
        $cms_data = $this->admin->view_news($id);
       }
        if($cms_data == false){
         $cms_data = array('news_title' => 'No News Title','news_date' => date('Y-j-d'), 'news_img'=>null,
                          'news_body' => 'No News');
        }
        $data['news'] = $cms_data;
        $this->load->view('news',$data);  
     }
	 
	 
}

?>
