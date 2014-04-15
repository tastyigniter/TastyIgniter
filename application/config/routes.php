<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['default_controller'] = 'main/home';
$route['admin'] = 'admin/dashboard';
$route['home'] = 'main/home';
$route['aboutus'] = 'main/home/aboutus';
$route['contact'] = 'main/contact';
$route['menus'] = 'main/menus';
$route['menus/review'] = 'main/menus/review';
$route['menus/write_review'] = 'main/menus/write_review';
$route['checkout'] = 'main/checkout';
$route['checkout/success'] = 'main/checkout/success';
$route['payments'] = 'main/payments';
$route['payments/paypal'] = 'main/payments/paypal';
$route['account'] = 'main/account';
$route['account/login'] = 'main/login';
$route['account/logout'] = 'main/logout';
$route['account/register'] = 'main/register';
$route['account/password/reset'] = 'main/password_reset';
$route['account/details'] = 'main/details';
$route['account/address'] = 'main/address';
$route['account/address/edit'] = 'main/address/edit';
$route['account/orders'] = 'main/orders';
$route['account/orders/view'] = 'main/orders/view';
$route['account/reviews'] = 'main/reviews';
$route['account/reviews/add'] = 'main/reviews/add';
$route['account/reviews/view'] = 'main/reviews/view';
$route['account/inbox'] = 'main/inbox';
$route['account/inbox/view'] = 'main/inbox/view';
$route['find/table'] = 'main/find_table';
$route['reserve/table'] = 'main/reserve_table';
$route['reserve/success'] = 'main/reserve_table/success';
$route['404_override'] = '';

/* End of file routes.php */
/* Location: ./application/config/routes.php */