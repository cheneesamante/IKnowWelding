<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Private_archives extends CI_Controller {

    public function __construct() {

        //$this->output->set_template('default');
        parent::__construct();
        $this->load->helper('url');
        // Your own constructor code
        $this->load->model('admin_model', 'Admin');
        $this->load->model('common_model', 'common_model');
    }

    public function index() {
        if ($this->session->userdata('info')['user_id'] == true && ($this->session->userdata('info')['user_type_id'] == ADMIN || $this->session->userdata('info')['user_type_id'] == IRD_EMP)) {
            $this->load->view('header_main');
            $data['contents'] = $this->Admin->view_users();
            $this->load->view('admin/private_archives_view', $data);
        } else {
            $this->load->library('common');
            $data['menu'] = $this->common->_menu();
            $this->load->view('header', $data);
            $this->load->view('error_page_view');
        }
        $this->load->view('footer');
    }

    public function display_data() {
        if ($this->session->userdata('info')['user_id'] == true && ($this->session->userdata('info')['user_type_id'] == ADMIN || $this->session->userdata('info')['user_type_id'] == IRD_EMP)) {
            $search_month = $_REQUEST['search_month'];
            if ($search_month == '[object Object]' || $search_month == null) {
                $search_month = date("m");
            }
            $search_year = $_REQUEST['search_year'];
            $sEcho = $this->input->get_post('sEcho', true);

            $aColumns = array('file_id',
                'file_name',
                'user_id',
                'reg_date'
            );
            /*
             * Ordering
             */
            if (isset($_POST['iSortCol_0'])) {
                $sOrder = " ORDER BY  ";
                for ($i = 0; $i < intval($_POST['iSortingCols']); $i++) {
                    if ($_POST['bSortable_' . intval($_POST['iSortCol_' . $i])] == "true") {
                        $sOrder .= $aColumns[intval($_POST['iSortCol_' . $i])] . "
                            " . mysql_real_escape_string($_POST['sSortDir_' . $i]) . ", ";
                    }
                }

                $sOrder = substr_replace($sOrder, "", -2);
                if ($sOrder == " ORDER BY") {
                    $sOrder = "";
                }
            }

            /*
             * Paging
             */
            $sLimit = "";
            if (isset($_POST['iDisplayStart']) && $_POST['iDisplayLength'] != '-1') {
                $sLimit = " LIMIT " . mysql_real_escape_string($_POST['iDisplayStart']) . ", " .
                        mysql_real_escape_string($_POST['iDisplayLength']);
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
                    $sWhere .= $aColumns[$i] . " LIKE '%" . mysql_real_escape_string($_POST['sSearch']) . "%' OR ";
                }
                $sWhere = substr_replace($sWhere, "", -3);
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
                    $sWhere .= $aColumns[$i] . " LIKE '%" . mysql_real_escape_string($_POST['sSearch_' . $i]) . "%' ";
                }
            }
            if ($search_month == true && $search_year == true) {
                $sWhere .= "and YEAR(reg_date) = " . $search_year . " AND MONTH(reg_date) = " . $search_month . "";
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
//$file = file_get_contents('./bootstrap/archives/'.$row['file_name']);
                $file = $row['file_name'];

                $path = " <a href='" . base_url() . "admin/private_archives/download_files/" . $file . "' >" . $file . "  </a> ";
                $output['aaData'][] = array(
                    $row['file_id'],
                    $path,
                    $row['uploaded_by'],
                    $row['reg_date']
                );
            }
            echo json_encode($output);
        } else {
            redirect('logout');
        }
    }

    //report PDF
    public function report_pdf() {
        if ($this->session->userdata('info')['user_id'] == true && ($this->session->userdata('info')['user_type_id'] == ADMIN || $this->session->userdata('info')['user_type_id'] == IRD_EMP)) {
//     $search_month = $_REQUEST['search_month'];
            $search_month = date('m');
//     $search_year = $_REQUEST['search_year'];
            $search_year = date('Y');
            $arr = array('search_month' => $search_month, 'search_year' => $search_year);
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
                if ($val['status'] == 0) {
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
        } else {
            redirect('logout');
        }
    }

    public function report_excel() {
        if ($this->session->userdata('info')['user_id'] == true && ($this->session->userdata('info')['user_type_id'] == ADMIN || $this->session->userdata('info')['user_type_id'] == IRD_EMP)) {
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
//     $search_month = $_REQUEST['search_month'];
            $search_month = date('m');
//     $search_year = $_REQUEST['search_year'];
            $search_year = date('Y');
            $arr = array('search_month' => $search_month, 'search_year' => $search_year);
            $result = $this->display_data_reports($arr);

            $ctr = 2;
            foreach ($result as $key => $val) {
                if ($val['status'] == 0) {
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
        } else {
            redirect('logout');
        }
    }

    public function display_data_reports($search = null) {
        $search = " where YEAR(event_datetime) = " . $search['search_year'] . " AND MONTH(event_datetime) = " . $search['search_month'] . "";
        $result = $result = $this->common_model->view_events_list($search);

        return $result;
    }

//upload document
    public function upload_document() {
        if ($this->session->userdata('info')['user_id'] == true && ($this->session->userdata('info')['user_type_id'] == ADMIN || $this->session->userdata('info')['user_type_id'] == IRD_EMP)) {
            $user_id = $this->session->userdata('info')['user_id'];
            if (isset($_FILES["file"]["type"])) {
                $validextensions = array("pdf", "doc", "docx", "txt", "xls", "xlsx");
                $size = $_FILES["file"]["size"];
                $temporary = explode(".", $_FILES["file"]["name"]);
                $type = $_FILES["file"]["type"];
                $file_extension = end($temporary);

                if ((($type == "application/vnd.ms-word") || ($type == "text/pdf") || ($type == "application/pdf") || ($type == "application/msword") || ($type == "text/plain") || ($type == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet") || ($type == "application/vnd.ms-excel") 
                        || ($type == "application/vnd.openxmlformats-officedocument.wordprocessingml.document")
                        ) && ($size < 1000000)//Approx. 100kb files can be uploaded. 10mb
                        && in_array($file_extension, $validextensions)) {

                    if ($_FILES["file"]["error"] > 0) {
                        echo "Return Code: " . $_FILES["file"]["error"] . "<br/><br/>";
                    } else {
//                        $file_name = $user_id . "_" . date('Y-m-d H-i-s');
                        $string_remove = preg_replace('/\s+/','',$temporary[0]);
                        $file_name = $user_id . '_' . $string_remove;
                        $extension = end(explode('.', $_FILES['file']['name']));
                        $finalfilename = $file_name . '.' . $extension;
                        // if (file_exists("./bootstrap/upload/" . $finalfilename)) {
                        //     echo $_FILES["file"]["name"] . " <span id='invalid'><b>Already exists.</b></span> ";
                        // } else {
                        //update date base

                        $param_array = array('user_id' => $user_id,
                            'reg_date' => date('Y-m-d H-i-s'),
                            'file_name' => $finalfilename);
                        if ($this->Admin->save_file($param_array)) {
                            //filename 

                            $sourcePath = $_FILES['file']['tmp_name'];   // Storing source path of the file in a variable

                            $targetPath = "./bootstrap/archives/$finalfilename";  // Target path where file is to be stored

                            move_uploaded_file($sourcePath, $targetPath); //  Moving Uploaded file						

                            echo "<span id='success'>File Uploaded Successfully...!!</span><br/>";
                            echo "<br/><b>File Name:</b> " . $finalfilename . "<br>";
                            echo "<b>Type:</b> " . $_FILES["file"]["type"] . "<br>";
                            echo "<b>Size:</b> " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
                            echo "<b>Temp file:</b> " . $_FILES["file"]["tmp_name"] . "<br>";
                        } else {
                            echo "<span id='invalid'><span><div class='alert alert-danger'>Invalid File.</div>";
                        }
                        // }
                    }
                } else {
                    echo "<span id='invalid'>Invalid file Size or Type<span>";
                }
            }
        } else {
            redirect('logout');
        }
    }

    public function download_files($param_file = null) {

        try {
            if ($this->session->userdata('info')['user_id'] == true && ($this->session->userdata('info')['user_type_id'] == ADMIN || $this->session->userdata('info')['user_type_id'] == IRD_EMP)) {
                if ($param_file != null) {
                    $file = $param_file;
                    $finalpath = base_url() . "bootstrap/archives/" . $file;
                    $abs_path = $_SERVER['DOCUMENT_ROOT'];
                    $finalpath1 = $abs_path . "/iknowwelding/bootstrap/archives/" . $file; // the location of the file.
                    $file_size = filesize($finalpath1);
                    // if (file_exists($filefullpath)) {
                    $param_file_explode = explode('.', $param_file);
                    $file_extension = $param_file_explode[1];
                    switch ($file_extension) {
                        case "pdf": $ctype = "application/pdf";
                            break;
                        case "txt": $ctype = "application/octet-stream";
                            break;
//  case "zip": $ctype="application/zip"; break;
                        case "doc": $ctype = "application/msword";
                            break;
                        case "docx": $ctype = "application/vnd.openxmlformats-officedocument.wordprocessingml.document";
                            break;
                        case "xls": $ctype = "application/vnd.ms-excel";
                            break;
                        case "xlsx": $ctype = "application/vnd.ms-excel";
                            break;
//  case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
                        default: $ctype = "application/force-download";
                    }

                    header("Pragma: public"); // required
                    header("Expires: 0");
                    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
                    header("Content-Type: $ctype");
                    header('Cache-Control: max-age=0'); //no cache
                    header("Content-Description: File Transfer");
                    header("Content-Disposition: attachment; filename=\"" . basename($file) . "\";");
                    header("Content-Type: $ctype");
                    header("Content-Transfer-Encoding: binary");
                    header('Content-Length: ' . $file_size);
                    //  ob_clean();
                    //   flush();

                    readfile($finalpath);
                    exit;
                }
                //    }
            } else {
                redirect('logout');
            }
        } catch (Exception $ex) {
            
        }
    }

}
