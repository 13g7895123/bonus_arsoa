<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'index';
$route['404_override'] = 'my404';
$route['translate_uri_dashes'] = FALSE;

/*
 * 	壓縮
 */
$route['mini/js'] = 'mini/js';
$route['mini/js/(.*).js'] = 'mini/js/$1';
$route['mini/js/(.*)'] = 'mini/js/$1';
$route['mini/css'] = 'mini/css';
$route['mini/css/(.*).css'] = 'mini/css/$1';
$route['mini/css/(.*)'] = 'mini/css/$1';

$route['index'] = 'index/index';

$route['wadmin'] = 'wadmin/main/index';

$route['webmsg/(.*)'] = 'webmsg/index/$1';

$route['report/(:num)'] = 'report/index/$1';

$route['category_prod/list/(.*)'] = 'category_prod/list/$1';

$route['category_prod/(.*)'] = 'category_prod/index/$1';

$route['category_list/(.*)'] = 'category_list/index/$1';

$route['category/(.*)'] = 'category/index/$1';

$route['product/(.*)'] = 'product/index/$1';

$route['beauty/(:num)'] = 'beauty/index/$1';

$route['e/(.*)'] = 'event_quick/share/e/$1';	 	// 體驗包
$route['r/(.*)'] = 'event_quick/share/r/$1';		// 預約
$route['K/(.*)'] = 'event_quick/lottery/$1';		// 抽獎
$route['C/(.*)'] = 'event_quick/consent/$1';		// 同意書

$route['sitemap'] = 'rss/sitemap';

/* End of file routes.php */
/* Location: ./application/config/routes.php */