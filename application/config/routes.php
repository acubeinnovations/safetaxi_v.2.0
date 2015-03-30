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

$route['default_controller'] 				= "home";
$route['404_override'] 						= 'my404';
$route['admin/front-desk/(:any)'] 			= 'admin/front_desk/$0';
$route['front-desk/crontripallocation/(:any)'] 	= 'crontripallocation/index/$0';
$route['front-desk/download_xl/(:any)']		= 'download_xl/index';
$route['front-desk'] 						= 'user/index';
$route['front-desk/(:any)'] 				= 'user/index';
$route['syslogin'] 							= 'sys_login/index';
$route['logout'] 							= 'logout';
$route['vehicle/(:any)'] 					= 'vehicle/$0';
$route['trip/(:any)'] 						= 'trip/$0';
$route['general/(:any)'] 					= 'general/$0';
$route['trip-booking/(:any)'] 				= 'trip_booking/index/$0';
$route['customers/(:any)'] 					= 'customers/$0';
$route['maps/(:any)']					 	= 'maps/$0';

$route['driver_invoice/(:any)'] 			= 'driver_invoice/$0';

/* End of file routes.php */
/* Location: ./application/config/routes.php */
