<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Upload_files extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('common');
        $this->load->model('file_model');
    }

    public function index() {
        $this->load->view('upload');
    }

    public function upload() {
        $data = [];
        $uploadData = [];
        if ($this->input->post('fileSubmit') && !empty($_FILES['files']['name'])) {
            $filesCount = count($_FILES['files']['name']);
            for ($i = 0; $i < $filesCount; $i++) {
                $_FILES['userFile']['name'] = $_FILES['files']['name'][$i];
                $_FILES['userFile']['type'] = $_FILES['files']['type'][$i];
                $_FILES['userFile']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
                $_FILES['userFile']['error'] = $_FILES['files']['error'][$i];
                $_FILES['userFile']['size'] = $_FILES['files']['size'][$i];
                $fileType = explode("/", $_FILES['userFile']['type']);
//                $userId = $this->session->userdata()
                // TODO:  userid for naming the folder
                // create folder if not existing        
                $config['max_size'] = MAX_SIZE;
                if ($fileType[0] == "image") {
                    $uploadPath = 'uploads/images/';
                } else if ($fileType[0] == "video") {
                    $uploadPath = 'uploads/videos/';
                } else {
                    $uploadPath = 'uploads/files/';
                }
                $config['upload_path'] = $uploadPath;
                $config['allowed_types'] = ALLOW_TYPES;

                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if ($this->upload->do_upload('userFile') && $_FILES['userFile']['size'] <= $config['max_size']) {
                    $fileData = $this->upload->data();
                    $uploadData[$i]['file_name'] = $fileData['file_name'];
                    $uploadData[$i]['created'] = date("Y-m-d H:i:s");
                    $uploadData[$i]['modified'] = date("Y-m-d H:i:s");
                }
            }
            if (!empty($uploadData)) {
                //Insert file information into the database
                $insert = $this->file_model->insert($uploadData);
//                $this->session->set_flashdata('statusMsg', $statusMsg);
            }
            $data['message'] = isset($insert) ? 'Files uploaded successfully.' : 'Some problem occurred, please try again.';
            // Get files data from database
            $data['files'] = $this->file_model->getRows();
        }
        //Pass the files data to view
        $this->load->view('upload', $data);
    }

}
