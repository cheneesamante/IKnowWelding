<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Profile extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('common');
        $this->load->library('upload');
        $this->load->model('admin_model', 'Admin');
    }

    public function index() {
        if ($this->session->userdata('info')['user_id'] == true) {
            //get user
            $data['profile'] = $this->Admin->view_reg_user($this->session->userdata('info')['user_id']);
            $this->load->view('header_main');
            $this->load->view('profile',$data);
        } else {
            $data['menu'] = $this->common->_menu();
            $this->load->view('header', $data);
            $this->load->view('error_page_view');
        }
        $this->load->view('footer');
    }

    public function image_upload() {
        if ($this->session->userdata('info')['user_id'] == true) {
            $user_id = $this->session->userdata('info')['user_id'];
            if (isset($_FILES["file"]["type"])) {
                $validextensions = array("jpeg", "jpg", "png");
                $temporary = explode(".", $_FILES["file"]["name"]);
                $file_extension = end($temporary);

                if ((($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/jpg") || ($_FILES["file"]["type"] == "image/jpeg")
                        ) && ($_FILES["file"]["size"] < 100000)//Approx. 100kb files can be uploaded.
                        && in_array($file_extension, $validextensions)) {

                    if ($_FILES["file"]["error"] > 0) {
                        echo "Return Code: " . $_FILES["file"]["error"] . "<br/><br/>";
                    } else {
//                        $file_name = $user_id . "_" . date('Y-m-d H-i-s');
                        $file_name = $user_id;
                        $extension = end(explode('.', $_FILES['file']['name']));
                        $finalfilename = $file_name .'.'. $extension;
                       // if (file_exists("./bootstrap/upload/" . $finalfilename)) {
                       //     echo $_FILES["file"]["name"] . " <span id='invalid'><b>Already exists.</b></span> ";
                       // } else {
                            //update date base

                            $param_array = array('user_id' => $user_id,
                                'image' => $finalfilename);
                            if ($this->Admin->upload_image($param_array)) {
                                //filename 

                                $sourcePath = $_FILES['file']['tmp_name'];   // Storing source path of the file in a variable
                            
                                $targetPath = "./bootstrap/upload/$finalfilename" ;  // Target path where file is to be stored

                                move_uploaded_file($sourcePath, $targetPath); //  Moving Uploaded file						

                                echo "<span id='success'>Image Uploaded Successfully...!!</span><br/>";
                                echo "<br/><b>File Name:</b> " . $finalfilename . "<br>";
                                echo "<b>Type:</b> " . $_FILES["file"]["type"] . "<br>";
                                echo "<b>Size:</b> " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
                                echo "<b>Temp file:</b> " . $_FILES["file"]["tmp_name"] . "<br>";
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

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
