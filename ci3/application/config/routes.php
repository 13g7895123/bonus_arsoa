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
|	https://codeigniter.com/userguide3/general/routing.html
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
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// eform1 view routes
$route['eform/eform1'] = 'eform/eform1';
$route['eform/eform1_list'] = 'eform/eform1_list';

// eform1 API routes
$route['api/test'] = 'api/eeform/eeform1/test';
$route['api/eeform1/test'] = 'api/eeform/eeform1/test';
$route['api/eeform1/health'] = 'api/eeform/eeform1/health';
$route['api/eeform1/submit'] = 'api/eeform/eeform1/submit';
$route['api/eeform1/submissions/(:any)'] = 'api/eeform/eeform1/submissions/$1';
$route['api/eeform1/submission/(:any)'] = 'api/eeform/eeform1/submission/$1';
$route['api/eeform1/update/(:any)'] = 'api/eeform/eeform1/update/$1';
$route['api/eeform1/stats/(:any)'] = 'api/eeform/eeform1/stats/$1';
$route['api/eeform1/list'] = 'api/eeform/eeform1/list';
$route['api/eeform1/member_lookup/(:any)'] = 'api/eeform/eeform1/member_lookup/$1';
$route['api/eeform1/export_single/(:any)'] = 'api/eeform/eeform1/export_single/$1';
