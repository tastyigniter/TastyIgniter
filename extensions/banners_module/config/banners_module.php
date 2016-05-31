<?php defined('EXTPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Extension Meta
|--------------------------------------------------------------------------
|
| The extension meta data that tells TastyIgniter that an extension is a valid module, payment or widget,
| only array element name and version are STRONGLY required
|
| 'name'        => The name of your extension
| 'version'     => The current version number of the extension, such as 1.0 or 1.0.3.
| 'type'        => The type of your extension, could be module, payment or widget
| 'title'       => The title of your extension, a readable name
| 'author'      => The name of the extension author. More than one author may be listed, separated by comma.
| 'description' => A short description of the extension. Keep this description to fewer than 128 characters.
| 'settings'    => Whether to enable/disable extension admin settings page.
|
*/
$config['extension_meta'] = array(
	'name'        => 'banners_module',
	'version'     => '1.1',
	'type'        => 'module',
	'title'       => 'Banners',
	'author'      => 'SamPoyigi',
	'description' => 'This extension will allow you to place a banner module around your website.',
	'settings'    => TRUE,
);

/*
|--------------------------------------------------------------------------
| Extension Permission (Optional)
|--------------------------------------------------------------------------
|
| The extension permission rule that will be saved then assigned to the current staff group
| installing the extension
|
| 'name'        => The name of the permission e.g Module.ModuleName or Payment.ModuleName
| 'action'      => The extension permitted action array (access, manage, add, delete)
| 'description' => A short description of the permission. Keep this description
|               to fewer than 128 characters.
|
*/
$config['extension_permission'] = array(
	'name'        => 'Module.BannersModule',
	'action'      => array('manage'),
	'description' => 'Ability to manage banners module',
);

/*
|--------------------------------------------------------------------------
| Extension Layout Ready (Optional)
|--------------------------------------------------------------------------
|
| This extension config value tells TastyIgniter to use the extension as a layout module
| (layout modules are displayed in the storefront inside partial areas)
*/
$config['layout_ready'] = TRUE;