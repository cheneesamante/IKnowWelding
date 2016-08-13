<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cms extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('common');
        $this->load->model('admin_model', 'Admin');
        $this->load->model('common_model');
    }

    /*public function index() {
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
    }*/
    
    public function index(){
    	$this->load_view('cms_view');
    }
    
    public function load_view($view){
    	$data['menu'] = $this->common_model->get_menu('ADMIN');
        $this->load->view('admin/header_main');
        $this->load->view('admin/side_menu_view', $data);
        $this->load->view('admin/'.$view);
        $this->load->view('admin/footer');
    
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

    public function getAllCMS() {

        $sEcho = $this->input->get_post('sEcho', true);

        $aColumns = array('page_name',
            'title',
            'update_date',
            'active_desc',
        );
        /*
         * Ordering
         */
        if (isset($_POST['iSortCol_0'])) {
            $sOrder = " ORDER BY ";
            for ($i = 0; $i < intval($_POST['iSortingCols']); $i++) {
                if ($_POST['bSortable_' . intval($_POST['iSortCol_' . $i])] == "true") {
                    $sOrder .= $aColumns[intval($_POST['iSortCol_' . $i])] . "
                            " . mysql_real_escape_string($_POST['sSortDir_' . $i]) . ", ";
                }
            }

            $sOrder = substr_replace($sOrder, "", -2);
            if ($sOrder == " ORDER BY ") {
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
        $sWhere = NULL;
        if ($_POST['sSearch'] != "") {
            $sWhere = " (";
            for ($i = 0; $i < count($aColumns); $i++) {
                if ($aColumns[$i] == 'active_desc') {
                    $sWhere .= "IF (active = 1, 'active', 'inactive')  LIKE '" . mysql_real_escape_string($_POST['sSearch']) . "%' OR ";
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
            $page_id = $row['cms_id'];
            $active = $row['active'];
            $edit = '<a href="'.site_url('admin/cms/view').'"><button type="button" onclick="javascript:update_cms("' . $page_id . '");" data-toggle="modal" data-target="#largeModal-update-cms" class="btn btn-info update-reg" id="update-cms-"' . $page_id . '">View Info</button>';
            if ($active == 0) {
                $in_active = "<button type='button' data-toggle='modal' data-target='#largeModal-active-inactive-cms' onclick='javascript:update_cms_status(" . $page_id . ");' class='btn btn-success update-active-inactive' id='update-active-inactive-" . $page_id . "'>Set to Active</button>";
                $in_active_label = 'Inactive';
            } elseif ($active == 1) {
                $in_active = "<button type='button' data-toggle='modal' data-target='#largeModal-active-inactive-cms' onclick='javascript:update_cms_status(" . $page_id . ");' class='btn btn-danger update-active-inactive' id='update-active-inactive-" . $page_id . "'>Set to Inactive</button>";
                $in_active_label = 'Active';
            }
            $output['aaData'][] = array(
                $row['page_name'],
                $row['title'],
                $row['update_date'],
                $in_active_label,
                $edit . ' ' .  $in_active 
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
    
    public function view(){
        $this->load_view('cms_info_view');
    }  

}
