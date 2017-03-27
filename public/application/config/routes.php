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

$route['default_controller'] 		= 'paginas';
$route['404_override'] 				= '';

$route['auth/(:any)']				= 'auth/$1';
$route['auth']						= 'auth';

$route['crawler/(:num)']			= 'crawler/index/$1';
$route['crawler']					= 'crawler';
$route['cron/(:any)']				= 'cron/$1';
$route['admin']						= 'admin';
$route['admin/(:any)']				= 'admin/$1';

$route['account']					= 'account/index';
$route['uitloggen']					= 'account/uitloggen';

$route['verlanglijst']				= 'verlanglijst';
$route['zoeken']					= 'zoeken';
$route['zoeken/(:any)']				= 'zoeken/index/$1';
$route['contact']					= 'paginas/contact';
$route['top-10']					= 'paginas/top_10';
$route['vuurwerkregels']			= 'paginas/vuurwerkregels';
$route['disclaimer']				= 'paginas/disclaimer';
$route['winkels']					= 'paginas/winkels';
$route['winkels/(:any)']			= 'paginas/winkels/$1';
$route['importeurs']				= 'paginas/importeurs';
$route['importeurs/(:any)']			= 'paginas/importeurs/$1';
$route['embed/product/(:any)']		= 'embed/product/$1';
$route['ajax/(:any)']				= 'ajax/$1';
$route['(:any)']					= 'producten/index/$1';


/* End of file routes.php */
/* Location: ./application/config/routes.php */