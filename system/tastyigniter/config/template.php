<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| Breadcrum Config
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
$config['breadcrumb_divider'] 		= '<span class="divider">/</span>';
$config['breadcrumb_tag_open'] 		= '<div id="breadcrumb" class="btn-group btn-breadcrumb">';
$config['breadcrumb_tag_close'] 	= '</div>';
$config['breadcrumb_link_open'] 	= '<a href="{link}" class="btn btn-default">';
$config['breadcrumb_link_close'] 	= '</a>';


/*
|--------------------------------------------------------------------------
| Parser Enabled
|--------------------------------------------------------------------------
|
| Should the Parser library be used for the entire page?
|
| Can be overridden with $this->template->enable_parser(TRUE/FALSE);
|
|   Default: TRUE
|
*/

$config['parser_enabled'] = TRUE;

/*
|--------------------------------------------------------------------------
| Parser Enabled for Body
|--------------------------------------------------------------------------
|
| If the parser is enabled, do you want it to parse the body or not?
|
| Can be overridden with $this->template->enable_parser(TRUE/FALSE);
|
|   Default: FALSE
|
*/

$config['parser_body_enabled'] = FALSE;

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
| Layout
|--------------------------------------------------------------------------
|
| Which layout file should be used? When combined with theme it will be a layout file in that theme
|
| Change to 'main' to get /application/views/layouts/main.php
|
|   Default: 'default'
|
*/

$config['layout'] = 'default';

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

$config['theme'] = '';
*/

/*
|--------------------------------------------------------------------------
| Theme Locations
|--------------------------------------------------------------------------
|
| Where should we expect to see themes?
|
|	Default: array(VIEWPATH.'themes/' => '../themes/')
|
*/

$config['theme_locations'] = array(
	VIEWPATH.'themes/'
);