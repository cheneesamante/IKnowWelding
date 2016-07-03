<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Reservation extends CI_Controller {

    public function __construct() {
         //$this->load->helper('url');
        //$this->output->set_template('default');
	parent::__construct();
		// Your own constructor code
        $this->load->library('common');
        $this->load->helper('url');
        $this->load->model('Reservation_model', 'reserve');
     }

    public function index() {
         if($this->session->userdata('info')['user_id']&& $this->session->userdata('info')['user_type_id']){
                  $sess_user_type_id = $this->session->userdata('info')['user_type_id'];
                  $check_view = $this->common->_get_view($sess_user_type_id);
                  $view = $check_view;
                  $data['menu'] =  $this->common->_menu($sess_user_type_id);
                  $this->load->view('header_main',$data);    
                  $this->load->view('reservation_view',$data);  
         } else {
             $data['menu'] =  $this->common->_menu();
             $this->load->view('header', $data);
             $this->load->view('error_page_view');             
         }
     
         $this->load->view('footer');
     }

     public function get_calendar(){
         try{
         //    var_dump($_REQUEST);
if (!empty($_REQUEST['year']) && !empty($_REQUEST['month'])) {
    $year = intval($_REQUEST['year']);
    $month = intval($_REQUEST['month']);
    $lastday = intval(strftime('%d', mktime(0, 0, 0, ($month == 12 ? 1 : $month + 1), 0, ($month == 12 ? $year + 1 : $year))));

    $dates = array();
    // for ($i = 0; $i <= (rand(4, 10)); $i++) {     // for ($i = 0; $i <= (rand(4, 10)); $i++) { 
	//get dates
                $get_dates = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            
               
    for ($i = 1; $i <= $get_dates; $i++) {
        // $date = $year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT) . '-' . str_pad(rand(1, $lastday), 2, '0', STR_PAD_LEFT);
        $day = $i < 10 ? "0".$i : $i;
        $months = $month < 10 ? "0".$month : $month;
        $date = $year . '-' . $months . '-' . $day;

        //db connection
        //ask the availability of date
        $check_date = $this->reserve->check_reserve_date($date);

//        if (!empty($_REQUEST['grade'])) {
//            $dates[$day]['badge'] = false;
//            $dates[$day]['classname'] = 'grade-' . rand(1, 4);
//        }
        $status = '';
        $status_id = 0;

        if (count($check_date) > 0) {
//            $ctr = 0;
            foreach($check_date as $key => $value) {
//             $day = $value['reserve_id'].'_'.$ctr;
            $reserve_name = $value['reservation_name'];
            $reserve_by = $value['reserve_by'];
            $status_id = $value['status'];
            if($status_id == 1){

            $dates[$day]['badge'] = 'orange';
            $dates[$day]['date'] = $date;
            }  elseif($status_id == 2){

            $dates[$day]['badge'] = 'red';
            $dates[$day]['date'] = $date;
          }         
            }
         } 
    }

    echo json_encode($dates);
//    echo print_r($dates);
} else {
    echo json_encode(array());
}
         } catch (Exception $ex) {

         }
     }

    public function save_calendar() {
        try {
            if ($_REQUEST) {
                $reserve_date = $_REQUEST['reserve_date'];
                $user_id = $_REQUEST['user_id'];
                $reserve_name = $_REQUEST['reserve_name'];
                $reservation_desc = $_REQUEST['reserve_desc'];
                $reg_date = date('Y-m-d H:i:s');
                $status_id = 1; // 0 vacant 1 pending 2 already reserve 
                $update_date = date('Y-m-d H:i:s');
                $approved_by = 0;
                $data = array(
                    'reserve_date' => $reserve_date,
                    'user_id' => $user_id,
                    'reserve_name' => $reserve_name,
                    'reservation_desc' => $reservation_desc,
                    'reg_date' => $reg_date,
                    'status_id' => $status_id,
                    'update_date' => $update_date,
                    'approved_by' => $approved_by
                );
                echo $this->reserve->save_reservation($data);
            }
        } catch (Exception $ex) {
            
        }
    }

    public function approve_calendar() {
        try {
            if ($this->session->userdata('info')['user_id'] && ($this->session->userdata('info')['user_type_id'] == ADMIN || $this->session->userdata('info')['user_type_id'] == IRD_EMP )) {
            if ($_REQUEST) {
                $reserve_id = $_REQUEST['reserve_id'];
                $reserve_date = $_REQUEST['reserve_date'];
                $approved_by = $_REQUEST['approved_by'];
                $status_id = 2; // 0 vacant 1 pending 2 already reserve 
                $update_date = date('Y-m-d H:i:s');
                
                $data = array(
                    'reserve_id' => $reserve_id,
                    'reserve_date' => $reserve_date,
                    'status_id' => $status_id,
                    'update_date' => $update_date,
                    'approved_by' => $approved_by
                );
                echo $this->reserve->approve_reject_reservation($data);
            }
            } else {
                echo 2;
            }
        } catch (Exception $ex) {
            
        }
    }

    public function reject_calendar() {
        try {
            if ($this->session->userdata('info')['user_id'] && ($this->session->userdata('info')['user_type_id'] == ADMIN || $this->session->userdata('info')['user_type_id'] == IRD_EMP )) {
            if ($_REQUEST) {
                $reserve_id = $_REQUEST['reserve_id'];
                $reserve_date = $_REQUEST['reserve_date'];
                $approved_by = $_REQUEST['approved_by'];
                $status_id = 3; // 0 vacant 1 pending 2 already reserve 3 reject
                $update_date = date('Y-m-d H:i:s');
                
                $data = array(
                    'reserve_id' => $reserve_id,
                    'reserve_date' => $reserve_date,
                    'status_id' => $status_id,
                    'update_date' => $update_date,
                    'approved_by' => $approved_by
                );
                echo $this->reserve->approve_reject_reservation($data);
            }
            } else {
                echo 2;
            }
        } catch (Exception $ex) {
            
        }
    }

     public function create_days() {
        try {
            if ($this->session->userdata('info')['user_id'] && $this->session->userdata('info')['user_type_id']) {
            $postdata = sanitize_mix_post($_POST);
            $day = $postdata['date'];
            $check_date = $this->reserve->check_reserve_date($day);

            if(count($check_date) > 0){
                //foreach($check_date as $key => $val){
             //   $check_date['user_type_id'] = $this->session->userdata('info')['user_type_id'];
                    echo json_encode($check_date);
                //}
            } else {
                echo 0;
            }
            } else {
            $data['menu'] = $this->common->_menu();
            $this->load->view('header', $data);
            $this->load->view('error_page_view');
            }
        } catch (Exception $ex) {
            
        }
    }   

}

?>
