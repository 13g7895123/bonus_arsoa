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

// API路由配置 - Debug route first
$route['eform/api/form5/submit'] = 'eform/Api/form5';

$route['api/test'] = 'api/eeform1/test';
$route['api/eeform1/test'] = 'api/eeform1/test';
$route['api/eeform1/health'] = 'api/eeform1/health';
$route['api/eeform1/submit'] = 'api/eeform1/submit';
$route['api/eeform1/submissions/(:any)'] = 'api/eeform1/submissions/$1';
$route['api/eeform1/submission/(:any)'] = 'api/eeform1/submission/$1';
$route['api/eeform1/update/(:any)'] = 'api/eeform1/update/$1';
$route['api/eeform1/stats/(:any)'] = 'api/eeform1/stats/$1';

$route['api/eeform2/health'] = 'api/eeform/eeform2/health';
$route['api/eeform2/submit'] = 'api/eeform/eeform2/submit';
$route['api/eeform2/submissions/(:any)'] = 'api/eeform/eeform2/submissions/$1';
$route['api/eeform2/submission/(:any)'] = 'api/eeform/eeform2/submission/$1';
$route['api/eeform2/stats/(:any)'] = 'api/eeform/eeform2/stats/$1';
$route['api/eeform/eeform2/list'] = 'api/eeform/eeform2/list';
$route['api/eeform/eeform2/products'] = 'api/eeform/eeform2/products';
$route['api/eeform/eeform2/update_status/(:any)'] = 'api/eeform/eeform2/update_status/$1';
$route['api/eeform/eeform2/delete/(:any)'] = 'api/eeform/eeform2/delete/$1';
$route['api/eeform/eeform2/export'] = 'api/eeform/eeform2/export';
$route['api/eeform/eeform2/export_single/(:any)'] = 'api/eeform/eeform2/export_single/$1';

$route['api/eeform3/health'] = 'api/eeform3/health';
$route['api/eeform3/submit'] = 'api/eeform3/submit';
$route['api/eeform3/activity_items'] = 'api/eeform3/activity_items';
$route['api/eeform3/submissions/(:any)'] = 'api/eeform3/submissions/$1';
$route['api/eeform3/submission/(:any)'] = 'api/eeform3/submission/$1';
$route['api/eeform3/submission/(:any)/status'] = 'api/eeform3/update_status/$1';
$route['api/eeform3/stats/(:any)'] = 'api/eeform3/stats/$1';

$route['api/eeform4/health'] = 'api/eeform/eeform4/health';
$route['api/eeform4/submit'] = 'api/eeform/eeform4/submit';
$route['api/eeform4/submissions/(:any)'] = 'api/eeform/eeform4/submissions/$1';
$route['api/eeform4/submission/(:any)'] = 'api/eeform/eeform4/submission/$1';
$route['api/eeform4/stats/(:any)'] = 'api/eeform/eeform4/stats/$1';

$route['api/eeform5/health'] = 'api/eeform/eeform5/health';
$route['api/eeform5/submit'] = 'api/eeform/eeform5/submit';
$route['api/eeform5/submissions/(:any)'] = 'api/eeform/eeform5/submissions/$1';
$route['api/eeform5/submission/(:any)'] = 'api/eeform/eeform5/submission/$1';
$route['api/eeform5/stats/(:any)'] = 'api/eeform/eeform5/stats/$1';

$route['api/eform5/submit'] = 'api/eform/form5/submit';

/* End of file routes.php */
/* Location: ./application/config/routes.php */