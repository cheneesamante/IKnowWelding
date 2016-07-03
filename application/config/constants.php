<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function get_base_url() {
   $url = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
   $base = explode("/index.php",$url);
   return $base[0];
}

// $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,strpos( $_SERVER["SERVER_PROTOCOL"],'/'))).'://';
define('CSS_PATH', get_base_url().'/bootstrap/css/');
define('JS_PATH', get_base_url().'/bootstrap/js/');
define('UPLOAD_IMG_PATH', get_base_url().'/bootstrap/upload/');
define('CITY_IMG_PATH', get_base_url().'/bootstrap/cities/'); // FOR Sister city upload
define('NEWS_IMG_PATH', get_base_url().'/bootstrap/news/'); // FOR News upload
define('DEFAULT_IMG_PATH', get_base_url().'/bootstrap/upload/default.png'); // For Default images
// define('JS_PATH',  'http://makatisisterhood.com/bootstrap/js/');
//define('JS_PATH',  base_url().'/bootstrap/js/');


/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');

//user types 
define('ADMIN', 1);
define('IRD_EMP', 2);
define('SISTER_LGU', 3);

//message_limit_display
define('MSG_DISP_LIMIT', 10);

//Pages name
//common pages
define('PAGE_COMMON_COM', 'City of Makati');
define('PAGE_COMMON_MSN', 'Makati Network');
define('PAGE_COMMON_SC', 'Sister Cities');
define('PAGE_COMMON_EVENTS', 'Events');
define('PAGE_COMMON_NEWS', 'News');
//Admin, IRD Emp, Sister LGU
define('PAGE_PRIVATE_ARCHIVES', 'Private Archives');
define('PAGE_MESSAGE', 'Messages');
define('PAGE_RESERVATION', 'Reservation');
define('PAGE_EVENT_ORGANIZER', 'Event Organizer');
define('PAGE_USERS', 'Users');
define('PAGE_CMS', 'Content Management System');


/* End of file constants.php */
/* Location: ./application/config/constants.php */
