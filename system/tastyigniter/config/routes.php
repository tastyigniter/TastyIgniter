<?php  if ( ! defined('BASEPATH')) exit('No direct access allowed');

if (APPDIR === ADMINDIR) {
    $route['default_controller'] = 'login';
} else if (APPDIR === 'setup') {
    $route['default_controller'] = 'setup';
} else {
    $default_controller = 'home';
    $controller_exceptions = array('home', 'menus', 'reservation', 'contact', 'local', 'pages');

    $route['default_controller'] = $default_controller;
    $route['local/reviews'] = 'local/reviews';
    $route['locations'] = 'local/all';
    $route['local/(.+)'] = 'local';
    $route['account'] = 'account/account';
    $route['login'] = 'account/login';
    $route['logout'] = 'account/logout';
    $route['register'] = 'account/register';
    $route['forgot-password'] = 'account/reset';
    $route["^(" . implode('|', $controller_exceptions) . ")?$"] = '$1';
    $route["^(" . implode('|', $controller_exceptions) . ")?/([^/]+)$"] = '$1';
    $route["^(" . implode('|', $controller_exceptions) . ")?/([^/]+)$"] = '$1/$2';
    $route['([^/]+)'] = 'pages';
}

$route['404_override'] = '';

/* End of file routes.php */
/* Location: ./system/tastyigniter/config/routes.php */