<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cms extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('common');
        $this->load->model('admin_model', 'Admin');
        $this->load->model('common_model');
        $this->load->library('encrypt');
    	$this->load->library('session');
        $user = $this->session->userdata('username');
        if(!$user){
        	redirect('admin/login');
        }
    }

    /* public function index() {
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
      } */

    public function index() {
        $this->load_view('cms_view');
    }

    private function load_view($view, $param = NULL) {
        $data['menu'] = $this->common_model->get_menu('ADMIN');
        $data['img'] = $this->session->userdata('img');
        $data['name'] = $this->session->userdata('account_name');
        $this->load->view('admin/header_main', $data);
        $this->load->view('admin/side_menu_view', $data);
        $this->load->view('admin/' . $view, $param);
        $this->load->view('admin/footer');
    }

    public function save() {
        $page_id = $this->input->post('page');
        $title = $this->input->post('title');
        $bodytext = $this->input->post('bodytext');
        $reg_date = date('Y-m-d H:i:s');
        $where = " AND page_id = $page_id ";
        if ($page_id == '0004') {
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
            $page = $this->encrypt->encode($page_id);
            $encoded = str_replace(array('+', '/', '='), array('-', '_', '~'), $page);
            $view = " <a href='" . site_url('admin/cms/view?page=' . $encoded) . "'><button type='button' data-toggle='modal' data-target='#largeModal-update-cms' class='btn btn-info update-reg' id='update-cms-" . $page_id . "'>View Info</button></a>";

            if ($active == 0) {
                $view .= " <button type='button' data-id='" . $page_id . "' data-action='active' data-status=1 data-toggle='modal' data-target='#largeModal-active-inactive' class='btn btn-success btn-update-status' id='update-active-inactive-" . $page_id . "'>Set to Active</button>";
                $in_active_label = 'Inactive';
            } elseif ($active == 1) {
                $view .= " <button type='button' data-id='" . $page_id . "' data-action='inactive' data-status=0 data-toggle='modal' data-target='#largeModal-active-inactive' class='btn btn-danger btn-update-status' id='update-active-inactive-" . $page_id . "'>Set to Inactive</button>";
                $in_active_label = 'Active';
            }
            $output['aaData'][] = array(
                $row['page_name'],
                $row['title'],
                $row['update_date'],
                $in_active_label,
                $row['ord'],
                $view
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

    public function view() {
        $data = array();
        if ($this->input->get('page') != NULL) {
            $page = str_replace(array('-', '_', '~'), array('+', '/', '='), $this->input->get('page'));
            $decoded = $this->encrypt->decode($page);
            $info = $this->Admin->get_cms(' cms_id = ' . $decoded);
            if ($info) {
                $data['cms'] = $info[0];
                $data['id'] = $this->input->get('page');
                $data['count'] = $this->Admin->count_cms()->total;
            }
        }

        $this->load_view('cms_info_view', $data);
    }

    public function update_page_status() {

        $postdata = sanitize_mix_post($_POST);
        $info = $this->Admin->get_cms(' cms_id = ' . $postdata["id"]);

        if (!empty($info)) {
            try {
                //missing: validation here
                $is_saved = $this->Admin->update_page_status($postdata);
                if ($is_saved) {

                    $return_info = array(
                        'status' => (boolean) $is_saved
                    );
                    echo json_encode($return_info);
                }
            } catch (Exception $e) {
                
            }
        }
    }

    public function update_page_info() {

        $postdata = sanitize_mix_post($_POST);
        $page = str_replace(array('-', '_', '~'), array('+', '/', '='), $postdata["id"]);
        $id = $this->encrypt->decode($page);

        $info = $this->Admin->get_cms(' cms_id = ' . $id);

        if (!empty($info)) {
            try {
                //missing: validation here
                $param = array(
                    'page_name' => $postdata['name'],
                    'title' => $postdata['title'],
                    'body' => $postdata['editor'],
                    'active' => $postdata['status'],
                    'cms_id' => $id,
                    'ord' => $postdata['order']
                );

                $is_saved = $this->Admin->update_page_info($param);
                if ($is_saved) {

                    $return_info = array(
                        'status' => (boolean) $is_saved
                    );
                    echo json_encode($return_info);
                }
            } catch (Exception $e) {
                
            }
        }
    }

}
