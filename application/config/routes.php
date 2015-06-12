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

$route['default_controller'] = "main";
$route['404_override'] = '';

$route['s'] = "webservice/senddatav4";
$route['null'] = "webservice/null";
$route['tg'] = "webservice/testgprs";
$route['time'] = "webservice/get_time";


$route['newfront'] = 'newfront/project';
$route['newback'] = 'newback/home';

$route['rake'] = "rake/home";
$route['frontend'] = 'frontend/stations';
$route['aging'] = 'aging/home';
$route['setup'] = 'setup/home/station';
$route['maintain'] = 'maintain/home/detail';
$route['analysis'] = 'analysis/home';
$route['backend'] = 'backend/station/slist';
$route['reporting'] = 'reporting/savpair';
$route['statistic'] = 'statistic/system';

//$route['userm'] = "userm/home";
//$route['statm/station'] = "statm/station/station_index";
//$route['datam/orgdata'] = "datam/orgdata/indoortmp_index";
//$route['sysm'] = "sysm/home";
//$route['frontend'] = "frontend/realtime";
//

/* End of file routes.php */
/* Location: ./application/config/routes.php */
