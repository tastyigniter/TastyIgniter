<?php defined('EXTPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Extension Meta
|--------------------------------------------------------------------------
|
| The Extension Meta Data (Required)
| 'author'      => The name of the extension author. More than one author
|               may be listed, separated by comma.
| 'name'        => The name of your extension
| 'type'        => The type of your extension, could be module,
|               payment or widget
| 'description' => A short description of the extension. Keep this description
|               to fewer than 128 characters.
|
*/
$config['extension_meta'] = array(
    'author'		=> 'SamPoyigi',
    'name'			=> 'featured_menus',
    'type'		    => 'module',
    'description'   => 'This extension will allow you to place a featured menus module around your website.',
    'settings'      => TRUE,
);

/*
|--------------------------------------------------------------------------
| Extension Permission
|--------------------------------------------------------------------------
|
| The Extension Meta Data (Required)
| 'name'        => The name of the permission e.g Module.*****
| 'action'      => The extension permitted action array (access, manage, add, delete)
| 'description' => A short description of the permission. Keep this description
|               to fewer than 128 characters.
| 'status'      => The status of your extension, if you want it
|               enabled or disabled by default
|
*/
$config['extension_permission_rules'] = array(
    'name'          => 'Module.FeaturedMenus',
    'action'        => array('manage'),
    'description'   => 'Ability to manage featured menus module',
    'status'        => '1',
);