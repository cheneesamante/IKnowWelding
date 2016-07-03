<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct()
    {
        //$this->load->helper('url');
        //$this->output->set_template('default');
		parent::__construct();
                $this->load->library('common');
                $this->load->model('common_model');
                $this->load->model('Reservation_model', 'reserve');
		// Your own constructor code
	}
	
	public function index()
	{
                  $view = 'home_view';
				
                $data['menu'] = $this->common->_menu();
		$events = $this->common_model->view_events();		
		$data['cities'] = $this->common_model->get_sister_cities_information();	
        $data['load_events'] = json_encode($events); 
                $data['news'] = $this->common_model->get_news_information();	
                $data['sisterhood'] = $this->common_model->get_sisterhood_network_information();	
             //   var_dump($this->session->userdata);
                if($this->session->userdata('info')['user_id']&& $this->session->userdata('info')['user_type_id']){
                  $sess_user_type_id = $this->session->userdata('info')['user_type_id'];
                  $check_view = $this->common->_get_view($sess_user_type_id);
                  $view = $check_view;
                  $data['menu'] = $this->common->_menu($sess_user_type_id);
                            //check user_type 
            if($view == "admin/home_view"){
              $sess_user_type_id = $this->session->userdata('info')['user_id'];
             $this->load->model('mahana_model', 'message');
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
             $data['recent_sent_msg'] = $this->message->_recent_sent_message($sess_user_type_id);
             $data['recent_msg'] = $this->message->_recent_message($sess_user_type_id);
             $data['admin_cnt'] = $this->common_model->_count_user(ADMIN);
             $data['ird_cnt'] = $this->common_model->_count_user(IRD_EMP);
             $data['sister_cnt'] = $this->common_model->_count_user(SISTER_LGU);
             $data['today_reserve'] = $this->reserve->_today_reserve();
             $data['my_reserve'] = $this->reserve->_my_reservation($sess_user_type_id);
            }
                  $this->load->view('header_main',$data);
                  $this->load->view($view,$data);
                } else {
		$this->load->view('header',$data);
		$this->load->view('home_view');
	}       
		$this->load->view('footer');
    }        
//    private function menu($param_user_type_id = null){
//        try {
//            $result = false;
//            $arr_common =  array(array('Makati Sister City Program','common/pages/index/0001'),
//                                 array('Other Local Government','common/pages/index/0002'),
//                                 array('City of Makati','common/pages/index/0003'),
//                                 array('Makati Sister Cities','common/pages/index/0004')); 
//
//            $arr_ird =  array(array('List of Makati Sisterhood','common/pages/index/0005'),
//                              array('Private Archives','p/index.php'),
//                              array('Messaging','common/message'),
//                              array('Manage Archives','man/index.php'));            
//            $arr_admin =  array(array('List of Makati Sisterhood','common/pages/index/0005'),
//                                array('Private Archives','pri/index.php'),
//                                array('Messaging','common/message'),
//                                array('Manage Archives','man/index.php'),
//                                array('Registration of User','admin/reg'),
//                                array('Report Generation','rep/index.php'),
//                                array('Content Management System','admin/cms'));            
//            if ($param_user_type_id != null) {
//                if ($param_user_type_id == 1) {
//                    $result = array('who' => 'Admin',
//                        'up' => $arr_common,
//                        'down' => $arr_admin);
//                } elseif ($param_user_type_id == 2) {
//                    $result = array('who' => 'IRD',
//                        'up' => $arr_common,
//                        'down' => $arr_ird);
//                }
//            } else {
//                $result = array('up' => $arr_common);
//            }
//            return $result;
//        } catch (Exception $ex) {
//            log_message("error", "Catch Exception:" . $ex->getMessage());
//        } 
//    }
//   private function get_view($param_user_type_id = null) {
//        try {
//            $result = false;
//            if ($param_user_type_id != null) {
//                if ($param_user_type_id == 1) {
//                    $result = "admin/home_view.php";
//                } elseif ($param_user_type_id == 2) {
//                    $result = "ird/home_view";
//                }
//            }
//            return $result;
//        } catch (Exception $ex) {
//            log_message("error", "Catch Exception:" . $ex->getMessage());
//        } 
//    }        
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
