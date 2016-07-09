<?php

class Common_model extends CI_Model {

    public function __construct() {
        // Call the Model constructor
        parent::__construct();
    }
	
	public function get_menu($category = NULL){
		$data = false;
		try{
            $sql = 'SELECT * FROM menu';
			if(!is_null($category)){
				$sql .= " WHERE category = '".$category."'";
			}
            $sql .= " ORDER BY ord";
            
            $qry = $this->db->query($sql);
            if ($qry->num_rows() > 0) {
                $data = $qry->result_array();			
			}
			
			return $data;
		} catch (Exception $ex) {
			return $data;
		}
	}

    public function check_datetime($param_event_time = null, $param_user_id = null) {
       $data = false;
       try{
            $sql = 'SELECT event_datetime FROM events where event_datetime = ? and user_id = ?';

            $qry = $this->db->query($sql, array($param_event_time, $param_user_id));
            if ($qry->num_rows() > 0) {
                        $data = true;			
		}
        return $data;
       } catch (Exception $ex) {

       }
   }

 public function save_event($param_array = array()) {
        if (count($param_array) > 0) {

            $data = array(
                'event_name' => $param_array['event_name'],
                'event_datetime' => $param_array['event_datetime'],
                'event_desc' => $param_array['event_desc'],
                'user_id' => $param_array['user_id'],
                'reg_date' => $param_array['reg_date'],
                'update_date' => $param_array['update_date']
            );
            

            $this->db->insert('events', $data);
    }
        return ($this->db->affected_rows() != 1) ? false : true;
    }       

   //view each cms
    public function view_events(){
        $data = array();

        $sql = 'SELECT event_name as title, event_datetime as start, event_id, user_id,'
                . '  (SELECT city_name FROM user_info WHERE user_info.user_id = events.user_id LIMIT 1) AS city_name,'
                . 'IFNULL((SELECT CONCAT(last_name, ", ", first_name, " ",middle_name) FROM 
user_info WHERE events.user_id = user_info.user_id LIMIT 1
),"N/A") AS reg_by, DATE_FORMAT(reg_date,"%M-%d-%Y %h:%i:%p") AS reg_date, event_desc ' 
                . ' FROM events where status = 1';

		$qry = $this->db->query($sql);
		if($qry->num_rows() > 0) {
			$data = $qry->result_array(); 			
		}
        return $data;
    }
    
    //update event
    public function update_event($param_data = null){
      try {
		    $result_event = null;
		    if(null != $param_data or !empty($param_data)){
                    $data = array(
                    'event_name' => $param_data['event_name'],
                    'event_datetime' => $param_data['event_datetime'],
                    'update_id' => $param_data['update_id'],
                    'event_desc' => $param_data['event_desc'],
                    'update_date' => $param_data['update_date']
                   );

			$this->db->where('event_id', $param_data['event_id']);
		        $this->db->update('events', $data); 
		        if($this->db->affected_rows() > 0) {
			        $result_event = true;			
		        }		
		}
        } catch (Exception $e) {
		           $result_event = false;
		}
		
		return $result_event;
   }

    public function delete_event($param_data = null){
      try {
		    $result_event = null;
		    if(null != $param_data or !empty($param_data)){
                    $data = array(
                    'event_datetime' => $param_data['event_datetime'],
                    'update_id' => $param_data['update_id'],
                    'update_date' => $param_data['update_date'],
                     'status' => 0
                   );

			$this->db->where('event_id', $param_data['event_id']);
		        $this->db->update('events', $data); 
                        
		        if($this->db->affected_rows() > 0) {
			        $result_event = true;			
		        }		
		}
        } catch (Exception $e) {
		           $result_event = false;
		}
		
		return $result_event;
   }

    //events
    public function view_events_list($search = NULL, $order = NULL, $limit = NULL) {
                $data = array();
               
		$sql = 'SELECT DATE_FORMAT(reg_date,"%M-%d-%Y %h:%i:%p") AS reg_date,DATE_FORMAT(update_date,"%M-%d-%Y %h:%i:%p") AS update_date, event_id, event_name, DATE_FORMAT(event_datetime,"%M-%d-%Y") AS event_date, DATE_FORMAT(event_datetime,"%h:%i:%p") AS event_time,
IFNULL((SELECT CONCAT(last_name, ", ", first_name, " ",middle_name) FROM 
user_info WHERE events.user_id = user_id LIMIT 1
),"N/A") AS reg_by,
IFNULL((SELECT CONCAT(last_name, ", ", first_name, " ",middle_name) FROM 
user_info WHERE events.user_id = update_id LIMIT 1
),"N/A") AS update_by, status FROM events';
                
                $sql .= !is_null($search) ? $search:  "";
                $sql .= !is_null($order) ? $order:  "";
                $sql .= !is_null($limit) ? $limit:  "";

		$qry = $this->db->query($sql);

		if($qry->num_rows() > 0) {
			$info = $qry->result_array(); 
                         $data = $info;			
		}
        	return $data;
    }    

    public function count_private($search = NULL){
               $data = array();
               
        $sql = 'SELECT count(*) as total FROM archives';
                $sql .= !is_null($search) ? $search:  "";
                
		$qry = $this->db->query($sql);

		if($qry->num_rows() > 0) {
			$info = $qry->row(); 
                        $data = $info;			
		}
        	return $data;
    }   

    //dashboard members activity
    //recent sent message start
    public function _members_activity() {
        $info = array();

        $sql = 'SELECT * FROM user_info ORDER BY update_date DESC LIMIT 5;';

        $query = $this->db->query($sql);

        $info = $query->result_array(); 
        //$data = $info[0];			

        return $info;
    }

//recent sent message end
    //private archives
    public function view_private($search = NULL, $order = NULL, $limit = NULL) {
        $data = array();

        $sql = 'SELECT DATE_FORMAT(reg_date,"%M-%d-%Y %h:%i:%p") AS reg_date,file_name,
IFNULL((SELECT CONCAT(last_name, ", ", first_name, " ",middle_name) FROM 
user_info WHERE archives.user_id = user_id LIMIT 1
),"N/A") AS uploaded_by, file_id FROM archives';

        $sql .=!is_null($search) ? $search : "";
        $sql .=!is_null($order) ? $order : "";
        $sql .=!is_null($limit) ? $limit : "";

        $qry = $this->db->query($sql);

        if ($qry->num_rows() > 0) {
            $info = $qry->result_array();
            $data = $info;
        }
        return $data;
    }

    //Count User based on pass user_type_id start
    public function _count_user($param_user_type_id = null) {

        $info = 0;

        $sql = 'SELECT COUNT(user_id) AS cnt FROM user_info WHERE user_type_id = ? LIMIT 1;';

        $query = $this->db->query($sql, array($param_user_type_id));

        $info = $query->row();
        return $info->cnt;
    }
    
//Count User based on pass user_type_id end    

	public function count_sistercities() {

        $info = 0;

        $sql = 'SELECT COUNT(city_id) AS total_cities FROM sister_cities WHERE active = 1 LIMIT 1 ';

        $query = $this->db->query($sql);

        $info = $query->row();
        return $info->cnt;
    }
	
	
    public function get_sister_cities_information() {

        $data = array();

        $sql = 'SELECT * FROM sister_cities LEFT JOIN markers 
		ON sister_cities.marker_id = markers.id where active = 1';

        $query = $this->db->query($sql);

		if($query->num_rows() > 0) {
			$info = $query->result_array();
            $data = $info;			
		}
        	return $data;
    }

    public function get_news_information() {

        $data = array();

        $sql = 'SELECT * FROM news where YEAR(news_date) = YEAR(NOW())
                    AND MONTH(news_date) = MONTH(NOW()) ORDER BY news_date DESC ';

        $query = $this->db->query($sql);

        if($query->num_rows() > 0) {
            $info = $query->result_array();
            $data = $info;			
        }
        return $data;
    }
    
    public function get_sisterhood_network_information() {

        $data = array();

        $sql = 'SELECT * FROM cms where active = 1 and page_id = "0004"  ';

        $query = $this->db->query($sql);

        if($query->num_rows() > 0) {
            $info = $query->result_array();
            $data = $info;
        }
        return $data;
    }
    
}

?>
