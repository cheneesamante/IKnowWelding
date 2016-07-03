<?php

class Reservation_model extends CI_Model {

    public function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    public function check_reserve_date($reserve_date = null) {
        $data = null;

        if ($reserve_date != null) {

            $sql = 'SELECT *,(SELECT CONCAT(last_name, ", ", first_name, " ",middle_name) FROM 
user_info WHERE reservation.user_id = user_id
) AS reserve_by ,IFNULL((SELECT CONCAT(last_name, ", ", first_name, " ",middle_name) FROM 
user_info WHERE reservation.approved_id = user_id
),"N/A") AS approved_by 
FROM reservation WHERE reservation_date = ? ';
//            $sql = 'SELECT GROUP_CONCAT(reserve_id) AS reserve_id, GROUP_CONCAT(reservation_date) AS reservation_date,
//GROUP_CONCAT(reservation_name) AS reservation_name, GROUP_CONCAT(user_id) AS user_id,
//GROUP_CONCAT(approved_id) AS approved_id, GROUP_CONCAT(status) AS status,
//GROUP_CONCAT(reg_date) AS reg_date, GROUP_CONCAT(update_date) AS update_date,
//GROUP_CONCAT((SELECT CONCAT(last_name, ", ", first_name, " ",middle_name) FROM 
//user_info WHERE reservation.user_id = user_id
//)) AS reserve_by FROM reservation WHERE reservation_date = ? GROUP BY reservation_date';
            $qry = $this->db->query($sql, array($reserve_date));
            $data = array();

            if ($qry->num_rows() > 0) {
                $result = $qry->result_array();
                $data = $result;
            }
        }
        return $data;
    }

    public function save_reservation($param_array = array()) {
        if (count($param_array) > 0) {

            $data = array(
                'reservation_date' => $param_array['reserve_date'],
                'user_id' => $param_array['user_id'],
                'reservation_name' => $param_array['reserve_name'],
                'reservation_desc' => $param_array['reservation_desc'],
                'reg_date' => $param_array['reg_date'],
                'status' => $param_array['status_id'],
                'update_date' => $param_array['update_date'],
                'approved_id' => $param_array['approved_by']
            );

            $this->db->insert('reservation', $data);
        }
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function approve_reject_reservation($param_data = null) {
        try {
            $result_approve = null;
            if (null != $param_data or !empty($param_data)) {
                $approve_reservation = array(
                    'status' => $param_data['status_id'],
                    'update_date' => $param_data['update_date'],
                    'approved_id' => $param_data['approved_by']
                );

                $this->db->where('reservation_date', $param_data['reserve_date']);
                $this->db->where('reserve_id', $param_data['reserve_id']);
                $this->db->update('reservation', $approve_reservation);
                if ($this->db->affected_rows() > 0) {
                    $result_approve = true;
                }
            }
        } catch (Exception $e) {
            $result_approve = false;
        }

        return $result_approve;
    }
//reserve today
    public function _today_reserve()
    {
	        date_default_timezone_set('Asia/Manila');
        $info = array();
        $date =  date('Y-m-d');
        $sql = "SELECT *,(SELECT CONCAT(last_name, ', ', first_name, ' ',middle_name) FROM 
user_info WHERE reservation.user_id = user_id
) AS reserve_by ,IFNULL((SELECT CONCAT(last_name, ', ', first_name, ' ',middle_name) FROM 
user_info WHERE reservation.approved_id = user_id
),'N/A') AS approved_by 
FROM reservation WHERE reservation_date = '$date'";
        $query = $this->db->query($sql);

        $info = $query->result_array(); 
        //$data = $info[0];			

        return $info;
    }
//my reservation
    public function _my_reservation($user_id = null)
    {
        date_default_timezone_set('Asia/Manila');
        $info = array();
        $date =  date('m');
        $sql = "SELECT *, (SELECT CONCAT(last_name, ', ', first_name, ' ',middle_name) FROM 
user_info WHERE reservation.user_id = user_id
) AS reserve_by ,IFNULL((SELECT CONCAT(last_name, ', ', first_name, ' ',middle_name) FROM 
user_info WHERE reservation.approved_id = user_id
),'N/A') AS approved_by 
FROM reservation WHERE reservation.user_id = '$user_id' and month(reservation_date) = '$date'";
        $query = $this->db->query($sql);

        $info = $query->result_array(); 
        //$data = $info[0];			

        return $info;
    }
}

?>
