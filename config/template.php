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
| Breadcrumb Config
| -------------------------------------------------------------------
| This will contain some breadcrumbs settings.
|
| $config['breadcrumb_divider']			The string used to separate each breadcrumb link
| $config['breadcrumb_tag_open'] 		The opening tag for breadcrumbs container.
| $config['breadcrumb_tag_close'] 		The closing tag for breadcrumbs container.
| $config['breadcrumb_link_open'] 		The opening tag for breadcrumb link.
| $config['breadcrumb_link_close'] 		The closing tag for breadcrumb link.
|
*/
/*
|--------------------------------------------------------------------------
| Title Separator
|--------------------------------------------------------------------------
|
| What string should be used to separate title segments sent via $this->template->title('Foo', 'Bar');
|
|   Default: ' | '
|
*/

$config['title_separator'] = ' - ';

/*
|--------------------------------------------------------------------------
| Theme
|--------------------------------------------------------------------------
|
| Which theme to use by default?
|
| Can be overriden with $this->template->set_theme('foo');
|
|   Default: ''
|
*/

$config['theme'] = '';

/*
|--------------------------------------------------------------------------
| Default template head tags
|--------------------------------------------------------------------------
|
| Which template head tag is allowed by default?
|
|
|
*/

$config['head_tags']['doctype'] = 'html5';
$config['head_tags']['favicon'] = '';
$config['head_tags']['meta'] = array();
$config['head_tags']['title'] = '';
$config['head_tags']['style'] = array();
$config['head_tags']['script'] = array();
$config['head_tags']['heading'] = '';
$config['head_tags']['buttons'] = array();
$config['head_tags']['icons'] = array();
$config['head_tags']['back_button'] = '';

/*
|--------------------------------------------------------------------------
| Theme Locations
|--------------------------------------------------------------------------
|
| Where should we expect to see themes?
|
|	Default: array(THEMEPATH.'themes/') in the views folder
|
*/

$config['theme_locations'] = array(
    THEMEPATH,
);

/*
|--------------------------------------------------------------------------
| Theme allowed file and image extension
|--------------------------------------------------------------------------
|
| Which theme file and image extension is allowed by default?
|
|
|
*/

$config['allowed_image_ext']        = array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'tiff');
$config['allowed_file_ext']         = array('html', 'txt', 'xml', 'js', 'php', 'css');

/*
|--------------------------------------------------------------------------
| Theme hidden file and folders
|--------------------------------------------------------------------------
|
| Which theme file and folders is hidden by default?
|
|
|
*/

$config['theme_hidden_files']       = array('index.html');
$config['theme_hidden_folders']     = array();

