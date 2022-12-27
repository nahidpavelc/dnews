<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| Please see the user guide for complete details:
|	https://codeigniter.com/user_guide/general/routing.html
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|

*/

$route['gallery'] = "news/gallery_view";
$route['gallery-photo/(:any)'] = "news/image_gallery_view/$1";

$route['article/(:any)'] = "news/description/$1";
$route['article/(:any)/(:any)'] = "news/description/$1/$2";
$route['article/(:any)/(:any)/(:any)'] = "news/description/$1/$2/$3";
$route['article/(:any)/(:any)/(:any)/(:any)'] = "news/description/$1/$2/$3/$4";


$route['category/(:any)'] = "news/category/$1";
$route['category/(:any)/(:any)'] = "news/category/$1/$2";
$route['category/(:any)/(:any)/(:any)'] = "news/category/$1/$2/$3";
$route['category/(:any)/(:any)/(:any)/(:any)'] = "news/category/$1/$2/$3/$4";


//admin routing 
$route['admin'] = 'backend/admin';
$route['admin/(:any)'] = 'backend/admin/$1';
$route['admin/(:any)/(:any)'] = 'backend/admin/$1/$2';
$route['admin/(:any)/(:any)/(:any)'] = 'backend/admin/$1/$2/$3';
$route['admin/(:any)/(:any)/(:any)/(:any)'] = 'backend/admin/$1/$2/$3/$4';
$route['admin/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'backend/admin/$1/$2/$3/$4/$5';


//user routing
$route['user'] = 'backend/user';
$route['user/(:any)'] = 'backend/user/$1';
$route['user/(:any)/(:any)'] = 'backend/user/$1/$2';
$route['user/(:any)/(:any)/(:any)'] = 'backend/user/$1/$2/$3';


//login routing 
$route['login'] = 'backend/login';
$route['login/(:any)'] = 'backend/login/$1';
$route['login/(:any)/(:any)'] = 'backend/login/$1/$2';



$route['default_controller'] = 'site';

$route['404_override'] = '';
$route['translate_uri_dashes'] = TRUE;
