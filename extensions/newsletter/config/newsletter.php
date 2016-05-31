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
	'name'        => 'newsletter',
	'version'     => '1.1',
	'type'        => 'module',
	'title'       => 'Newsletter',
	'author'      => 'SamPoyigi',
	'description' => 'This extension will allow you to place a newsletter subscribe module around your website.',
	'settings'    => FALSE,
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