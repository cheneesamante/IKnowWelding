<?php

/**
* Sanitize data of multi dim array to single array
*/
if (!function_exists('sanitize_postdata')) 
{
    function sanitize_postdata($dim)
    {
        $sanitized_data = array();

        if($dim==1)
        {
            foreach ($_POST as $key => $value) {
                $var = '';
                $var = trim(htmlentities($value, ENT_QUOTES, 'UTF-8'));
                $sanitized_data[$key] = $var;
            }
        }
        elseif($dim==2)
        {
            foreach ($_POST as $row) {
                foreach ($row as $key => $value) {
                    $var = '';
                    $var = trim(htmlentities($value, ENT_QUOTES, 'UTF-8'));
                    $sanitized_data[$key] = $var;
                }
            }
        }
        elseif($dim==3)
        {
            foreach ($_POST as $row) {
                foreach ($_POST as $row_2) {
                    foreach ($row_2 as $key => $value) {
                        $var = '';
                        $var = trim(htmlentities($value, ENT_QUOTES, 'UTF-8'));
                        $sanitized_data[$key] = $var;
                    }
                }
            }
        }
        
        return $sanitized_data;
    }
}

/**
* Sanitize data of any post data (array,single val)
*/
if (!function_exists('sanitize_post')) 
{
    function sanitize_post($post_val)
    {
        if(is_array($post_val))
        {
            $sanitized_data = array();
            foreach ($post_val as $key => $value) {
                $var = trim(htmlentities($value, ENT_QUOTES, 'UTF-8'));
                $sanitized_data[$key] = $var;
            }
        }
        else
        {
            $sanitized_data = trim(htmlentities($post_val, ENT_QUOTES, 'UTF-8'));
        }
        return $sanitized_data;
    }
}

/**
* Sanitize data of mix post data (array,single val)
*/
if (!function_exists('sanitize_mix_post')) 
{
    function sanitize_mix_post($post_val)
    {
        if(is_array($post_val))
        {
            $sanitized_data = array();
            foreach ($post_val as $key => $value) {
                
                if (is_array($value))
                {
                    foreach($value as $key2 => $value2)
                    {
                        $var = trim(htmlentities($value2, ENT_QUOTES, 'UTF-8'));
                        $sanitized_data[$key][$key2] = $var;
                    }
                }
                else
                {
                    $var = trim(htmlentities($value, ENT_QUOTES, 'UTF-8'));    
                    $sanitized_data[$key] = $var;
                } 
            }
        }
        else
        {
            $sanitized_data = trim(htmlentities($post_val, ENT_QUOTES, 'UTF-8'));
        }
        return $sanitized_data;
    }
}