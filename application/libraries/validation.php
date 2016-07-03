<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * CodeIgniter validation Class
 *
 * This class aims to provide form validation for dynamic rules. 
 *
 * @author	lcapulla
 * 
 */
class validation {
    /* load form_validation library */

    function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->library('form_validation');
    }

    /* this will collate validation rules set by the developer and perform validation */

    public function validate_form($arr_validation_rules, $str_validation_rule_name) {
        if ($arr_validation_rules != '') {
            foreach ($arr_validation_rules as $key => $value) {
                if ($str_validation_rule_name == $key) {
                    foreach ($value as $index) { /* from the rules set, data will be transfered to set_rules function of Codeigniter */
                        $this->CI->form_validation->set_rules($index[0], $index[1], $index[2]);
                    }
                }
            }
            /* from the set_rules, CI will run the validation and returns result */
            if ($this->CI->form_validation->run() == FALSE) {
                $ret = FALSE;
            } else {
                $ret = TRUE;
            }
        } else {
            $ret = FALSE;
        }
        return $ret;
    }

    /* This function will perform regex validation and other form of validation such as range */

    public function overall_validation($input_str, $char_string, $min_range, $max_range, $function_name) {
        $overall_error_identifier = '';
        $count_char_exist = NUM_ZERO;
        /* Using preg_match function character will determine the difference from the character 
         * set by the developer and input from the user
         */
        if (!preg_match('/^[' . $char_string . ']*$/', $input_str)) { /* Error message will display */
            $regex_error_identifier = VALIDATION_ERROR_COMMON;
            $this->CI->form_validation->set_message($function_name, $regex_error_identifier);
            $overall_error_identifier .= $regex_error_identifier;
        } else {
            /* Validation for input (+447418740449). Determine + should be placed in front of the string */
            $input_value = $input_str;
            $cnt_input_value = strlen($input_value);
            $total_count = $cnt_input_value - ($cnt_input_value - 1);
            $first_char = substr($input_value, 0, $total_count);
            if ($first_char != '+') {
                $firstchar_error_identifier = VALIDATION_ERROR_COMMON;
                $this->CI->form_validation->set_message($function_name, $firstchar_error_identifier);
                $overall_error_identifier .= $firstchar_error_identifier;
            } else {
                /* Validation for input (+447418740449). Determine + it should be included on a string once */
                $arr_string_pieces = str_split($input_value);
                foreach ($arr_string_pieces as $char) {
                    if ($char == $first_char) {
                        $count_char_exist = $count_char_exist + 1;
                    }
                }
                if ($count_char_exist > 1) {
                    $char_exist_error_identifier = VALIDATION_ERROR_COMMON;
                    $this->CI->form_validation->set_message($function_name, $char_exist_error_identifier);
                    $overall_error_identifier .= $char_exist_error_identifier;
                } else {
                    if (is_numeric($input_value)) {
                        /* Validation for Range +447418740449 up to +447418790448 */
                        $min_value = str_replace("+", "", $min_range);
                        $max_value = str_replace("+", "", $max_range);
                        $min_value_trim = trim($min_value);
                        $max_value_trim = trim($max_value);

                        $input_data = str_replace("+", "", $input_value);
                        $input_data_trim = trim($input_data);


                        if (($input_data_trim >= $min_value_trim) && ($input_data_trim <= $max_value_trim)) {
                            ;
                        } else {
                            $range_error_identifier = VALIDATION_ERROR_MESSAGE_4;
                            $this->CI->form_validation->set_message($function_name, $range_error_identifier);
                            $overall_error_identifier .= $range_error_identifier;
                        }
                    } else {
                        $range_error_identifier = VALIDATION_ERROR_COMMON;
                        $this->CI->form_validation->set_message($function_name, VALIDATION_ERROR_MESSAGE_4);
                        $overall_error_identifier .= VALIDATION_ERROR_COMMON;
                    }
                }
            }
        }

        if ($overall_error_identifier === '') {
            $ret = TRUE;
        } else {
            $ret = FALSE;
        }
       return $ret;
    }

}

?>
