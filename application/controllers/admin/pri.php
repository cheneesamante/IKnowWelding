<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pri extends CI_Controller {

    public function __construct()
    {

       //$this->output->set_template('default');
       parent::__construct();
       $this->load->helper('url');
       // Your own constructor code
       $this->load->model('admin_model', 'Admin');
       $this->load->model('common_model', 'common_model');
    }
    public function index()
    {
        if($this->session->userdata('info')['user_id'] == true) {
        $this->load->view('header_main');
        $data['contents'] = $this->Admin->view_users();
        $this->load->view('admin/pri_view', $data);                      
        } else {
        $this->load->library('common');  
        $data['menu'] =  $this->common->_menu();
        $this->load->view('header', $data);
        $this->load->view('error_page_view'); 
        }
        $this->load->view('footer'); 
    }
    public function display_data() {
        $search_month = $_REQUEST['search_month'];
        $search_year = $_REQUEST['search_year'];
        $sEcho = $this->input->get_post('sEcho', true);
        
        $aColumns = array('event_id', 
                          'event_name', 
                          'event_datetime', 
                          'reg_date', 
                          'status'
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
        if (isset($_POST['sSearch']) != "") {
            $sWhere = " WHERE (";
            for ($i = 0; $i < count($aColumns); $i++) {
                $sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string( $_POST['sSearch'] )."%' OR ";
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
        if($search_month == true && $search_year == true){
            $sWhere .= "and YEAR(event_datetime) = ".$search_year." AND MONTH(event_datetime) = ".$search_month."";
        }
       ///var_dump($sWhere);
        $result = $this->common_model->view_private($sWhere, $sOrder, $sLimit);
        $iTotal = $this->common_model->count_private($sWhere)->total;
        $output = array(
            'sEcho' => intval($sEcho),
            'iTotalRecords' => $iTotal,
            'iTotalDisplayRecords' => $iTotal,
            'aaData' => array()
        );
        
        foreach ($result as $row) {
            if($row['status'] == 0){
                $status_text = 'Deleted';
            } else {
                $status_text = 'Active';
            }
            $output['aaData'][] = array(
                    $row['event_id'],
                    $row['event_name'],
                    $row['event_date'],
                    $row['event_time'],
                    $row['reg_by'],
                    $row['reg_date'],
                    $row['update_by'],
                    $row['update_date'],
                    $status_text
                );
            
        }
        echo json_encode($output);
       }
       
  //report PDF
  public function report_pdf(){
     $search_month = $_REQUEST['search_month'];
     $search_year = $_REQUEST['search_year'];
     $arr = array('search_month'=>$search_month, 'search_year'=> $search_year);
     $output = $this->display_data_reports($arr);
      //  print_r($output['aaData']);
       //pdf
      $data = '    <table id="private_archives" class="display" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th style="border: solid 1px black;" >Event Id</th>
                <th style="border: solid 1px black;" >Event Name</th>
                <th style="border: solid 1px black;" >Event Date</th>
                <th style="border: solid 1px black;" >Event Time</th>                
                <th style="border: solid 1px black;" >Registered By</th>
                <th style="border: solid 1px black;" >Registration Date </th>
                <th style="border: solid 1px black;" >Updated By</th>
                <th style="border: solid 1px black;" >Updated Date</th>
                <th style="border: solid 1px black;" >Status</th>
            </tr>
        </thead>
        <tbody>';
        foreach ($output as $key => $val) {
            if($val['status'] == 0){
                $status_text = 'Deleted';
            } else {
                $status_text = 'Active';
            }
            $data .= '<tr>'
                    . '<td style="border: solid 1px black;" >'
                    . $val['event_id']
                    . '</td>'
                    . '<td style="border: solid 1px black;" >'
                    . $val['event_name']
                    . '</td>'
                    . '<td style="border: solid 1px black;" >'
                    . $val['event_date']
                    . '</td>'
                    . '<td style="border: solid 1px black;" >'
                    . $val['event_time']
                    . '</td>'
                    . '<td style="border: solid 1px black;" >'
                    . $val['reg_by']
                    . '</td>'
                    . '<td style="border: solid 1px black;" >'
                    . $val['reg_date']
                    . '</td>'
                    . '<td style="border: solid 1px black;" >'
                    . $val['update_by']
                    . '</td>'
                    . '<td style="border: solid 1px black;" >'
                    . $val['update_date']
                    . '</td>'
                    . '<td style="border: solid 1px black;" >'
                    . $status_text
                    . '</td>'
            ;
            $data .= '</tr>';
        }

        $data .= '</tbody>
    </table> ';

        $filename = "List_of_All_Private_Archives_" . date('Y-m-d H:i:s');
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
        $this->excel->getActiveSheet()->setCellValue('A1', 'Event ID');
        $this->excel->getActiveSheet()->setCellValue('B1', 'Event Name');
        $this->excel->getActiveSheet()->setCellValue('C1', 'Event Date');
        $this->excel->getActiveSheet()->setCellValue('D1', 'Event Time');
        $this->excel->getActiveSheet()->setCellValue('E1', 'Registered By');
        $this->excel->getActiveSheet()->setCellValue('F1', 'Registration Date');
        $this->excel->getActiveSheet()->setCellValue('G1', 'Updated By');
        $this->excel->getActiveSheet()->setCellValue('H1', 'Update Date');
        $this->excel->getActiveSheet()->setCellValue('I1', 'Status');
        //change the font size
        $this->excel->getActiveSheet()->getStyle('A1:I1')->getFont()->setSize(12);
        //make the font become bold
        $this->excel->getActiveSheet()->getStyle('A1:I1')->getFont()->setBold(true);
        //data
     $search_month = $_REQUEST['search_month'];
     $search_year = $_REQUEST['search_year'];
     $arr = array('search_month'=>$search_month, 'search_year'=> $search_year);
     $result = $this->display_data_reports($arr);

        $ctr = 2;
        foreach ($result as $key => $val) {
            if($val['status'] == 0){
                $status_text = 'Deleted';
            } else {
                $status_text = 'Active';
            }
            $this->excel->getActiveSheet()->setCellValue('A' . $ctr, $val['event_id']);
            $this->excel->getActiveSheet()->setCellValue('B' . $ctr, $val['event_name']);
            $this->excel->getActiveSheet()->setCellValue('C' . $ctr, $val['event_date']);
            $this->excel->getActiveSheet()->setCellValue('D' . $ctr, $val['event_time']);
            $this->excel->getActiveSheet()->setCellValue('E' . $ctr, $val['reg_by']);
            $this->excel->getActiveSheet()->setCellValue('F' . $ctr, $val['reg_date']);
            $this->excel->getActiveSheet()->setCellValue('G' . $ctr, $val['update_by']);
            $this->excel->getActiveSheet()->setCellValue('H' . $ctr, $val['update_date']);
            $this->excel->getActiveSheet()->setCellValue('I' . $ctr, $status_text);

            $ctr++;
        }


        //merge cell A1 until D1
//        $this->excel->getActiveSheet()->mergeCells('A1:D1');
        //set aligment to center for that merged cell (A1 to D1)
        $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $filename = "List_of_All_Private_Archives_" . date('Y-m-d H:i:s') . ".xls"; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
    }  
    public function display_data_reports($search = null) {
        $search = " where YEAR(event_datetime) = ".$search['search_year']." AND MONTH(event_datetime) = ".$search['search_month']."";
        $result = $result = $this->common_model->view_private($search);

        return $result;
    }    
}
