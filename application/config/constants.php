<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function get_base_url() {
   $url = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
   $base = explode("/index.php",$url);
   return $base[0];
}

// $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,strpos( $_SERVER["SERVER_PROTOCOL"],'/'))).'://';
define('CSS_PATH', get_base_url().'/assets/css/');
define('FONTS_PATH', get_base_url().'/assets/fonts/');
define('JS_PATH', get_base_url().'/assets/js/');
define('UPLOAD_IMG_PATH', get_base_url().'/assets/upload/');
define('CITY_IMG_PATH', get_base_url().'/assets/cities/'); // FOR Sister city upload
define('NEWS_IMG_PATH', get_base_url().'/assets/news/'); // FOR News upload
define('DEFAULT_IMG_PATH', get_base_url().'/assets/upload/default.png'); // For Default images


define('ADMIN_BOOTSTRAP_PATH', get_base_url().'/assets/admin/bootstrap/');
define('ADMIN_BUILD_PATH', get_base_url().'/assets/admin/build/');
define('ADMIN_DIST_PATH', get_base_url().'/assets/admin/dist/');
define('ADMIN_PLUGIN_PATH', get_base_url().'/assets/admin/plugins/');

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

define('WEBSITE_NAME', 'IknowWelding');
define('WEBSITE_EMAIL', 'info@iknowwelding.com');
define('BCC_EMAIL_RECIPIENTS', 'mfacto.tspi@gmail.com, asamante.tspi@gmail.com');

// Email Config
define('SITE_PROTOCOL', 'smtp');
define('SITE_HOST', 'ssl://smtp.gmail.com');
define('SITE_PORT', 465);
define('SITE_USER', 'mfacto.tspi@gmail.com');
define('SITE_PASS', 'michchelle14');
define('SITE_MAILTYPE', 'html');
define('SITE_CHARSET', 'iso-8859-1');
define('SITE_WORDWRAP', true);

/* End of file constants.php */

// Upload
define('ALLOW_TYPES', 'gif|jpg|png|docx|doc|jpeg|mp4'); 
define('MAX_SIZE', 102400); 
/* Location: ./application/config/constants.php */