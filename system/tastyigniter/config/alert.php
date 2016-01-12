<?php
/**
 * TastyIgniter
 *
 * An open source online ordering, reservation and management system for restaurants.
 *
 * @package   TastyIgniter
 * @author    SamPoyigi
 * @copyright TastyIgniter
 * @link      http://tastyigniter.com
 * @license   http://opensource.org/licenses/GPL-3.0 The GNU GENERAL PUBLIC LICENSE
 * @since     File available since Release 1.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
|  alert Session Name
| -------------------------------------------------------------------
|
| The name of the alert session to store all messages into.
|
*/

$config['alert']['session_name'] = 'alert';


/*
| -------------------------------------------------------------------
|  Default alert Styling
| -------------------------------------------------------------------
|
| The default styling (before/after) surrounding each alert message displayed.
|
*/

$config['alert']['default_style'] = array('<div class="alert alert-dismissable" role="alert">', '</div>');


/*
| -------------------------------------------------------------------
|  Custom alert Styles
| -------------------------------------------------------------------
|
| Custom styling used for specific alert message types.
|
*/

$config['alert']['styles'] = array(
	'alert' 	=> array('<div class="alert alert-dismissable" role="alert">', '</div>'),
	'custom' 	=> array('<div class="alert alert-dismissable" role="alert">', '</div>'),
	'success' 	=> array('<div class="alert alert-success alert-dismissable" role="alert">', '</div>'),
	'danger' 	=> array('<div class="alert alert-danger alert-dismissable" role="alert">', '</div>'),
	'warning' 	=> array('<div class="alert alert-warning alert-dismissable" role="alert">', '</div>'),
	'info' 	    => array('<div class="alert alert-info alert-dismissable" role="alert">', '</div>'),
	'error'   	=> array('<div class="alert alert-danger alert-dismissable" role="alert">',   '</div>'),
	'form'    	=> array('<div class="alert alert-danger alert-dismissable alert-collapsible" role="alert">
                <button type="button" class="btn-dropdown" aria-hidden="true"><i class="fa fa-chevron-down text-muted"></i></button>',   '</div>')
);



/*
| -------------------------------------------------------------------
|  Custom alert close Button
| -------------------------------------------------------------------
|
| Custom styling used for alert message close button.
|
*/

$config['alert']['close_button'] = array('<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;', '</button>');



/*
| -------------------------------------------------------------------
|  Custom form error message
| -------------------------------------------------------------------
|
| Custom form error message.
|
*/

$config['alert']['form_error_msg'] = array('Sorry but form validation has failed, please check for errors.');



/*
| -------------------------------------------------------------------
|  Split Messages by Default
| -------------------------------------------------------------------
|
| Option to split alert messages into their own seperate alerts by default.
|
*/

$config['alert']['split_default'] = FALSE;


/*
| -------------------------------------------------------------------
|  Merge Form and Error Messages
| -------------------------------------------------------------------
|
| Option to merge both form validation errors and custom error messages.
|
*/

$config['alert']['merge_form_errors'] = FALSE;


/*
| -------------------------------------------------------------------
|  Display Single Form Error Message
| -------------------------------------------------------------------
|
| You can optionally choose to display only a single form error message,
| useful when you are displaying field errors individually.
| To enable, set the value to a string, else NULL.
|
*/

$config['alert']['form_error_message'] = NULL;


/* End of file alert.php */
/* Location: ./system/config/alert.php */