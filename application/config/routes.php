<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
  | This route will tell the Router what URI segments to use if those provided
  | in the URL cannot be matched to a valid route.
  |
 */
$route['deck/limit-logs'] = "deck/displayLimitedLogs";
$route['deck/retweet-logs'] = "deck/displayRetweetIdLogs";

$route['404_override'] = 'myerrors/page_missing';

//$route['default_controller'] = "main";
$route['default_controller'] = "home";
$route['signup'] = "signup/index";
//$route['home/(:any)'] = 'home/$1';
//$route['admin']               = "admin/login";
//$route['login']               = "login";
//$route['test']               = "test";
$route['theme_example']               = "theme_example";
$route['verify/(:any)'] = "/home/verify/$1";
#$route['mypaypal/recurring_payment'] = "/mypaypal/recurring_payment";
$route['mypaypal/review'] = "/mypaypal/review";
$route['mypaypal/cancel'] = "/mypaypal/cancel";
$route['mypaypal/(:any)'] = "/mypaypal/index/$1";

$route['admin/tweetlink/delete/(:any)'] = "admin/tweetlink/delete/$1";
$route['admin/tweetlink/multidelete/(:any)'] = "admin/tweetlink/multidelete/$1";
$route['admin/tweetlink/(:any)'] = "admin/tweetlink/index/$1";


/* End of file routes.php */
/* Location: ./application/config/routes.php */
