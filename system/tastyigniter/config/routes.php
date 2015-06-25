<?php  if ( ! defined('BASEPATH')) exit('No direct access allowed');

if (APPDIR === ADMINDIR) {
    $route['default_controller'] = 'login';
    $route['404_override'] = '';
} else if (APPDIR === 'setup') {
    $route['default_controller'] = 'setup';
} else {
    $route['default_controller'] = 'home';
    $route['local/reviews'] = 'local/reviews';
    $route["^(" . implode('|', array('home', 'menus', 'reservation', 'contact', 'checkout', 'maintenance', 'local', 'pages')) . ")?$"] = '$1';
    $route["^(" . implode('|', array('home', 'menus', 'contact', 'maintenance', 'local', 'pages')) . ")?/(:any)$"] = '$1/$2';
    $route["^(" . implode('|', array('home', 'menus', 'contact', 'maintenance', 'local', 'pages')) . ")?/(:any)$"] = '$1';
    $route['locations'] = 'local/all';
    $route['local/(.+)'] = 'local';
    $route['account'] = 'account/account';
    $route['(:any)'] = 'pages';
    $route['404_override'] = '';
}

/* End of file routes.php */
/* Location: ./system/tastyigniter/config/routes.php */