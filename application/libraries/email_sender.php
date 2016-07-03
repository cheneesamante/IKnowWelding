<?php if (!defined('APPPATH')) exit('No direct script access allowed');

class email_sender
{    
    public function __construct() {
        $this->CI =&get_instance();
        $this->CI->load->library('email');
		$this->CI->config->load('email');
    }
    
    public function send($sender='', $receiver='', $subject='', $email_template='', $search_str='', $email_values='',$from_template = TRUE)
    {
		$config = array(
            'protocol' => $this->CI->config->item('protocol'), // Mail Protocol
            'smtp_host' => $this->CI->config->item('smtp_host'), // SMTP host
            'port' => $this->CI->config->item('port'), // Port
            'smtp_timeout' => $this->CI->config->item('smtp_timeout'), // Timeout
            'mailtype' => $this->CI->config->item('mailtype'), // HTML mail type
            'charset' => $this->CI->config->item('charset'),  // Character set
            'validate' => $this->CI->config->item('validate'),  // Validate to false
            'smtp_user' => $this->CI->config->item('smtp_user'),  // Username / Email
            'smtp_pass' => $this->CI->config->item('smtp_pass')  // Password
        );
		
        $this->CI->email->initialize($config);
        $this->CI->email->from($sender, EMAIL_SENDER_NAME);
        $this->CI->email->to($receiver['to']);
        $this->CI->email->cc($receiver['cc']);
        $this->CI->email->bcc($receiver['bcc']);
        $this->CI->email->subject($subject);
 
        //compose body
        if ($from_template == TRUE)
        {
            $this->CI->email->message($this->compose_email_body($email_template, $search_str, $email_values));
        }
        else
        {
            $this->CI->email->message($email_template);
        }
       
        $this->CI->email->set_newline(EMAIL_NEWLINE);
        $this->CI->email->_replyto_flag = TRUE;
        $this->CI->email->set_crlf( "\r\n" );
        $is_sent = $this->CI->email->send();
		$response_ = false;
		$return_array = array();
        if($is_sent){
		 $response_ = $is_sent;    
		 $return_array['response'] = $response_;
		 $return_array['message'] =  '';
		}
		else {
		 $response_ = false;
		 $response_message = $this->CI->email->print_debugger();
		 $return_array['response'] = $response_;
		 $return_array['message'] =  $response_message;		 
		}

        return $return_array;
    }
    
    private function compose_email_body($email_template, $search_str, $values) {
        $replaced_mail_body = '';
        
        $current_directory = str_replace(LISTENER_SUFFIX,EMPTY_STRING,getcwd());
        $path = EMAIL_TEMPLATE_PATH;
        
        $file_exists = file_exists($current_directory.$path.$email_template);

        if ($file_exists) {
            $email_body_details = file_get_contents($current_directory.$path.$email_template);
            
            if ('' != $email_body_details) {
                $replaced_mail_body = str_replace($search_str, $values, $email_body_details);
            }
            else {
                //do nothing
            }
        }
        else {
            //do nothing
        }

        return $replaced_mail_body;
    }
}

?>
