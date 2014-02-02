<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['default_controller'] = 'main/home';
$route['checkout/success'] = 'main/checkout/success';
$route['home'] = 'main/home';
$route['aboutus'] = 'main/home/aboutus';
$route['contact'] = 'main/contact';
$route['menus'] = 'main/menus';
$route['menus/category/:num'] = 'main/menus';
$route['menus/review'] = 'main/menus/review';
$route['menus/write_review'] = 'main/menus/write_review';
$route['checkout'] = 'main/checkout';
$route['payments'] = 'main/payments';
$route['account/login'] = 'main/login';
$route['account/logout'] = 'main/logout';
$route['account/register'] = 'main/register';
$route['account'] = 'main/account';
$route['account/details'] = 'main/details';
$route['account/address'] = 'main/address';
$route['account/orders'] = 'main/orders';
$route['account/inbox'] = 'main/inbox';
$route['password/reset'] = 'main/password_reset';
$route['find/table'] = 'main/find_table';
$route['reserve/table'] = 'main/reserve_table';
$route['account/inbox/view/:num'] = 'main/inbox/view';
$route['404_override'] = '';

/* End of file routes.php */
/* Location: ./application/config/routes.php */