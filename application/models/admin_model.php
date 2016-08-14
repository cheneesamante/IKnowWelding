<?php
class Admin_model extends CI_Model {

    public function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    public function check_user($param_users_details = array()) {
                $data = null;
                $username_email = $param_users_details['username_email'];
                $password = $param_users_details['password'];

                if(count($param_users_details) > 0) {
                 
		$sql = 'SELECT * FROM user_info WHERE username = ? or email_address = ? AND password = ? LIMIT 0, 1';
		$qry = $this->db->query($sql, array($username_email, $username_email , md5($password)));
		$data = array();
		
		if($qry->num_rows() > 0) {
			$info = $qry->result_array(); 
                         $user_info = $info[0];
                unset($user_info['password']);
                         $data = $user_info;			
		}
                }
		return $data;
	}
    
    public function check_email_exists($email, $id = null) {


            $sql = 'SELECT * FROM user_info WHERE email_address = ?';
            $sql .= !is_null($id) ? " AND user_id != $id" : '';
                    
            $qry = $this->db->query($sql, $email);
            $data = FALSE;

            if($qry->num_rows() > 0) {
                return TRUE;		
            } else {
                return FALSE;
            }

            return $data;
    }    
    
    public function check_username_exists($username, $id = null) {


            $sql = 'SELECT * FROM user_info WHERE username = ?';
            $sql .= !is_null($id) ? " AND user_id != $id" : '';
            
            $qry = $this->db->query($sql, $username);
            $data = FALSE;

            if($qry->num_rows() > 0) {
                return TRUE;		
            } else {
                return FALSE;
            }
            return TRUE;
    }  
        
    public function get_cms($search = NULL, $order = NULL, $limit = NULL){
        $data = array();

        $sql = 'SELECT cms_id, page_name, title, ord, body, reg_date, update_date, active, '
                . 'IF (active = 1, "active", "inactive") as active_desc  '
                . 'FROM cms ';

        $sql .= !is_null($search) ? ' WHERE ' . $search:  "";
        //$sql .=!is_null($order) ? $order : "";
        $sql .=!is_null($limit) ? $limit : "";
        
        $qry = $this->db->query($sql);

        if ($qry->num_rows() > 0) {
            $info = $qry->result_array();
            $data = $info;
        }
        return $data;
    }
    
    public function count_cms($search = NULL){
        $data = array();

        $sql = 'SELECT count(*) as total FROM cms';
        $sql .= !is_null($search) ? $search:  "";

        $qry = $this->db->query($sql);

        if($qry->num_rows() > 0) {
            $info = $qry->row(); 
            $data = $info;			
        }
        return $data;
    }
    public function count_sister_cities($search = NULL) {
        $data = array();

        $sql = 'SELECT count(*) as total  FROM sister_cities city '
             . 'LEFT JOIN user_info user ON city.last_updated_by = user.user_id '
             . 'LEFT JOIN user_info created ON city.user_id = created.user_id ';
        $sql .=!is_null($search) ? $search : "";

        $qry = $this->db->query($sql);

        if ($qry->num_rows() > 0) {
            $info = $qry->row();
            $data = $info;
        }
        return $data;
    }
    
    public function save_cms($param_array= array()){
              if(count($param_array) > 0) {
               
	  $data = array(
                'page_id' => $param_array['page_id'],
                'title' => $param_array['title'],
                'body' => $param_array['body'],
                'active' => $param_array['active'],
                'reg_date' => $param_array['reg_date']
    );
    $this->db->insert('cms',$data);
              }
        return ($this->db->affected_rows() != 1) ? false : true;
    }
    
    public function view_users($search = NULL, $order = NULL, $limit = NULL){
                $data = array();
               
		$sql = 'SELECT user_id, username, email_address, first_name, last_name, middle_name, '
                        . 'DATE_FORMAT(birthdate, "%Y-%m-%d") as birthdate, gender, user_type_id, active, '
                        . 'IF (active = 1, "active", "inactive") as active_desc, '
                        . 'IF (user_type_id = 1, "Administrator", IF (user_type_id = 2, "IRD", "N/A")) '
                        . 'as user_type_desc  FROM user_info';
                
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
    
    public function count_users($search = NULL){
               $data = array();
               
		$sql = 'SELECT count(*) as total FROM user_info ';
                $sql .= !is_null($search) ? $search:  "";
                
		$qry = $this->db->query($sql);

		if($qry->num_rows() > 0) {
			$info = $qry->row(); 
                        $data = $info;			
		}
        	return $data;
    }   
    
    public function save_user($param_array = array()) {
        if (count($param_array) > 0) {
            // To be depricated and add server side validation
//
//            $data = array(
//                'username' => $param_array['username'],
//                'email_address' => $param_array['email_address'],
//                'first_name' => $param_array['first_name'],
//                'middle_name' => $param_array['middle_name'],
//                'last_name' => $param_array['last_name'],
//                'birthdate' => $param_array['birthdate'],
//                'gender' => $param_array['gender'],
//                'password' => $param_array['password'],
//                'user_type_id' => $param_array['user_type_id'],
//                'city_name' => $param_array['city_name'],
//                'reg_date' => date('Y-m-d H:i:s')
//            );
//            

            $this->db->insert('user_info', $param_array);
    }
        return ($this->db->affected_rows() != 1) ? false : true;
    }    

    public function view_cms($param_page = null){
               $data = array();
               if($param_page != null ){
                $sql = 'SELECT * FROM cms where active = 1 and page_id = ? order by reg_date desc limit 1';
		$qry = $this->db->query($sql, array($param_page));
		if($qry->num_rows() > 0) {
			$info = $qry->result_array(); 
                        $data = $info[0];			
		}
               }

        	return $data;
    }       

    //view each user
    public function view_reg_user($param_reg_id = null){
        $data = array();

        $sql = 'SELECT user_id,user_type_id, username, email_address, city_name,'
                . ' first_name, middle_name, last_name, birthdate, gender, active, image FROM user_info where user_id = ? limit 1';

		$qry = $this->db->query($sql, array($param_reg_id));
		if($qry->num_rows() > 0) {
			$info = $qry->result_array(); 
                        $data = $info[0];			
		}
        return $data;
    }

   public function update_user_info($param_data = null){
      try {
		    $result_user_info = null;
		    if(null != $param_data or !empty($param_data)){
	            $user_info = array(
                    'user_type_id' => $param_data['page_id'],
                    'username' => $param_data['upd_username'],
                    'email_address' =>  $param_data['upd_email_address'],
                    'first_name' =>  $param_data['upd_first_name'],					
                    'middle_name' =>  $param_data['upd_middle_name'],					
                    'last_name' =>  $param_data['upd_last_name'],					
                    'birthdate' =>  $param_data['upd_birth_date'],
                    'gender' => $param_data['gender_id'],
                    'update_date' =>  date('Y-m-d H:i:s')
                );

			$this->db->where('user_id', $param_data['user_id']);
		        $this->db->update('user_info', $user_info); 

		        if($this->db->affected_rows() > 0) {
			        $result_user_info = true;			
		        }		
            }
        } catch (Exception $e) {
            $result_user_info = false;
        }
		
        return $result_user_info;
    }

    public function update_user_info2($param_data = null) {
        try {
            $result_user_info = null;
            if (null != $param_data or !empty($param_data)) {
                $user_info = array(
                    'username' => $param_data['username'],
                    'email_address' => $param_data['email_address'],
                    'first_name' => $param_data['first_name'],
                    'middle_name' => $param_data['middle_name'],
                    'last_name' => $param_data['last_name'],
                    'birthdate' => $param_data['birth_date'],
                    'gender' => $param_data['gender_id'],
                    'update_date' => date('Y-m-d H:i:s')
                );

                $this->db->where('user_id', $param_data['user_id']);
                $this->db->update('user_info', $user_info);

                if ($this->db->affected_rows() > 0) {
                    $result_user_info = true;
			}	   
		}
        } catch (Exception $e) {
		           $result_user_info = false;
		}
		
		return $result_user_info;
   }

   public function update_user_status($param_data = null){
      try {
		    $result_user_info = null;
		    if(null != $param_data or !empty($param_data)){
	            $user_info = array(
                    'active' => $param_data['action'],					
                    'update_date' =>  date('Y-m-d H:i:s')
                );

			$this->db->where('user_id', $param_data['user_id']);
		        $this->db->update('user_info', $user_info); 
		        if($this->db->affected_rows() > 0) {
			        $result_user_info = true;			
		        }		
		}
        } catch (Exception $e) {
		           $result_user_info = false;
		}
		
		return $result_user_info;
   }

   //view each cms
    public function view_page($param_page_id = null){
        $data = array();

        $sql = 'SELECT * FROM cms where cms_id = ?';

		$qry = $this->db->query($sql, array($param_page_id));
		if($qry->num_rows() > 0) {
			$info = $qry->result_array(); 
                        $data = $info[0];			
		}
        return $data;
    }
    
    //update page cms
   public function update_page_info($param_data = null){
      try {
		    $result_cms = null;
		    if(null != $param_data or !empty($param_data)){
                    $today = date("Y-m-d H:i:s");  
	            $cms_info = array(
                    'title' => $param_data['title'],
                    'body' => html_entity_decode($param_data['body']),
                    'update_date' =>  $today
                );

			$this->db->where('cms_id', $param_data['cms_id']);
		        $this->db->update('cms', $cms_info); 
		        if($this->db->affected_rows() > 0) {
			   $result_cms = true;			
		        }		
			}	   
        } catch (Exception $e) {
		           $result_cms = false;
		}
		
		return $result_cms;
   }    

   public function update_page_status($param_data = null){
      try {
		    $result_user_info = null;
		    if(null != $param_data or !empty($param_data)){
	            $user_info = array(
                    'active' => $param_data['action'],					
                    'update_date' =>  date('Y-m-d H:i:s')
                );

			$this->db->where('cms_id', $param_data['cms_id']);
		        $this->db->update('cms', $user_info); 
		        if($this->db->affected_rows() > 0) {
			        $result_user_info = true;			
		        }		
			}	   
        } catch (Exception $e) {
		           $result_user_info = false;
		}
		
		return $result_user_info;
   }
   
   public function reset_user_password($param_data = null){
      try {
        $result_user_info = null;
        if(null != $param_data or !empty($param_data)){
            $user_info = array(
                'password' => $param_data['password'],
            );

            $this->db->where('user_id', $param_data['user_id']);
            $this->db->update('user_info', $user_info); 
            if($this->db->affected_rows() > 0) {
                    $result_user_info = true;			
            }		
        }	   
        } catch (Exception $e) {
               $result_user_info = false;
    }

    return $result_user_info;
   }

   //upload image name
 public function upload_image($param_data = null){
      try {
		    $result_user_info = null;
		    if(null != $param_data or !empty($param_data)){
	            $user_info = array(
                    'image' => $param_data['image'],					
                    'update_date' =>  date('Y-m-d H:i:s')
                );

			$this->db->where('user_id', $param_data['user_id']);
		        $this->db->update('user_info', $user_info); 
		        if($this->db->affected_rows() > 0) {
			        $result_user_info = true;			
		        }		
            }
        } catch (Exception $e) {
            $result_user_info = false;
        }

        return $result_user_info;
    }
		
    //view each cms   
    //update password start
    public function update_password($param_data = null) {
        try {
            $result_user_info = null;
            if (null != $param_data or !empty($param_data)) {
                $user_info = array(
                    'password' => $param_data['password'],
                    'update_date' => date('Y-m-d H:i:s')
                );

                $this->db->where('user_id', $param_data['user_id']);
                $this->db->update('user_info', $user_info);

                if ($this->db->affected_rows() > 0) {
                    $result_user_info = true;
			}	   
		}
        } catch (Exception $e) {
		           $result_user_info = false;
		}
		
		return $result_user_info;
   }

    //update password end
    //check password
    public function check_password($param_reg_id = null) {
        $data = array();
        $sql = 'SELECT password from user_info where user_id = ? limit 1';

        $qry = $this->db->query($sql, array($param_reg_id));
        if ($qry->num_rows() > 0) {
            $info = $qry->result_array();
            $data = $info[0];
        }
        return $data;
    }


    //save file name path
    public function save_file($param_data = null) {
        try {
            $result_file = null;
            if (count($param_data) > 0) {

            $data = array(
                'file_name' => $param_data['file_name'],
                'user_id' => $param_data['user_id'],
                'reg_date' => $param_data['reg_date']
            );
            $this->db->insert('archives', $data);
               }
          return ($this->db->affected_rows() != 1) ? false : true;
        
        } catch (Exception $e) {
            return false;
        }


    }        

      public function update_get_img($param_array = null) {
        $data = null;
        
        if($param_array != null) {
        $field = $param_array['field'];
        $table = $param_array['table'];
        $where = $param_array['where'];
        $sql = "SELECT $field as img FROM $table where $where";

        $qry = $this->db->query($sql);

        if ($qry->num_rows() > 0) {
             $info = $qry->row();
            $data = $info->img;
         }
        }
        return $data;
    }
        public function update_image($param_array = array()) {
        if (count($param_array) > 0) {

            $data = array(
                $param_array['field'] => $param_array['img']
            );
            
            $this->db->where($param_array['id_field'], $param_array['id']);
            $this->db->update($param_array['table'], $data);
        }
    
        $result_id = ($this->db->affected_rows() != 1) ? false :
                true;
        return $result_id;
    }

    
}
?>
