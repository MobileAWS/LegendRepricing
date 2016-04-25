<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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
// Amazon glibal settigns
define ('DATE_FORMAT', 'Y-m-d\TH:i:s\Z');

//define ('MERCHANT_ID', 'A112ZN3BG4B0O0');
define('AWS_ACCESS_KEY_ID', 'AKIAJWQSXIPAKQWURUBQ');
define('AWS_SECRET_ACCESS_KEY', 'dr13U/5uVl2DWth5VUd0WAAQ71dy3oSVwmEvqFZu');

define('APPLICATION_NAME', '<Your Application Name>');
define('ourdeveloperid', '191298344797');
define('APPLICATION_VERSION', '<Your Application Version or Build Number>');



define ('MARKETPLACE_ID', 'ATVPDKIKX0DER');


/* End of file constants.php */
/* Location: ./application/config/constants.php */
