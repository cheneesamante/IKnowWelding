<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Users extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('common');
        $this->load->model('common_model');
        $this->load->model('users_model', 'Users');
        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.gmail.com',
            'smtp_port' => 465,
            'smtp_user' => 'mfacto.tspi@gmail.com', // change it to yours
            'smtp_pass' => 'michchelle14', // change it to yours
            'mailtype' => 'html',
            'charset' => 'iso-8859-1',
            'wordwrap' => TRUE
        );
        $this->load->library('email', $config);
    }

    public function index() {
        $this->load_view('users_view');
    }

    public function getAllUsers() {

        $sEcho = $this->input->get_post('sEcho', true);

        $aColumns = array('username',
            'email_address',
            'first_name',
            'last_name'
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

        $result = $this->Users->view_users($sWhere, $sOrder, $sLimit);
        $iTotal = $this->Users->count_users($sWhere)->total;
        $output = array(
            'sEcho' => intval($sEcho),
            'iTotalRecords' => $iTotal,
            'iTotalDisplayRecords' => $iTotal,
            'aaData' => array()
        );

        foreach ($result as $row) {

            $view = '<a href="' . site_url('admin/users/view') . '"><button class="btn btn-info" type="submit">View Info</button></a>';
            $view .= " <button type='button' data-id='" . $row['user_id'] . "'  data-toggle='modal' data-target='#largeModal-reset' class='btn-reset btn btn-danger' id='reset-pwd-" . $row['user_id'] . "'>Reset password</button>";

            switch ($row['active']) {
                case 0:
                    $view .= " <button type='button' data-id='" . $row['user_id'] . "' data-action='approve' data-status=1 data-toggle='modal' data-target='#largeModal-active-inactive' class='btn btn-success btn-update-status' id='update-active-inactive-" . $row['user_id'] . "'>Approve</button>";
                    $in_active_label = 'Pending';
                    break;
                case 1:
                    $in_active_label = 'Active';
                    $view .= " <button type='button' data-id='" . $row['user_id'] . "' data-action='deactivate' data-status=2 data-toggle='modal' data-target='#largeModal-active-inactive' class='btn btn-warning btn-update-status' id='update-active-inactive-" . $row['user_id'] . "'>Deactivate</button>";
                    break;
                case 2:
                    $in_active_label = 'Deactivate';
                    $view .= " <button type='button' data-id='" . $row['user_id'] . "' data-action='reactivate' data-status=1 data-toggle='modal' data-target='#largeModal-active-inactive' class='btn btn-success btn-update-status' id='update-active-inactive-" . $row['user_id'] . "'>Reactivate</button>";
                default:
                    break;
            }

            $output['aaData'][] = array(
                $row['email_address'],
                $row['first_name'],
                $row['last_name'],
                $in_active_label,
                $row['reg_date'],
                $view
            );
        }
        echo json_encode($output);
    }

    public function update_user_status() {
        $postdata = sanitize_mix_post($_POST);
        $info = $this->Users->get_user_info($postdata['id']);
        $subject = 'Account Deactivation';
        $extra_message = "deactivated. Please contact the administrator. ";

        if ($postdata['status'] == 1) {
            $subject = 'Account Activation';
            $extra_message = "activated. You may now login to " . base_url() . " ";
        }

        if (!empty($info)) {
            try {
                //missing: validation here
                $is_saved = $this->Users->update_user_status($postdata);
                if ($is_saved) {

                    //Email sending
                    $data['first_name'] = $info->first_name;
                    $data['message'] = $extra_message;
                    $message = $this->load->view('admin/email/update_account_status', $data, TRUE);

                    $this->email->set_newline("\r\n");
                    $this->email->from(WEBSITE_EMAIL); // change it to yours
                    $this->email->to($info->email_address); // change it to yours
                    $this->email->bcc(BCC_EMAIL_RECIPIENTS); // change it to yours
                    $this->email->subject(WEBSITE_NAME . " $subject"); //Need to put in constants
                    $this->email->message($message);

                    if ($this->email->send()) {
                        $data['email'] = true;
                    } else {
                        show_error($this->email->print_debugger());
                    }


                    $return_info = array(
                        'status' => (boolean) $is_saved
                    );
                    echo json_encode($return_info);
                }
            } catch (Exception $e) {
                
            }
        }
    }

    public function reset_password() {
        $password = $this->create_password();
        $postdata = sanitize_mix_post($_POST);
        $info = array(
            'password' => $password['encrypt'],
            'user_id' => $postdata['user_id']
        );

        $user = $this->Users->get_user_info($postdata['user_id']);
        $subject = 'Password Reset';
        try {
            //missing: validation here
            if (!empty($postdata) && !empty($user)) {
                $is_saved = $this->Users->reset_user_password($info);
                $data['first_name'] = $user->first_name;
                $data['password'] = $password['text'];
                //Email sending

                $message = $this->load->view('admin/email/reset_password', $data, TRUE);

                $this->email->set_newline("\r\n");
                $this->email->from(WEBSITE_EMAIL); // change it to yours
                $this->email->to($user->email_address); // change it to yours
                $this->email->bcc(BCC_EMAIL_RECIPIENTS); // change it to yours
                $this->email->subject(WEBSITE_NAME . " $subject"); //Need to put in constants
                $this->email->message($message);

                if ($this->email->send()) {
                    $data['email'] = true;
                } else {
                    show_error($this->email->print_debugger());
                }
                //end
                $return_info = array(
                    'status' => (boolean) $is_saved,
                    'email' => $user->email_address
                );
                echo json_encode($return_info);
            }
        } catch (Exception $e) {
            
        }
    }

    private function create_password() {
        $length = 8;
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $password = substr(str_shuffle($chars), 0, $length);
        $password_md5 = md5($password);
        $data_password = array('encrypt' => $password_md5,
            'text' => $password);
        return $data_password;
    }

    public function view() {
        $this->load_view('user_info_view');
    }

    public function load_view($view) {
        $data['menu'] = $this->common_model->get_menu('ADMIN');
        $this->load->view('admin/header_main');
        $this->load->view('admin/side_menu_view', $data);
        $this->load->view('admin/' . $view);
        $this->load->view('admin/footer');
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
