<?php  if ( ! defined('BASEPATH')) exit('No direct access allowed');

$route['default_controller'] = 'home';
$route['menus/(:any)'] = 'menus';
$route['locations'] = 'local/locations';
$route['local/reviews'] = 'local/reviews';
$route['local/(:any)'] = 'local';
$route['account/login'] = 'login';
$route['account/logout'] = 'logout';
$route['account/register'] = 'register';
$route['account/password/reset'] = 'password_reset';
$route['account/details'] = 'details';
$route['account/address'] = 'address';
$route['account/address/edit'] = 'address/edit';
$route['account/address/edit/(:num)'] = 'address/edit/$1';
$route['account/orders'] = 'orders';
$route['account/orders/view/(:num)'] = 'orders/view/$1';
$route['account/orders/reorder/(:num)'] = 'orders/reorder/$1';
$route['account/reservations'] = 'reservations';
$route['account/reservations/view/(:num)'] = 'reservations/view/$1';
$route['account/reviews'] = 'reviews';
$route['account/reviews/add/(:any)/(:num)/(:num)'] = 'reviews/add/$1/$2/$3';
$route['account/reviews/view/(:num)'] = 'reviews/view/$1';
$route['account/inbox'] = 'inbox';
$route['account/inbox/view/(:num)'] = 'inbox/view/$1';
$route['reserve/success'] = 'reserve_table/success';
$route['reserve/table'] = 'reserve_table';
$route['pages/(:any)'] = 'pages';
$route['404_override'] = '';

/* End of file routes.php */
/* Location: ./system/tastyigniter/config/routes.php */