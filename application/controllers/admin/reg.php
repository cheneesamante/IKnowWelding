<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reg extends CI_Controller {

    public function __construct() {
	parent::__construct();
        $this->load->helper('url');
        // Your own constructor code
        //Email sending
        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_port' => 465,
            'smtp_user' => 'asamante.tspi@gmail.com', // change it to yours
            'smtp_pass' => 'arS1035*', // change it to yours
            'mailtype' => 'html',
            'charset' => 'iso-8859-1',
            'wordwrap' => TRUE
        );
        $this->load->library('email', $config);
        $this->load->model('admin_model', 'Admin');
     }

    public function index() {
        if($this->session->userdata('info')['user_id'] == true)
        {
         $this->load->view('header_main');
         $data['contents'] = $this->Admin->view_users();
         $this->load->view('admin/reg_view', $data);       
        } else {
         $this->load->library('common');  
         $data['menu'] =  $this->common->_menu();
         $this->load->view('header', $data);
         $this->load->view('error_page_view');
        }
         $this->load->view('footer');
     }

    public function display_data() {
        $sEcho = $this->input->get_post('sEcho', true);
        
        $aColumns = array('username', 
                          'email_address', 
                          'first_name', 
                          'last_name', 
                          'middle_name', 
                          'birthdate', 
                          'gender', 
                          'user_type_desc',
                          'active_desc'
                        );
        /*
	 * Ordering
	 */
        if (isset($_POST['iSortCol_0'])) {
            $sOrder = " ORDER BY  ";
            for ($i = 0; $i < intval($_POST['iSortingCols']); $i++) {
                if ($_POST['bSortable_' . intval($_POST['iSortCol_' . $i])] == "true") {
                    $sOrder .= $aColumns[ intval( $_POST['iSortCol_'.$i] ) ]."
                            ".mysql_real_escape_string( $_POST['sSortDir_'.$i] ) .", ";
                }
            }

            $sOrder = substr_replace( $sOrder, "", -2 );
            if ($sOrder == " ORDER BY") {
                $sOrder = "";
            }
	}
	
	/* 
	 * Paging
	 */
	$sLimit = "";
        if (isset($_POST['iDisplayStart']) && $_POST['iDisplayLength'] != '-1') {
            $sLimit = " LIMIT ".mysql_real_escape_string( $_POST['iDisplayStart'] ).", ".
                    mysql_real_escape_string( $_POST['iDisplayLength'] );
	}
        
	/* 
	 * Filtering
	 * NOTE this does not match the built-in DataTables filtering which does it
	 * word by word on any field. It's possible to do here, but concerned about efficiency
	 * on very large tables, and MySQL's regex functionality is very limited
	 */
	$sWhere = "";
        if ($_POST['sSearch'] != "") {
            $sWhere = " WHERE (";
            for ($i = 0; $i < count($aColumns); $i++) {
                if ($aColumns[$i] == 'active_desc') {
                    $sWhere .= "IF (active = 1, 'active', 'inactive')  LIKE '".mysql_real_escape_string( $_POST['sSearch'] )."%' OR ";
                } else if ($aColumns[$i] == 'user_type_desc') {
                    $sWhere .= "IF (user_type_id = 1, 'Administrator', IF (user_type_id = 2, 'IRD', 'N/A'))  LIKE '%".mysql_real_escape_string( $_POST['sSearch'] )."%' OR ";
                } else {
                $sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string( $_POST['sSearch'] )."%' OR ";
            
                }
            }
            $sWhere = substr_replace( $sWhere, "", -3 );
            $sWhere .= ')';
	}
	
	/* Individual column filtering */
        for ($i = 0; $i < count($aColumns); $i++) {
            if ($_POST['bSearchable_' . $i] == "true" && $_POST['sSearch_' . $i] != '') {
                if ($sWhere == "") {
                    $sWhere = " WHERE ";
                } else {
                    $sWhere .= " AND ";
                }
                $sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string($_POST['sSearch_'.$i])."%' ";
            }
	}
        
        $result = $this->Admin->view_users($sWhere, $sOrder, $sLimit);
        $iTotal = $this->Admin->count_users($sWhere)->total;
        $output = array(
            'sEcho' => intval($sEcho),
            'iTotalRecords' => $iTotal,
            'iTotalDisplayRecords' => $iTotal,
            'aaData' => array()
        );
        
        foreach ($result as $row) {
            $user_type_id  = 'N/A';
            $gender = 'N/A';
            if($row['gender'] == 0){
                $gender = 'Female';
            } elseif($row['gender'] == 1) {
                $gender = 'Male';
            }
            if($row['user_type_id'] == 1){
                $user_type_id = 'Administrator';
            } elseif($row['user_type_id'] == 2) {
                $user_type_id = 'IRD';
            } 
            $user_id = $row['user_id'];
            $active = $row['active'];
            $edit = "<button type='button' onclick='javascript:update_reg(".$user_id.");' data-toggle='modal' data-target='#largeModal-update' class='btn btn-xs btn-default btn-xs update-reg' id='update-reg-".$user_id."'>Update</button>";
			$edit .= " <button type='button' data-id='".$user_id."'  data-toggle='modal' data-target='#largeModal-reset' class='open-reset-password-dialog btn btn-xs btn-default btn-xs' id='reset-pwd-".$user_id."'>Reset password</button>";
//            $edit = '<input onclick="javascript:callthis();" type="button" class="update-reg" id="update-reg" />Update';
           if($active == 0){
           $in_active = "<button type='button' data-toggle='modal' data-target='#largeModal-active-inactive' onclick='javascript:update_user_status(".$user_id.");' class='btn btn-xs btn-default update-active-inactive' id='update-active-inactive-".$user_id."'>Active</button>";
            $in_active_label = 'Inactive'; 
            } elseif($active == 1) {
            $in_active = "<button type='button' data-toggle='modal' data-target='#largeModal-active-inactive' onclick='javascript:update_user_status(".$user_id.");' class='btn btn-xs btn-default update-active-inactive' id='update-active-inactive-".$user_id."'>Inactive</button>";
            $in_active_label = 'Active'; 
            }
            $output['aaData'][] = array(
                    $row['username'],
                    $row['email_address'],
                    $row['first_name'],
                    $row['last_name'],
                    $row['middle_name'],
                    $row['birthdate'],
                    $gender,
                    $user_type_id,
                    $in_active_label,
                    $in_active,
                    $edit
                );
        }
        echo json_encode($output);
     }

    public function save() {
         $this->load->model('admin_model', 'Admin');
            $password = $this->create_password();
            $password_encrypt = $password['encrypt'];
            $password_text = $password['text'];
            $username = $this->input->post('username'); // username 
            $email_address = $this->input->post('email_address'); // email_address
            $first_name = $this->input->post('first_name'); // first_name
            $middle_name = $this->input->post('middle_name'); // middle_name
            $last_name = $this->input->post('last_name'); // username or email address
            $birth_date = $this->input->post('birth_date'); // username or email address
            $gender = $this->input->post('gender');
        $user_type_id = $this->input->post('u_id'); //user_type_id
        $user_type_name = $this->input->post('u_type_id'); //user_type_id

            $data_arr  = array('username' => $username, 'email_address' => $email_address, 'first_name' => $first_name,
                                                            'middle_name' => $middle_name, 'last_name' => $last_name, 'birthdate' => $birth_date,
            'gender' => $gender, 'password' => $password_encrypt, 'user_type_id' => $user_type_id);
        //Email sending
        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_port' => 465,
            'smtp_user' => 'asamante.tspi@gmail.com', // change it to yours
            'smtp_pass' => 'arS1035*', // change it to yours
            'mailtype' => 'html',
            'charset' => 'iso-8859-1',
            'wordwrap' => TRUE
        );

        $message = "Dear $first_name,
 <br />  <br />  <br /> 
User Information: <br /> <br />
Username: $username <br />
Name: $first_name $middle_name $last_name <br />
Email Address: $email_address <br />
User type: $user_type_name  <br />
Password: $password_text
<br /> <br />
Once the account is activated you can now login. And login to ".  base_url() ."  <br />
Please keep your assigned Email and Password in utmost secrecy to prevent unauthorized access of your account.
 <br /> <br /> <br /> 
Thank you very much!
 <br />  <br /> 
 Sisterhood Portal Admin";
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from('asamante.tspi@gmail.com'); // change it to yours
        $this->email->to($email_address); // change it to yours
        $this->email->bcc('asamante.tspi@gmail.com'); // change it to yours
        $this->email->subject("Sisterhood Portal User Registration"); //Need to put in constants
        $this->email->message($message);
        if ($this->email->send()) {
           $data['email'] = true;
        } else {
            show_error($this->email->print_debugger());
        }
            $data['result'] = $this->Admin->save_user($data_arr);
            //should save email here
            echo $data['result'];
           
     }

     private function create_password(){
      $length = 8;
      $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
      $password = substr(str_shuffle($chars),0,$length);
      $password_md5 = md5($password);
        $data_password = array('encrypt'=>$password_md5,
                               'text'=>$password);
        return $data_password;
     }

     public function get_update_user(){
      try{
                $reg_id = $this->input->post('reg_id');	
                if($reg_id){
                    $this->load->model('admin_model', 'Admin');
	
		   $result = $this->Admin->view_reg_user($reg_id);
                }
		echo json_encode($result);
      } catch (Exception $ex) {

      }

     }
     public function update_user(){
	    $postdata = sanitize_mix_post($_POST);
		
		try{
		//missing: validation here
		   if(!empty($postdata)) {
		      $this->load->model('admin_model', 'Admin');
		      $is_saved = $this->Admin->update_user_info($postdata);
			  print($is_saved);
		    } 
		} catch(Exception $e) {
		    
		}
     }

     public function update_user_status(){
	    $postdata = sanitize_mix_post($_POST);
        $first_name = $postdata['first_name'];
        $status = $postdata['action'];
        $email_address = $postdata['email_address'];
        $activate = 'Account De-activation';
        $extra_message = "de-activated. Please contact the administrator. ";
        if($status == 1){
            $activate = 'Account Activation';
            $extra_message = "activated. You may now login to ".  base_url() ." ";
        } 
		try{
		//missing: validation here
		   if(!empty($postdata)) {
		      $this->load->model('admin_model', 'Admin');
		      $is_saved = $this->Admin->update_user_status($postdata);
                      //Email sending
        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_port' => 465,
            'smtp_user' => 'asamante.tspi@gmail.com', // change it to yours
            'smtp_pass' => 'arS1035*', // change it to yours
            'mailtype' => 'html',
            'charset' => 'iso-8859-1',
            'wordwrap' => TRUE
        );

        $message = "Dear $first_name,
 <br />  <br />  <br /> 
Your account has been $extra_message
 <br /> 
Please keep your assigned Email and Password in utmost secrecy to prevent unauthorized access of your account.
 <br /> <br /> <br /> 
Thank you very much!
 <br />  <br /> 
 Sisterhood Portal Admin";
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from('asamante.tspi@gmail.com'); // change it to yours
        $this->email->to($email_address); // change it to yours
        $this->email->bcc('asamante.tspi@gmail.com'); // change it to yours
        $this->email->subject("Sisterhood Portal $activate"); //Need to put in constants
        $this->email->message($message);
        if ($this->email->send()) {
           $data['email'] = true;
        } else {
            show_error($this->email->print_debugger());
        }
        //end
		      print($is_saved);
		    } 
		} catch(Exception $e) {
		    
		}
     }
     
    public function report_pdf() {
        $html = $this->display_data_reports();
        $data = '    <table id="user_table" class="display" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th style="border: solid 1px black;" >Username</th>
                <th style="border: solid 1px black;" >Email Address</th>
                <th style="border: solid 1px black;" >First Name</th>
                <th style="border: solid 1px black;" >Middle Name</th>                
                <th style="border: solid 1px black;" >Last Name</th>
                <th style="border: solid 1px black;" >Birthdate</th>
                <th style="border: solid 1px black;" >Gender</th>
                <th style="border: solid 1px black;" >User Type</th>
                <th style="border: solid 1px black;" >Status</th>
            </tr>
        </thead>
        <tbody>';
        foreach ($html as $key => $val) {
            $gender = $val['gender'];
            $user_type_id = $val['user_type_id'];
            $active = $val['active'];
            $status = 'Inactive';
            $user_type_text = 'Invalid User';
            $gender_text = 'Male';
            if ($gender == 0) {
                $gender_text = 'Female';
            }
            if ($user_type_id == 1) {
                $user_type_text = 'Admin';
            } elseif ($user_type_id == 2) {
                $user_type_text = 'IRD';
            }
            if ($active == 1) {
                $status = 'Active';
            }
            $data .= '<tr>'
                    . '<td style="border: solid 1px black;" >'
                    . $val['username']
                    . '</td>'
                    . '<td style="border: solid 1px black;" >'
                    . $val['email_address']
                    . '</td>'
                    . '<td style="border: solid 1px black;" >'
                    . $val['first_name']
                    . '</td>'
                    . '<td style="border: solid 1px black;" >'
                    . $val['middle_name']
                    . '</td>'
                    . '<td style="border: solid 1px black;" >'
                    . $val['last_name']
                    . '</td>'
                    . '<td style="border: solid 1px black;" >'
                    . $val['birthdate']
                    . '</td>'
                    . '<td style="border: solid 1px black;" >'
                    . $gender_text
                    . '</td>'
                    . '<td style="border: solid 1px black;" >'
                    . $user_type_text
                    . '</td>'
                    . '<td style="border: solid 1px black;" >'
                    . $status
                    . '</td>'
            ;
            $data .= '</tr>';
        }

        $data .= '</tbody>
    </table> ';
        //  die();
        $filename = "List_of_Users_" . date('Y-m-d H:i:s');
        $this->load->helper(array('dompdf', 'file'));
        // page info here, db calls, etc.     
        //  $html ="testing";
        $data = pdf_create($data, $filename, true);
        write_file('name', $data);
    }

    public function report_excel() {
        //load our new PHPExcel library
        $this->load->library('excel');
        //activate worksheet number 1
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('test worksheet');
        //set cell A1 content with some text
        $this->excel->getActiveSheet()->setCellValue('A1', 'Username');
        $this->excel->getActiveSheet()->setCellValue('B1', 'Email Address');
        $this->excel->getActiveSheet()->setCellValue('C1', 'First Name');
        $this->excel->getActiveSheet()->setCellValue('D1', 'Middle Name');
        $this->excel->getActiveSheet()->setCellValue('E1', 'Last Name');
        $this->excel->getActiveSheet()->setCellValue('F1', 'Birthdate');
        $this->excel->getActiveSheet()->setCellValue('G1', 'Gender');
        $this->excel->getActiveSheet()->setCellValue('H1', 'User Type');
        $this->excel->getActiveSheet()->setCellValue('I1', 'Status');
        //change the font size
        $this->excel->getActiveSheet()->getStyle('A1:I1')->getFont()->setSize(12);
        //make the font become bold
        $this->excel->getActiveSheet()->getStyle('A1:I1')->getFont()->setBold(true);
        //data
        $result = $this->display_data_reports();

        $ctr = 2;
        foreach ($result as $key => $val) {
            $gender = $val['gender'];
            $user_type_id = $val['user_type_id'];
            $active = $val['active'];
            $status = 'Inactive';
            $user_type_text = 'Invalid User';
            $gender_text = 'Male';
            if ($gender == 0) {
                $gender_text = 'Female';
            }
            if ($user_type_id == 1) {
                $user_type_text = 'Admin';
            } elseif ($user_type_id == 2) {
                $user_type_text = 'IRD';
            }
            if ($active == 1) {
                $status = 'Active';
            }
            $this->excel->getActiveSheet()->setCellValue('A' . $ctr, $val['username']);
            $this->excel->getActiveSheet()->setCellValue('B' . $ctr, $val['email_address']);
            $this->excel->getActiveSheet()->setCellValue('C' . $ctr, $val['first_name']);
            $this->excel->getActiveSheet()->setCellValue('D' . $ctr, $val['middle_name']);
            $this->excel->getActiveSheet()->setCellValue('E' . $ctr, $val['last_name']);
            $this->excel->getActiveSheet()->setCellValue('F' . $ctr, $val['birthdate']);
            $this->excel->getActiveSheet()->setCellValue('G' . $ctr, $gender_text);
            $this->excel->getActiveSheet()->setCellValue('H' . $ctr, $user_type_text);
            $this->excel->getActiveSheet()->setCellValue('I' . $ctr, $status);

            $ctr++;
        }


        //merge cell A1 until D1
//        $this->excel->getActiveSheet()->mergeCells('A1:D1');
        //set aligment to center for that merged cell (A1 to D1)
        $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $filename = "List_of_Users_" . date('Y-m-d H:i:s') . ".xls"; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
    }

    public function display_data_reports() {


        $result = $this->Admin->view_users();

        return $result;
    }

    public function reset_password(){
        $password = $this->create_password();
        $postdata = sanitize_mix_post($_POST);
        $info = array(
            'password' => $password['encrypt'],
            'user_id' => $postdata['user_id']
        );

        $user = $this->Admin->view_reg_user($postdata['user_id']);
        $subject = 'Password Reset';
        try{
            //missing: validation here
            if(!empty($postdata)) {
                $this->load->model('admin_model', 'Admin');
                $is_saved = $this->Admin->reset_user_password($info);
                //Email sending

                $message = "Dear ".$user['first_name'].",
                    <br />  <br />  <br /> 
                   Your password has been reset.
                    <br /> 
                    Your temporary password is: <b>.".$password['text']."</b>
                    <br />
                   Please change your password after logging in to prevent unauthorized access.
                    <br /> <br /> <br /> 
                   Thank you very much!
                    <br />  <br /> 
                    Sisterhood Portal Admin";
                    $this->email->set_newline("\r\n");
                    $this->email->from('asamante.tspi@gmail.com'); // change it to yours
                    $this->email->to($user['email_address']); // change it to yours
                    $this->email->bcc('asamante.tspi@gmail.com', 'mfacto.tspi@gmail.com'); // change it to yours
                    $this->email->subject("Sisterhood Portal $subject"); //Need to put in constants
                    $this->email->message($message);
                    
                if ($this->email->send()) {
                   $data['email'] = true;
                } else {
                    show_error($this->email->print_debugger());
                }
                //end
                $return_info = array(
                  'status' => (boolean) $is_saved,
                  'email' => $user['email_address']
                );
                echo json_encode($return_info);
            } 
        } catch(Exception $e) {

        }
    }

}
