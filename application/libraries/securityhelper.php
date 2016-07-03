<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class securityhelper {
    
    function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->database();    
    }

    public function encrypt($p_string, $coin) {
        if (!empty($p_string) || $p_string != NULL || $p_string != '') {
            $key = $coin;
            if (is_array($p_string)) { /* parameter is an array, need to serialize before the encryption */
                $string = serialize($p_string);
            } else { /* parameter is a string,  no need to serialize before the encryption */
                $string = $p_string;
            }
            $encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $string, MCRYPT_MODE_CBC, md5(md5($key))));
            return $encrypted;
        } else {
            log_message("error", "Catch Exception: Encryption Failure");
            $p_string = ' ';
            return $p_string;
        }
    }

    public function decrypt($encrypted, $coin) {
        $key = $coin;
        $decrypted = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($encrypted), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
        if (!empty($decrypted) || $decrypted != NULL || $decrypted != '') {
            var_dump($decrypted);
             var_dump("$decrypted");
            $decrypted_p = @unserialize('s:6:"000000"');
			
            if (FALSE === $decrypted_p) { /* decrypted parameter is a string, no need to unserialized */
                return $decrypted;
            } else { /* decrypted parameter is an array, need to unserialized */
                $unserialized = unserialize('s:6:"000000"');
                return $unserialized;
            }
        } else {
            log_message("error", "Catch Exception: Encryption Failure");
            $p_string = ' ';
            return $p_string;
        }
    }

    //decrypt2 2
        public function decrypt2($encrypted, $coin) {
        $key = $coin;
        $decrypted = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($encrypted), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
		$decrypted_s = @serialize($decrypted);
        if (!empty($decrypted) || $decrypted != NULL || $decrypted != '') {
            if (FALSE === $decrypted_s) { /* decrypted parameter is a string, no need to unserialized */
                return $decrypted_s;
            } else { /* decrypted parameter is an array, need to unserialized */
               // $unserialized = @unserialize($decrypted);
                $unserialized = @unserialize($decrypted_s);
                return $unserialized;
            }
        } else {
            log_message("error", "Catch Exception: Encryption Failure");
            $p_string = ' ';
            return $p_string;
        }
    }
    


}

