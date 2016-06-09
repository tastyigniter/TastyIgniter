<?php defined('BASEPATH') OR exit('No direct script access allowed');

if (APPDIR === ADMINDIR) {
    $route['default_controller'] = 'login';
    $route['404_override'] = '';
} else if (APPDIR === 'setup') {
    $route['default_controller'] = 'setup';
    $route['([^/]+)'] = 'setup/$1';
    $route['404_override'] = '';
} else {
    $default_controller = 'home';
    $controller_exceptions = array('home', 'menus', 'reservation', 'contact', 'local', 'cart', 'checkout', 'pages');

    $route['default_controller'] = $default_controller;
    $route['menus/(.+)'] = 'menus';
    $route['local/reviews'] = 'local/reviews';
    $route['locations'] = 'local/all';
    $route['local/(.+)'] = 'local';
    $route['account'] = 'account/account';
    $route['login'] = 'account/login';
    $route['logout'] = 'account/logout';
    $route['register'] = 'account/register';
    $route['forgot-password'] = 'account/reset';
    $route['checkout/success'] = 'checkout/success';
    $route['reservation/success'] = 'reservation/success';
    $route["^(" . implode('|', $controller_exceptions) . ")?$"] = '$1';
    $route["^(" . implode('|', $controller_exceptions) . ")?/([^/]+)$"] = '$1';
    $route["^(" . implode('|', $controller_exceptions) . ")?/([^/]+)$"] = '$1/$2';
    $route['404_override'] = 'pages';
}

$route['translate_uri_dashes'] = FALSE;
