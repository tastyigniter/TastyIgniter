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
| -------------------------------------------------------------------
| Breadcrumb Config
| -------------------------------------------------------------------
| This will contain some breadcrumbs settings.
|
| $config['breadcrumb']['divider']			The string used to separate each breadcrumb link
| $config['breadcrumb']['tag_open'] 		The opening tag for breadcrumbs container.
| $config['breadcrumb']['tag_close'] 		The closing tag for breadcrumbs container.
| $config['breadcrumb']['link_open'] 		The opening tag for breadcrumb link.
| $config['breadcrumb']['link_close'] 		The closing tag for breadcrumb link.
|
*/
$config['breadcrumb']['divider']    = '&raquo;';
$config['breadcrumb']['tag_open']  = '<li class="{class}">';
$config['breadcrumb']['tag_close']  = '</li>';
$config['breadcrumb']['link_open']  = '<a href="{link}">';
$config['breadcrumb']['link_close'] = '</a>';

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
| Partial Area Config
|--------------------------------------------------------------------------
|
|   The default config when none is available in the theme config
|
*/
$config['partial_area']['open_tag'] = '<div id="{id}">';
$config['partial_area']['close_tag'] = '</div>';
$config['partial_area']['module_html'] = '<div id="{id}" class="{class}">{module}</div>';

/*
|--------------------------------------------------------------------------
| Paths to locate theme/view files
|--------------------------------------------------------------------------
|
| Which theme to use by default?
|
| Can be overriden with $this->template->set_theme('foo');
|
|   Default: [VIEWPATH, THEMEPATH]
|
*/

$config['view_folders'] = [VIEWPATH, THEMEPATH];

/*
|--------------------------------------------------------------------------
| Default template head tags
|--------------------------------------------------------------------------
|
| Which template head tag is allowed by default?
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
| Theme allowed file and image extension
|--------------------------------------------------------------------------
|   @todo: move to theme manager library
| Which theme file and image extension is allowed by default?
|
*/

$config['allowed_image_ext']        = array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'tiff');
$config['allowed_file_ext']         = array('html', 'txt', 'xml', 'js', 'css', 'php', 'json');

/*
|--------------------------------------------------------------------------
| Theme hidden file and folders
|--------------------------------------------------------------------------
|   @todo: move to theme manager library
| Which theme file and folders is hidden by default?
|
*/

$config['theme_hidden_files']       = array('index.html');
$config['theme_hidden_folders']     = array();

