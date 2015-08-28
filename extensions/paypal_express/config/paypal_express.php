<?php defined('EXTPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Extension Meta
|--------------------------------------------------------------------------
|
| The Extension Meta Data (Required)
| 'author'      => The name of the extension author. More than one author may be listed, separated by comma.
| 'name'        => The name of your extension
| 'type'        => The type of your extension, could be module, payment or widget
| 'description' => A short description of the extension. Keep this description to fewer than 128 characters.
|
*/
$config['extension_meta'] = array(
    'author'		=> 'SamPoyigi',
    'name'			=> 'paypal_express',
    'type'		    => 'payment',
    'description'   => 'This extension will allow you to accept PayPal Express payment method during checkout.',
    'settings'      => TRUE,
);