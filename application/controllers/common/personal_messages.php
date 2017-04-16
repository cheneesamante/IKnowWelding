<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Personal_messages extends CI_Controller {

    public function __construct() {
        //$this->load->helper('url');
        //$this->output->set_template('default');
        parent::__construct();
        // Your own constructor code
        $this->load->helper('url');
    }

    public function index() {
        $this->load->view('personal_messages');
    }

    public function process() {

        $function = $_POST['function'];

        $log = array();

        switch ($function) {

            case('getState'):
                $lines = "<span>Guest</span>Hello 
<span>Guest</span>What's up 
<span>Guest</span>akldj  
<span>Guest</span>    
<span>Guest</span> ";
                $log['state'] = count($lines);
                break;

            case('update'):
                $state = $_POST['state'];
                $lines = "<span>Guest</span>Hello 
<span>Guest</span>What's up 
<span>Guest</span>akldj  
<span>Guest</span>    
<span>Guest</span> ";
                $count = count($lines);
                                var_dump($state);
                var_dump($count);
                die();
                if ($state == $count) {
                    $log['state'] = $state;
                    $log['text'] = false;
                } else {
                    $text = array();
                    $log['state'] = $state + count($lines) - $state;
                    foreach ($lines as $line_num => $line) {
                        if ($line_num >= $state) {
                            $text[] = $line = str_replace("\n", "", $line);
                        }
                    }
                    $log['text'] = $text;
                }

                break;

            case('send'):
                $nickname = htmlentities(strip_tags($_POST['nickname']));
                $reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
                $message = htmlentities(strip_tags($_POST['message']));
                if (($message) != "\n") {

                    if (preg_match($reg_exUrl, $message, $url)) {
                        $message = preg_replace($reg_exUrl, '<a href="' . $url[0] . '" target="_blank">' . $url[0] . '</a>', $message);
                    }


//                    fwrite(fopen('chat.txt', 'a'), "<span>" . $nickname . "</span>" . $message = str_replace("\n", " ", $message) . "\n");
                }
                break;
        }

        echo json_encode($log);
    }

}

?>
