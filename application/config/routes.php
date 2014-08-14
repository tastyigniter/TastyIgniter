<?php  if ( ! defined('BASEPATH')) exit('No direct access allowed');

$route['default_controller'] = 'main/home';
$route[ADMIN_URI] = ADMIN_URI.'/dashboard';
$route['maintenance'] = 'main/maintenance';
$route['home'] = 'main/home';
$route['contact'] = 'main/contact';
$route['menus/(:any)'] = 'main/menus';
$route['menus'] = 'main/menus';
$route['locations'] = 'main/local/locations';
$route['local/(:any)'] = 'main/local';
$route['local'] = 'main/local';
$route['local/reviews'] = 'main/local/reviews';
$route['checkout'] = 'main/checkout';
$route['checkout/success'] = 'main/checkout/success';
$route['account'] = 'main/account';
$route['account/login'] = 'main/login';
$route['account/logout'] = 'main/logout';
$route['account/register'] = 'main/register';
$route['account/password/reset'] = 'main/password_reset';
$route['account/details'] = 'main/details';
$route['account/address'] = 'main/address';
$route['account/address/edit'] = 'main/address/edit';
$route['account/address/edit/(:num)'] = 'main/address/edit/$1';
$route['account/orders'] = 'main/orders';
$route['account/orders/view/(:num)'] = 'main/orders/view/$1';
$route['account/orders/reorder/(:num)'] = 'main/orders/reorder/$1';
$route['account/reservations'] = 'main/reservations';
$route['account/reservations/view/(:num)'] = 'main/reservations/view/$1';
$route['account/reviews'] = 'main/reviews';
$route['account/reviews/add/(:num)/(:num)'] = 'main/reviews/add/$1/$2';
$route['account/reviews/view/(:num)/(:num)/(:num)'] = 'main/reviews/view/$1/$2/$3';
$route['account/inbox'] = 'main/inbox';
$route['account/inbox/view/(:num)'] = 'main/inbox/view/$1';
$route['reserve/table'] = 'main/reserve_table';
$route['reserve/success'] = 'main/reserve_table/success';
$route['pages/(:any)'] = 'main/pages';
$route['pages'] = 'main/pages';
$route['404_override'] = '';

/* End of file routes.php */
/* Location: ./application/config/routes.php */