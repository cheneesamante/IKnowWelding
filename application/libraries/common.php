<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class common
{
    public function __construct()
    {
        $this->ci =& get_instance();
    }
    public function _pages_cms(){
        try {
            $arr_common =  array(
                                 //array('Makati Sister City Program','0001'),
 //                                array('Other Local Government','0002'),
//                                 array('City of Makati','0003'),
//                                 array('Makati Sister Cities','0004'),
                                 array('Makati Sisterhood Network','0004')); 
//                                 array('List of Makati Sisterhood','0005')); 
            
            return $arr_common;
        } catch (Exception $ex) {
            log_message("error", "Catch Exception:" . $ex->getMessage());
        } 
    }
    public function _get_page_name($param_page_name){
        try {
            $page_name = 'N/A';
            if($param_page_name == '0001'){
                $page_name = 'Makati Sister City Program';
            } elseif($param_page_name == '0002') {
                $page_name = 'Other Local Government';
            } elseif($param_page_name == '0003') {
                $page_name = 'City of Makati';
            } elseif($param_page_name == '0004') {
                $page_name = 'Makati Sisterhood Network';
            } elseif($param_page_name == '0005') {
                $page_name = 'List of Makati Sisterhood';
            }
            return $page_name;
        } catch (Exception $ex) {
            log_message("error", "Catch Exception:" . $ex->getMessage());
        } 
    }
    public function _get_view($param_user_type_id = null) {
        try {
            $result = 'home_view';
            if ($param_user_type_id != null) {
//                if ($param_user_type_id == ADMIN) {
//                    $result = "admin/home_view";
//                } elseif ($param_user_type_id == IRD_EMP || $param_user_type_id == SISTER_LGU) {
//                    $result = "ird/home_view";
//                }
                // I need a view here.
                
            } 
            return $result;
        } catch (Exception $ex) {
            log_message("error", "Catch Exception:" . $ex->getMessage());
        }
    }
    public function _menu($param_user_type_id = null){
        try {
            $arr_common =  array(array(PAGE_COMMON_COM,'common/pages/index/0003'),
                                 array(PAGE_COMMON_MSN,'common/pages/index/0004'),
				 array(PAGE_COMMON_SC,'common/sisterhood'),
                                 array(PAGE_COMMON_EVENTS,'common/events'),
				 array(PAGE_COMMON_NEWS,'common/news'),

                               ); 
            $arr_ird =  array(
                              array(PAGE_PRIVATE_ARCHIVES,'admin/private_archives'),
                              array(PAGE_MESSAGE,'common/message'),
                              array(PAGE_RESERVATION,'common/reservation'),           
                              array(PAGE_EVENT_ORGANIZER,'common/news_events'));            
            $arr_sister_city =  array(
                                     array(PAGE_MESSAGE,'common/message'),
                                     array(PAGE_RESERVATION,'common/reservation'),           
                                     array(PAGE_EVENT_ORGANIZER,'common/news_events'));            
            $arr_admin =  array(
                                array(PAGE_PRIVATE_ARCHIVES,'admin/private_archives'),
                                array(PAGE_MESSAGE,'common/message'),
                                array(PAGE_RESERVATION,'common/reservation'),
                                array(PAGE_EVENT_ORGANIZER,'common/news_events'),
                                array(PAGE_USERS,'admin/register'),
                                array(PAGE_CMS,'admin/cms'));    
            $result = array('up'=>$arr_common);
            if ($param_user_type_id != null) {
                if ($param_user_type_id == ADMIN) {
                    $result = array('who' => 'Admin',
                                    'up'=>$arr_common,
                                    'down'=> $arr_admin);
                } elseif ($param_user_type_id == IRD_EMP) {
                    $result = array('who' => 'IRD Employee',
                                    'up'=>$arr_common,
                                    'down'=> $arr_ird);
                } elseif ($param_user_type_id == SISTER_LGU) {
                    $result = array('who' => 'Sister LGU',
                                    'up'=>$arr_common,
                                    'down'=> $arr_sister_city);
                }
            } 
            return $result;
        } catch (Exception $ex) {
            log_message("error", "Catch Exception:" . $ex->getMessage());
        } 
    }    
   //check session
   public function check_session_info($param_name = null) {
        try {
            $result = false;
            if ($param_name != null) {
                if($this->ci->session->userdata('info')["$param_name"]) {
                    $result = $this->ci->session->userdata('info')[$param_name];
                }
            }
            return $result;
        } catch (Exception $ex) {
            
        }
    }
//upload image of editor
    public function upload_image_path(){
    // Allowed extentions.
    $allowedExts = array("gif", "jpeg", "jpg", "png");

    // Get filename.
    $temp = explode(".", $_FILES["file"]["name"]);

    // Get extension.
    $extension = end($temp);

    // An image check is being done in the editor but it is best to
    // check that again on the server side.
    // Do not use $_FILES["file"]["type"] as it can be easily forged.
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $_FILES["file"]["tmp_name"]);

    if ((($mime == "image/gif")
    || ($mime == "image/jpeg")
    || ($mime == "image/pjpeg")
    || ($mime == "image/x-png")
    || ($mime == "image/png"))
    && in_array($extension, $allowedExts)) {
        // Generate new random name.
        $name = sha1(microtime()) . "." . $extension;
                                $sourcePath = $_FILES['file']['tmp_name'];   // Storing source path of the file in a variable
                            
                                $targetPath = "./bootstrap/cities/$name" ;  // Target path where file is to be stored
 
        // Save file in the uploads folder, Moving Uploaded file	
         move_uploaded_file($sourcePath, $targetPath); // 

        // Generate response.
        $response = new StdClass;
        $response->link = base_url()."bootstrap/cities/" . $name;
        echo stripslashes(json_encode($response));
    }
    }

}
