<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cms extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('common');
        $this->load->model('admin_model', 'Admin');
    }

    public function index() {
        if ($this->session->userdata('info')['user_id'] == true) {
            $this->load->view('header_main');

            $data['contents'] = $this->Admin->get_cms();
            $data['pages'] = $this->get_pages();

            $this->load->view('admin/cms_view', $data);
        } else {
            $data['menu'] = $this->common->_menu();
            $this->load->view('header', $data);
            $this->load->view('error_page_view');
        }
        $this->load->view('footer');
    }

    public function save() {
        $page_id = $this->input->post('page');
        $title = $this->input->post('title');
        $bodytext = $this->input->post('bodytext');
        $reg_date = date('Y-m-d H:i:s');
        $where = " AND page_id = $page_id ";
        if($page_id == '0004'){
            $active = 1;
        } else {
        $active = (count($this->Admin->get_active_cms($where)) > 0) ? 0 : 1; // temporary only
        }
        $data['result'] = $this->Admin->save_cms(array('active' => $active, 'page_id' => $page_id, 'title' => $title, 'body' => $bodytext, 'reg_date' => $reg_date));

        echo $data['result'];
    }

    public function display_data() {

        $sEcho = $this->input->get_post('sEcho', true);

        $aColumns = array('page_name_desc',
            'title',
            'body',
            'reg_date',
            'active_desc',
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
        if ($_POST['sSearch'] != "") {
            $sWhere = " WHERE (";
            for ($i = 0; $i < count($aColumns); $i++) {
                if ($aColumns[$i] == 'active_desc') {
                    $sWhere .= "IF (active = 1, 'active', 'inactive')  LIKE '" . mysql_real_escape_string($_POST['sSearch']) . "%' OR ";
                } else if ($aColumns[$i] == 'page_name_desc') {
                    $sWhere .= "CASE page_id ";
                    // $sWhere .= "    WHEN 0001 THEN 'Makati Sister City Program' ";
                    $sWhere .= "    WHEN 0002 THEN 'Other Local Government'  ";
                    $sWhere .= "    WHEN 0003 THEN 'City of Makati' ";
                    $sWhere .= "    WHEN 0004 THEN 'Makati Sister Cities' ";
                    $sWhere .= "    WHEN 0005 THEN 'List of Makati Sisterhood' ";
                    $sWhere .= " END LIKE '%" . mysql_real_escape_string($_POST['sSearch']) . "%' OR ";
                } else {
                    $sWhere .= $aColumns[$i] . " LIKE '%" . mysql_real_escape_string($_POST['sSearch']) . "%' OR ";
                }
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

        $result = $this->Admin->get_cms($sWhere, $sOrder, $sLimit);
        $iTotal = $this->Admin->count_cms($sWhere)->total;
        $output = array(
            'sEcho' => intval($sEcho),
            'iTotalRecords' => $iTotal,
            'iTotalDisplayRecords' => $iTotal,
            'aaData' => array()
        );

        foreach ($result as $row) {
            $page_name = $this->common->_get_page_name($row['page_id']);
            $page_id = $row['cms_id'];
            $active = $row['active'];
            $edit = "<button type='button' onclick='javascript:update_cms(" . $page_id . ");' data-toggle='modal' data-target='#largeModal-update-cms' class='btn btn-xs btn-default update-reg' id='update-cms-" . $page_id . "'>Update</button>";
            if ($active == 0) {
                $in_active = "<button type='button' data-toggle='modal' data-target='#largeModal-active-inactive-cms' onclick='javascript:update_cms_status(" . $page_id . ");' class='btn btn-xs btn-default update-active-inactive' id='update-active-inactive-" . $page_id . "'>Active</button>";
                $in_active_label = 'Inactive';
            } elseif ($active == 1) {
                $in_active = "<button type='button' data-toggle='modal' data-target='#largeModal-active-inactive-cms' onclick='javascript:update_cms_status(" . $page_id . ");' class='btn btn-xs btn-default update-active-inactive' id='update-active-inactive-" . $page_id . "'>Inactive</button>";
                $in_active_label = 'Active';
            }
            $output['aaData'][] = array(
                $page_name,
                $row['title'],
                $row['reg_date'],
                $in_active_label,
                $in_active,
                $edit
            );
        }

        echo json_encode($output);
    }

    public function display_cities_data() {

        $sEcho = $this->input->get_post('sEcho', true);

        $aColumns = array('city.city_name',
            'city.reg_date',
            'city.update_date',
            'user.username',
            'created.username',
            'active_desc'
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
        if ($_POST['sSearch'] != "") {
            $sWhere = " WHERE (";
            for ($i = 0; $i < count($aColumns); $i++) {

                if ($aColumns[$i] == 'active_desc') {
                    $sWhere .= "IF (city.active = 1, 'active', 'inactive')  LIKE '" . mysql_real_escape_string($_POST['sSearch']) . "%' OR ";
                } else {
                    $sWhere .= $aColumns[$i] . " LIKE '%" . mysql_real_escape_string($_POST['sSearch']) . "%' OR ";
                }
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

        $result = $this->Admin->get_sister_cities($sWhere, $sOrder, $sLimit);
        $iTotal = $this->Admin->count_sister_cities($sWhere)->total;
        $output = array(
            'sEcho' => intval($sEcho),
            'iTotalRecords' => $iTotal,
            'iTotalDisplayRecords' => $iTotal,
            'aaData' => array()
        );

        foreach ($result as $row) {
            $in_active_label = '';
            $in_active = '';
            $edit = '';

            $city_id = $row['city_id'];
            $active = $row['active'];
            $edit = "<button type='button' onclick='javascript:update_sister_city(" . $city_id . ");' data-toggle='modal' data-target='#largeModal-update-sistercity' class='btn btn-xs btn-default update-reg' id='update-sistercity-" . $city_id . "'>Update</button>";
            if ($active == 0) {
                $in_active = "<button type='button' data-toggle='modal' data-target='#largeModal-active-inactive-sistercity' onclick='javascript:update_city_status(" . $city_id . ");' class='btn btn-xs btn-default update-active-inactive' id='update-sisterhood-status-" . $city_id . "'>Active</button>";
                $in_active_label = 'Inactive';
            } elseif ($active == 1) {
                $in_active = "<button type='button' data-toggle='modal' data-target='#largeModal-active-inactive-sistercity' onclick='javascript:update_city_status(" . $city_id . ");' class='btn btn-xs btn-default update-active-inactive' id='update-sisterhood-status-" . $city_id . "'>Inactive</button>";
                $in_active_label = 'Active';
            }
            $output['aaData'][] = array(
                $row['city_name'],
                $row['created_by'],
                $row['reg_date'],
                $row['update_date'],
                $row['last_updated_by'],
                $in_active_label,
                $in_active,
                $edit
            );
        }

        echo json_encode($output);
    }

    public function display_news_data() {

        $sEcho = $this->input->get_post('sEcho', true);

        $aColumns = array('news_title',
            'news_summary',
            'news.reg_date',
            'news.update_date',
            'news.news_date',
            'user.username',
            'created.username',
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
        if ($_POST['sSearch'] != "") {
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

        $result = $this->Admin->get_news($sWhere, $sOrder, $sLimit);
        $iTotal = $this->Admin->count_news($sWhere)->total;
        $output = array(
            'sEcho' => intval($sEcho),
            'iTotalRecords' => $iTotal,
            'iTotalDisplayRecords' => $iTotal,
            'aaData' => array()
        );

        foreach ($result as $row) {
            $in_active_label = '';
            $in_active = '';
            $edit = '';

            $news_id = $row['news_id'];
            $edit = "<button type='button' onclick='javascript:update_news(" . $news_id . ");' data-toggle='modal' data-target='#largeModal-update-news' class='btn btn-xs btn-default update-reg' id='update-news-" . $news_id . "'>Update</button>";

            $output['aaData'][] = array(
                $row['news_title'],
                $row['news_summary'],
                $row['created_by'],
                $row['news_date'],
                $row['reg_date'],
                $row['update_date'],
                $row['last_updated_by'],
                $edit
            );
        }

        echo json_encode($output);
    }

    private function get_pages() {
        $result = $this->common->_pages_cms();
        $data_select1 = "<select class='form-control' name='page_id' id = 'page_id'>";
        foreach ($result as $key => $val) {
            $data_select1 .= "<option id = " . $val[1] . "> " . $val[0] . "</option> ";
        }
        $data_select1 .= "</select>";

        return $data_select1;
    }

    public function get_update_cms() {
        try {
            $cms_id = $this->input->post('cms_id');
            if ($cms_id) {
                $this->load->model('admin_model', 'Admin');

                $result = $this->Admin->view_page($cms_id);
                $result['pages'] = $this->get_selected_page($result['page_id']);
            }
            echo json_encode($result);
        } catch (Exception $ex) {
            
        }
    }

    public function get_update_news() {
        try {
            $news_id = $this->input->post('news_id');
            if ($news_id) {
                $this->load->model('admin_model', 'Admin');

                $result = $this->Admin->view_news($news_id);
            }
            echo json_encode($result);
        } catch (Exception $ex) {
            
        }
    }

    public function get_update_city() {
        try {
            $city_id = $this->input->post('city_id');
            if ($city_id) {
                $this->load->model('admin_model', 'Admin');

                $result = $this->Admin->view_sister_city($city_id);
            }
            echo json_encode($result);
        } catch (Exception $ex) {
            
        }
    }

    //get selected cms
    private function get_selected_page($param_page_id) {
        $result = $this->common->_pages_cms();
        $data_select1 = "<select class='form-control' name = 'page_id_update' id = 'page_id_update'>";
        foreach ($result as $key => $val) {
            if ($param_page_id == $val[1]) {
                $data_select1 .= "<option id = " . $val[1] . " selected='selected'> " . $val[0] . "</option> ";
            } else {
                $data_select1 .= "<option id = " . $val[1] . "> " . $val[0] . "</option> ";
            }
        }
        $data_select1 .= "</select>";

        return $data_select1;
    }

    public function update_page() {
        $postdata = sanitize_mix_post($_POST);
        try {
            //missing: validation here
            if (!empty($postdata)) {
                $this->load->model('admin_model', 'Admin');
                $is_saved = $this->Admin->update_page_info($postdata);
                echo $is_saved;
            }
        } catch (Exception $e) {
            
        }
    }

    public function update_page_status() {
        $postdata = sanitize_mix_post($_POST);
        //	var_dump($postdata);
        try {
            //missing: validation here
            if (!empty($postdata)) {
                $this->load->model('admin_model', 'Admin');
                $cms_id = $this->input->post('cms_id');
                $is_saved = false;
                $page_info = $this->Admin->view_page($cms_id);
                $where = " AND page_id = " . $page_info['page_id'];
                        
                $is_saved = $this->Admin->update_page_status($postdata);

                print($is_saved);
            }
        } catch (Exception $e) {
            
        }
    }

    public function report_pdf() {
        $html = $this->display_data_reports();
        $data = '    <table id="user_table" style="border: solid 1px black;" class="display" width="100%" cellspacing="0">
        <thead style="border: solid 1px black;" >
            <tr>
                <th style="border: solid 1px black;" >Title</th>
                <th style="border: solid 1px black;" >Body</th>
                <th style="border: solid 1px black;" >Registration Date</th>
                <th style="border: solid 1px black;" >Page Name</th>                
                <th style="border: solid 1px black;" >Status</th>
            </tr>
        </thead>
        <tbody style="border: solid 1px black;" >';
        foreach ($html as $key => $val) {
            $active = $val['active'];
            $page_id = $val['page_id'];
            $status = 'Inactive';
            $page_name = $this->common->_get_page_name($page_id);

            if ($active == 1) {
                $status = 'Active';
            }
            $data .= '<tr>'
                    . '<td style="border: solid 1px black;" >'
                    . $val['title']
                    . '</td>'
                    . '<td style="border: solid 1px black;" >'
                    . $val['body']
                    . '</td>'
                    . '</td>'
                    . '<td style="border: solid 1px black;" >'
                    . $val['reg_date']
                    . '</td>'
                    . '<td style="border: solid 1px black;" >'
                    . $page_name
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
        $filename = "List_of_Pages_" . date('Y-m-d H:i:s');
        $this->load->helper(array('dompdf', 'file'));
        // page info here, db calls, etc.     
        //  $html ="testing";
        $data = pdf_create($data, $filename, true);
        write_file('name', $data);
    }

    public function report_excel() {
        //load our new PHPExcel library
        $this->load->library('excel');
//        $this->load->library('PDF');
        //activate worksheet number 1
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('test worksheet');
        //set cell A1 content with some text
        $this->excel->getActiveSheet()->setCellValue('A1', 'Title');
        $this->excel->getActiveSheet()->setCellValue('B1', 'Body');
        $this->excel->getActiveSheet()->setCellValue('C1', 'Registration Date');
        $this->excel->getActiveSheet()->setCellValue('D1', 'Page Name');
        $this->excel->getActiveSheet()->setCellValue('E1', 'Status');
        //change the font size
        $this->excel->getActiveSheet()->getStyle('A1:I1')->getFont()->setSize(12);
        //make the font become bold
        $this->excel->getActiveSheet()->getStyle('A1:I1')->getFont()->setBold(true);
        //data
        $result = $this->display_data_reports();

        $ctr = 2;
        foreach ($result as $key => $val) {
            $active = $val['active'];
            $page_id = $val['page_id'];
            $status = 'Inactive';
            $page_name = $this->common->_get_page_name($page_id);

            if ($active == 1) {
                $status = 'Active';
            }
            $this->excel->getActiveSheet()->setCellValue('A' . $ctr, $val['title']);
            $this->excel->getActiveSheet()->setCellValue('B' . $ctr, $val['body']);
            $this->excel->getActiveSheet()->setCellValue('C' . $ctr, $val['reg_date']);
            $this->excel->getActiveSheet()->setCellValue('D' . $ctr, $page_name);
            $this->excel->getActiveSheet()->setCellValue('E' . $ctr, $status);
            $ctr++;
        }


        //merge cell A1 until D1
//        $this->excel->getActiveSheet()->mergeCells('A1:D1');
        //set aligment to center for that merged cell (A1 to D1)
        $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $filename = "List_of_Pages_" . date('Y-m-d H:i:s') . ".xls"; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
    }
   //CMS
    public function display_data_reports() {


        $result = $this->Admin->get_cms();

        return $result;
    }
    //Sister cities
    public function display_cities_reports() {

        $result = $this->Admin->get_sister_cities();

        return $result;
    }
    //News
    public function display_news_reports() {

        $result = $this->Admin->get_news();

        return $result;
    }

    public function map_process() {
        ################ Save & delete markers #################
        $this->remove_map_sess();
        if ($_POST) { //run only if there's a post data
            //make sure request is comming from Ajax
            $xhr = $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
            if (!$xhr) {
                header('HTTP/1.1 500 Error: Request must come from Ajax!');
                exit();
            }

            // get marker position and split it for database
            $mLatLang = explode(',', $_POST["latlang"]);
            $mLat = filter_var($mLatLang[0], FILTER_VALIDATE_FLOAT);
            $mLng = filter_var($mLatLang[1], FILTER_VALIDATE_FLOAT);

            //Delete Marker
            if (isset($_POST["del"]) && $_POST["del"] == true) {
                $results = $this->Admin->delete_marker($mLat, $mLng);
                if (!$results) {
                    header('HTTP/1.1 500 Error: Could not delete Markers!');
                    exit();
                }
                exit("Done!");
            }

            $mName = filter_var($_POST["name"], FILTER_SANITIZE_STRING);
            $mAddress = filter_var($_POST["address"], FILTER_SANITIZE_STRING);
//            $mType = filter_var($_POST["type"], FILTER_SANITIZE_STRING);
            $mCity = filter_var($_POST["city"], FILTER_SANITIZE_STRING);

            $result_insert = $this->Admin->save_marker(array('name' => $mName, 'address' => $mAddress, 'city' => $mCity, 'lat' => $mLat, 'lng' => $mLng));
            //$results = $mysqli->query("INSERT INTO markers (name, address, lat, lng, type) VALUES ('$mName','$mAddress',$mLat, $mLng, '$mType')");
            if (!$result_insert) {
                header('HTTP/1.1 500 Error: Could not create marker!');
                exit();
            } else {
                $this->remove_map_sess();
                $this->session->set_userdata(array('map' => $result_insert));
            }

            $output = '<h1 class="marker-heading">' . $mName . '</h1><p>' . $mAddress . '</p>';
            exit($output);
        }


################ Continue generating Map XML #################
//Create a new DOMDocument object
        $dom = new DOMDocument("1.0");
        $node = $dom->createElement("markers"); //Create new element node
        $parnode = $dom->appendChild($node); //make the node show up 
// Select all the rows in the markers table
//        $results = $mysqli->query("SELECT * FROM markers WHERE 1");
        $results = $this->Admin->check_markers();
        if (!$results) {
            header('HTTP/1.1 500 Error: Could not get markers!');
            exit();
        }

//set document header to text/xml
        header("Content-type: text/xml");

// Iterate through the rows, adding XML nodes for each
        //while ($obj = $results->fetch_object()) {
        foreach ($results as $key => $val) {

            $node = $dom->createElement("marker");
            $newnode = $parnode->appendChild($node);
            $newnode->setAttribute("name", $val['name']);
            $newnode->setAttribute("address", $val['address']);
            $newnode->setAttribute("lat", $val['lat']);
            $newnode->setAttribute("lng", $val['lng']);
            $newnode->setAttribute("city", $val['city']);
        }

        echo $dom->saveXML();
    }

    //save city start
    public function save_city() {
        //$postdata = sanitize_mix_post($_POST);
        $city_name = $this->input->post('city_name');
        //check the city name
        $check_city_name = $this->Admin->check_city_name($city_name);
        $result = $check_city_name;
        if ($check_city_name) {
            $city_description = $this->input->post('city_description');
            $map = $this->session->userdata('map'); //map is not required
            if (!$map) {
                $map = 0;
            }
            $sister_city = $this->session->userdata('sister_city'); //image is required
            if (!$sister_city) {
                echo 3;
            } else {
                $reg_date = date('Y-m-d H:i:s');
                $user_id = $this->session->userdata('info')['user_id'];

                $result = $this->Admin->save_add_city(array('city_name' => $city_name, 'city_description' => $city_description, 'marker_id' => $map,
                    'sister_image' => $sister_city, 'user_id' => $user_id, 'reg_date' => $reg_date));
                $this->remove_map_sess();
                echo $result;
            }
        } else {
            echo 2;
        }
    }

    public function update_city() {
        //$postdata = sanitize_mix_post($_POST);
        $city_name = $this->input->post('city_name');
        //check the city name
        $check_city_name = $this->Admin->check_city_name($city_name);
        $result = $check_city_name;
        if ($check_city_name) {
            $city_description = $this->input->post('city_description');
            $city_id = $this->input->post('city_id');
            $map = $this->session->userdata('map');
            if (!$map) {
                $map = 0;
            }
            $update = date('Y-m-d H:i:s');
            $user_id = $this->session->userdata('info')['user_id'];

            $result = $this->Admin->update_city(array('city_id' => $city_id, 'city_name' => $city_name,
                'city_description' => $city_description, 'marker_id' => $map,
                'last_updated_by' => $user_id, 'update_date' => $update));
            $this->remove_map_sess();
        }
        echo $result;
    }

    //save city end
    //unset map start
    public function remove_map_sess() {
        $map = $this->session->userdata('map');
        if ($map) {
            $this->session->unset_userdata('map');
        }
    }

    //unset map sister city image
    public function remove_sister_city_image_sess() {
        $sister_city = $this->session->userdata('sister_city');
        if ($sister_city) {
            $this->session->unset_userdata('sister_city');
        }
        $news_image = $this->session->userdata('news_image');
        if ($news_image) {
            $this->session->unset_userdata('news_image');
        }
    }

    //unset map end
    //report pdf sister cities
    public function report_pdf_cities() {
        $html = $this->display_cities_reports();
        $data = '    <table id="user_table" style="border: solid 1px black;" class="display" width="100%" cellspacing="0">
        <thead style="border: solid 1px black;" >
            <tr>
                <th style="border: solid 1px black;" >City Name</th>
                <th style="border: solid 1px black;" >Created By</th>
                <th style="border: solid 1px black;" >Registration Date</th>
                <th style="border: solid 1px black;" >Last Update By</th>                
                <th style="border: solid 1px black;" >Last Update Date</th>
                <th style="border: solid 1px black;" >Status</th>
            </tr>
        </thead>
        <tbody style="border: solid 1px black;" >';
        foreach ($html as $key => $val) {
            $active = $val['active'];
            $status = 'Inactive';

            if ($active == 1) {
                $status = 'Active';
            }
            $data .= '<tr>'
                    . '<td style="border: solid 1px black;" >'
                    . $val['city_name']
                    . '</td>'
                    . '<td style="border: solid 1px black;" >'
                    . $val['created_by']
                    . '</td>'
                    . '</td>'
                    . '<td style="border: solid 1px black;" >'
                    . $val['reg_date']
                    . '</td>'
                    . '<td style="border: solid 1px black;" >'
                    . $val['last_updated_by']
                    . '</td>'
                    . '<td style="border: solid 1px black;" >'
                    . $val['update_date']
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
        $filename = "List_of_Sister_cities_" . date('Y-m-d H:i:s');
        $this->load->helper(array('dompdf', 'file'));
        // page info here, db calls, etc.     
        //  $html ="testing";
        $data = pdf_create($data, $filename, true);
        write_file('name', $data);
    }
   //For export excel sister cities
    public function  report_excel_cities() {
        //load our new PHPExcel library
        $this->load->library('excel');
//        $this->load->library('PDF');
        //activate worksheet number 1
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('Sister Cities');
        //set cell A1 content with some text
        $this->excel->getActiveSheet()->setCellValue('A1', 'City Name');
        $this->excel->getActiveSheet()->setCellValue('B1', 'Created By');
        $this->excel->getActiveSheet()->setCellValue('C1', 'Registration Date');
        $this->excel->getActiveSheet()->setCellValue('D1', 'Last Update By');
        $this->excel->getActiveSheet()->setCellValue('E1', 'Last Update Date');
        $this->excel->getActiveSheet()->setCellValue('F1', 'Status');
        //change the font size
        $this->excel->getActiveSheet()->getStyle('A1:I1')->getFont()->setSize(12);
        //make the font become bold
        $this->excel->getActiveSheet()->getStyle('A1:I1')->getFont()->setBold(true);
        //data
        $result = $this->display_cities_reports();

        $ctr = 2;
        foreach ($result as $key => $val) {
            $active = $val['active'];
            $status = 'Inactive';
            if ($active == 1) {
                $status = 'Active';
            }
            $this->excel->getActiveSheet()->setCellValue('A' . $ctr, $val['city_name']);
            $this->excel->getActiveSheet()->setCellValue('B' . $ctr, $val['created_by']);
            $this->excel->getActiveSheet()->setCellValue('C' . $ctr, $val['reg_date']);
            $this->excel->getActiveSheet()->setCellValue('D' . $ctr, $val['last_updated_by']);
            $this->excel->getActiveSheet()->setCellValue('E' . $ctr, $val['update_date']);
            $this->excel->getActiveSheet()->setCellValue('F' . $ctr, $status);
            $ctr++;
        }


        //merge cell A1 until D1
//        $this->excel->getActiveSheet()->mergeCells('A1:D1');
        //set aligment to center for that merged cell (A1 to D1)
        $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $filename = "List_of_Sister_cities_" . date('Y-m-d H:i:s') . ".xls"; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
    }
    //report excel news
    public function report_excel_news() {
        //load our new PHPExcel library
        $this->load->library('excel');
//        $this->load->library('PDF');
        //activate worksheet number 1
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('News');
        //set cell A1 content with some text
        $this->excel->getActiveSheet()->setCellValue('A1', 'Title');
        $this->excel->getActiveSheet()->setCellValue('B1', 'Summary');
        $this->excel->getActiveSheet()->setCellValue('C1', 'Created By');
        $this->excel->getActiveSheet()->setCellValue('D1', 'News Date');
        $this->excel->getActiveSheet()->setCellValue('E1', 'Registration Date');
        $this->excel->getActiveSheet()->setCellValue('F1', 'Last Update Date');
        $this->excel->getActiveSheet()->setCellValue('G1', 'Last Update By');
        //change the font size
        $this->excel->getActiveSheet()->getStyle('A1:I1')->getFont()->setSize(12);
        //make the font become bold
        $this->excel->getActiveSheet()->getStyle('A1:I1')->getFont()->setBold(true);
        //data
        $result = $this->display_news_reports();

        $ctr = 2;
        foreach ($result as $key => $val) {
            $this->excel->getActiveSheet()->setCellValue('A' . $ctr, $val['news_title']);
            $this->excel->getActiveSheet()->setCellValue('B' . $ctr, $val['news_summary']);
            $this->excel->getActiveSheet()->setCellValue('C' . $ctr, $val['created_by']);
            $this->excel->getActiveSheet()->setCellValue('D' . $ctr, $val['news_date']);
            $this->excel->getActiveSheet()->setCellValue('E' . $ctr, $val['reg_date']);
            $this->excel->getActiveSheet()->setCellValue('F' . $ctr, $val['last_updated_by']);
            $this->excel->getActiveSheet()->setCellValue('G' . $ctr, $val['update_date']);
            $ctr++;
        }


        //merge cell A1 until D1
//        $this->excel->getActiveSheet()->mergeCells('A1:D1');
        //set aligment to center for that merged cell (A1 to D1)
        $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $filename = "List_of_News_" . date('Y-m-d H:i:s') . ".xls"; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
    }
    
    //report to pdf sister cities
    public function report_pdf_news() {
        $html = $this->display_news_reports();
        $data = '    <table id="user_table" style="border: solid 1px black;" class="display" width="100%" cellspacing="0">
        <thead style="border: solid 1px black;" >
            <tr>
                <th style="border: solid 1px black;" >Title</th>
                <th style="border: solid 1px black;" >Summary</th>
                <th style="border: solid 1px black;" >Created By</th>
                <th style="border: solid 1px black;" >News Date</th>                
                <th style="border: solid 1px black;" >Registration Date</th>
                <th style="border: solid 1px black;" >Last Update Date</th>
                <th style="border: solid 1px black;" >Last Update By</th>
            </tr>
        </thead>
        <tbody style="border: solid 1px black;" >';
        foreach ($html as $key => $val) {
            $data .= '<tr>'
                    . '<td style="border: solid 1px black;" >'
                    . $val['news_title']
                    . '</td>'
                    . '<td style="border: solid 1px black;" >'
                    . $val['news_summary']
                    . '</td>'
                    . '</td>'
                    . '<td style="border: solid 1px black;" >'
                    . $val['created_by']
                    . '</td>'
                    . '<td style="border: solid 1px black;" >'
                    . $val['news_date']
                    . '</td>'
                    . '<td style="border: solid 1px black;" >'
                    . $val['reg_date']
                    . '</td>'
                    . '<td style="border: solid 1px black;" >'
                    . $val['last_updated_by']
                    . '</td>'
                    . '<td style="border: solid 1px black;" >'
                    . $val['update_date']
                    . '</td>'

            ;
            $data .= '</tr>';
        }

        $data .= '</tbody>
    </table> ';
        //  die();
        $filename = "List_of_News_" . date('Y-m-d H:i:s');
        $this->load->helper(array('dompdf', 'file'));
        // page info here, db calls, etc.     
        //  $html ="testing";
        $data = pdf_create($data, $filename, true);
        write_file('name', $data);
    }

    //upload image
    public function image_uploading() {
        $this->common->upload_image_path();
    }

    public function get_sistercity_status() {
        try {
            $city_id = $this->input->post('city_id');
            if ($city_id) {
                $this->load->model('admin_model', 'Admin');

                $result = $this->Admin->view_sister_city($city_id);
            }
            echo json_encode($result);
        } catch (Exception $ex) {
            
        }
    }

    public function update_city_status() {
        $postdata = sanitize_mix_post($_POST);
        try {
            if (!empty($postdata)) {
                $this->load->model('admin_model', 'Admin');

                $is_saved = $this->Admin->update_city_status($postdata);

                print($is_saved);
            }
        } catch (Exception $e) {
            
        }
    }

//new images
    public function image_upload($param_image = null) {
        if ($this->session->userdata('info')['user_id'] == true) {
            $user_id = $this->session->userdata('info')['user_id'];
            $postdata = sanitize_mix_post($_POST);
            $image_param = $param_image;
            $upload_folder = 'news';
            $image_name = 'news_image';
            $input_name = "file2";
            $upload_image_name = 'News_';
            if ($image_param) {
                if ($image_param == 1) {
                    $upload_folder = 'cities';
                    $image_name = 'sister_city';
                    $input_name = "file";
                    $upload_image_name = 'Sister_city_';
                }
                if (isset($_FILES[$input_name]["type"])) {
                    $validextensions = array("jpeg", "jpg", "png");
                    $temporary = explode(".", $_FILES[$input_name]["name"]);
                    $file_extension = end($temporary);
                    $file_image = $_FILES[$input_name]["type"];
                    $file_size_image = $_FILES[$input_name]["size"];
                    if ((($file_image == "image/png") || ($file_image == "image/jpg") || ($file_image == "image/jpeg")
                            ) && ($file_size_image < 100000)//Approx. 100kb files can be uploaded.
                            && in_array($file_extension, $validextensions)) {

                        if ($_FILES[$input_name]["error"] > 0) {
                            echo "Return Code: " . $_FILES[$input_name]["error"] . "<br/><br/>";
                        } else {
//                        $file_name = $user_id . "_" . date('Y-m-d H-i-s');
                            $date_today = date("Y-m-d H:i:s");
                            $timestamp = strtotime($date_today);
                            $file_name = $upload_image_name . $timestamp;
                            $extension = end(explode('.', $_FILES[$input_name]['name']));
                            $finalfilename = $file_name . '.' . $extension;
                            $this->remove_sister_city_image_sess();
                            $this->session->set_userdata(array($image_name => $finalfilename));
                            $sess_image_name = $this->session->userdata($image_name);
                            if ($sess_image_name) {
                                //filename 
                                $sourcePath = $_FILES[$input_name]['tmp_name'];   // Storing source path of the file in a variable

                                $targetPath = "./bootstrap/$upload_folder/$finalfilename";  // Target path where file is to be stored

                                move_uploaded_file($sourcePath, $targetPath); //  Moving Uploaded file						

                                echo "<span id='success'>Image Uploaded Successfully...!!</span><br/>";
                                echo "<br/><b>File Name:</b> " . $finalfilename . "<br>";
                                echo "<b>Type:</b> " . $_FILES[$input_name]["type"] . "<br>";
                                echo "<b>Size:</b> " . ($_FILES[$input_name]["size"] / 1024) . " kB<br>";
                                echo "<b>Temp file:</b> " . $_FILES[$input_name]["tmp_name"] . "<br>";
                            } else {
                                echo "<span id='invalid'>Invalid Image<span>";
                            }
                            // }
                        }
                    } else {
                        echo "<span id='invalid'>Invalid file Size or Type<span>";
                    }
                }
            }
        }
    }

    //update image
    public function image_upload_update($param_image = null) {
        if ($this->session->userdata('info')['user_id'] == true) {
            $user_id = $this->session->userdata('info')['user_id'];
            $postdata = sanitize_mix_post($_POST);
            $image_param = $param_image;
            $upload_folder = 'news';
            $table = 'news';
            $field = 'news_img';
            $image_name = 'news_image';
            $input_name = "file_update2";
            $upload_image_name = 'News_';
            if ($image_param) {
                if ($image_param == 1) {
                    $upload_folder = 'cities';
                    $table = 'sister_cities';
                    $field = 'city_img';
                    $field_id = "city_id";
                    $id = $postdata['id_update'];
                    $where = "city_id = $id";
                    $image_name = 'sister_city';
                    $input_name = "file_update";
                    $upload_image_name = 'Sister_city_';
                } else {
                    $id = $postdata['id_update2'];
                    $field_id = "news_id";
                    $where = "news_id = $id";
                }

                if (isset($_FILES[$input_name]["type"])) {
                    $validextensions = array("jpeg", "jpg", "png");
                    $temporary = explode(".", $_FILES[$input_name]["name"]);
                    $file_extension = end($temporary);
                    $file_image = $_FILES[$input_name]["type"];
                    $file_size_image = $_FILES[$input_name]["size"];
                    if ((($file_image == "image/png") || ($file_image == "image/jpg") || ($file_image == "image/jpeg")
                            ) && ($file_size_image < 100000)//Approx. 100kb files can be uploaded.
                            && in_array($file_extension, $validextensions)) {

                        if ($_FILES[$input_name]["error"] > 0) {
                            echo "Return Code: " . $_FILES[$input_name]["error"] . "<br/><br/>";
                        } else {
//                        $file_name = $user_id . "_" . date('Y-m-d H-i-s');
                            $date_today = date("Y-m-d H:i:s");
                            $timestamp = strtotime($date_today);
                            $file_name = $upload_image_name . $timestamp;
                            $extension = end(explode('.', $_FILES[$input_name]['name']));
                            $finalfilename = $file_name . '.' . $extension;
                            //get img name 
                            $arr_get_img = array('table' => $table, 'field' => $field, 'where' => $where);
                            $image_name = $this->Admin->update_get_img($arr_get_img);
                            $path = $_SERVER['DOCUMENT_ROOT'] . "/iknowwelding/bootstrap/$upload_folder/" . $image_name;
                                //update image
                                $arr_image_update = array('field' => $field, 'table' => $table, 'img' => $finalfilename, 'id' => $id ,'id_field' => $field_id);
                                $update_image_name = $this->Admin->update_image($arr_image_update);
                                if ($update_image_name) {
                                    if ($image_name != null) {
                                        unlink($path);
                                     }
                                        //filename 
                                        $sourcePath = $_FILES[$input_name]['tmp_name'];   // Storing source path of the file in a variable

                                        $targetPath = "./bootstrap/$upload_folder/$finalfilename";  // Target path where file is to be stored

                                        move_uploaded_file($sourcePath, $targetPath); //  Moving Uploaded file						

                                        echo "<span id='success'>Image Uploaded Successfully...!!</span><br/>";
                                        echo "<br/><b>File Name:</b> " . $finalfilename . "<br>";
                                        echo "<b>Type:</b> " . $_FILES[$input_name]["type"] . "<br>";
                                        echo "<b>Size:</b> " . ($_FILES[$input_name]["size"] / 1024) . " kB<br>";
                                        echo "<b>Temp file:</b> " . $_FILES[$input_name]["tmp_name"] . "<br>";
                           
                                } else {
                                    echo "<span id='invalid'>Cannot Upload Image please contact the administrator<span>";
                                }
                        }
                    } else {
                        echo "<span id='invalid'>Invalid file Size or Type<span>";
                    }
                } else {
                    echo "<span id='invalid'>Invalid file Size or Type<span>";
                }
            }
        }
    }

    public function remove_sess() {
        $map = $this->session->userdata('map');
        if ($map) {
            $this->session->unset_userdata('map');
        }
        $sister_city = $this->session->userdata('sister_city');
        if ($sister_city) {
            $this->session->unset_userdata('sister_city');
        }
        $news_image = $this->session->userdata('news_image');
        if ($news_image) {
            $this->session->unset_userdata('news_image');
        }
    }

    public function save_news() {
        $title = $this->input->post('news_title');
        $bodytext = $this->input->post('body');
        $summary = $this->input->post('news_summary');
        $news_date = $this->input->post('news_date');
        $news_image = $this->session->userdata('news_image'); //image is not required
        if (!$news_image) {
            $news_image = null;
        }
        $reg_date = date('Y-m-d H:i:s');
        $user_id = $this->session->userdata('info')['user_id'];
        $data['result'] = $this->Admin->save_news(array('news_title' => $title, 'news_img' => $news_image, 'news_body' => $bodytext,
            'news_date' => $news_date, 'news_summary' => $summary, 'reg_date' => $reg_date, 'user_id' => $user_id));

        echo $data['result'];
    }

    public function update_news() {
        //$postdata = sanitize_mix_post($_POST);

        $news_id = $this->input->post('news_id');
        $news_title = $this->input->post('update_news_title');
        $news_summary = $this->input->post('update_news_summary');
        $news_date = $this->input->post('update_news_date');
        $news_body = $this->input->post('news_description');
        $update = date('Y-m-d H:i:s');
        $user_id = $this->session->userdata('info')['user_id'];

        $result = $this->Admin->update_news(array('news_id' => $news_id, 'news_title' => $news_title,
            'news_summary' => $news_summary, 'news_body' => $news_body, 'news_date' => $news_date,
            'last_updated_by' => $user_id, 'update_date' => $update));

        echo $result;
    }

}
