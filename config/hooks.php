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

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	https://codeigniter.com/user_guide/general/hooks.html
|
*/
$hook['pre_system'] = array(
        'class'    => 'System',
        'function' => 'preSystem',
        'filename' => 'System.php',
        'filepath' => 'hooks',
);

$hook['pre_router'] = array(
        'class'    => 'System',
        'function' => 'preRouter',
        'filename' => 'System.php',
        'filepath' => 'hooks',
);

$hook['post_controller_constructor'] = array(
        'class'    => 'System',
        'function' => 'postControllerConstructor',
        'filename' => 'System.php',
        'filepath' => 'hooks',
);

$hook['post_controller'] = array(
        'class'    => 'System',
        'function' => 'postController',
        'filename' => 'System.php',
        'filepath' => 'hooks',
);
