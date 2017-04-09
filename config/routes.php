<?php
/**
 * TastyIgniter
 *
 * An open source online ordering, reservation and management system for restaurants.
 *
 * @package Igniter
 * @author Samuel Adepoyigi
 * @copyright (c) 2013 - 2016. Samuel Adepoyigi
 * @copyright (c) 2016 - 2017. TastyIgniter Dev Team
 * @link https://tastyigniter.com
 * @license http://opensource.org/licenses/MIT The MIT License
 * @since File available since Release 1.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

//if (APPDIR === ADMINDIR) {
//    $route['default_controller'] = 'login';
//    $route[ADMINDIR.'/(.+)'] = '$1';
//    $route['404_override'] = '';
//} else if (APPDIR === 'setup') {
//    $route['default_controller'] = 'setup';
//    $route['([^/]+)'] = 'setup/$1';
//    $route['404_override'] = '';
//} else {
//}
//
$default_controller = 'home';
$controller_exceptions = array('home', 'menus', 'reservation', 'contact', 'local', 'cart', 'checkout', 'pages');

$route['default_controller'] = $default_controller;

// Setup app routes
$route['setup/(.+)'] = 'setup/$1';

// Admin app routes
$route[ADMINDIR.'/(.+)'] = '$1';

// Main app routes
$route['locations'] = 'local/all';
$route['account'] = 'account/account';
$route['account/reviews'] = 'account/reviews'; // added to fix conflict with newly added local/reviews routes
$route['login'] = 'account/login';
$route['logout'] = 'account/logout';
$route['register'] = 'account/register';
$route['forgot-password'] = 'account/reset';
$route['checkout/success'] = 'checkout/success';
$route['reservation/success'] = 'reservation/success';

// Single and Multiple location routes
$location_methods = array('menus', 'info', 'reviews', 'gallery');
$route["^(" . implode('|', $location_methods) . ")?$"] = 'local/$1';
$route["^(" . implode('|', $location_methods) . ")?/([^/]+)$"] = 'local/$1/$2';
$route["^(" . implode('|', $location_methods) . ")?/([^/]+)?/([^/]+)$"] = 'local/$1/$2/$3';

if (config_item('site_location_mode') === 'multiple') {
    $route["^([^/]+)/(" . implode('|', $location_methods) . ")?$"] = 'local/$2/$1';
    $route["^([^/]+)/(" . implode('|', $location_methods) . ")?/([^/]+)$"] = 'local/$2/$1/$3';
    $route["^([^/]+)/(" . implode('|', $location_methods) . ")?/([^/]+)?/([^/]+)$"] = 'local/$2/$1/$3/$4';
}

$route["^(" . implode('|', $controller_exceptions) . ")?$"] = '$1';
$route["^(" . implode('|', $controller_exceptions) . ")?/([^/]+)$"] = '$1';
$route["^(" . implode('|', $controller_exceptions) . ")?/([^/]+)$"] = '$1/$2';

// To route all permalinks for pages
$route['404_override'] = 'pages';

$route['translate_uri_dashes'] = FALSE;
