<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
* Theme configuration options for admin panel customization.
* This file contains an array of options to be retrieved later in the theme.
* ONLY $theme = array() allowed
*
*/

// Set a custom theme title.
$theme['title']         = 'TastyIgniter Orange';
$theme['author']        = 'SamPoyigi';
$theme['version']       = '2.0';
$theme['description']   = 'Responsive theme for front-end';
$theme['child']       	= TRUE;

$theme['head_tags'] = array(
	'doctype'   => 'html5',
	'favicon'   => theme_url('tastyigniter-orange/images/favicon.ico'),
	'meta'     	=> array(
		array('name' => 'Content-type', 'content' => 'text/html; charset=utf-8', 'type' => 'equiv'),
		array('name' => 'X-UA-Compatible', 'content' => 'IE=edge', 'type' => 'equiv'),
		array('name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no', 'type' => 'name'),
	),
	'style'    	=> array(
		array(theme_url('tastyigniter-orange/css/bootstrap.min.css'), 'bootstrap-css', '10'),
		array(theme_url('tastyigniter-orange/css/font-awesome.min.css'), 'font-awesome-css', '11'),
		array(theme_url('tastyigniter-orange/css/select2.css'), 'select2-css', '13'),
		array(theme_url('tastyigniter-orange/css/select2-bootstrap.css'), 'select2-bootstrap-css', '14'),
		array(theme_url('tastyigniter-orange/css/jquery.raty.css'), 'jquery-raty-css', '15'),
		array(theme_url('tastyigniter-orange/css/fonts.css'), 'fonts-css', '16'),
		array(theme_url('tastyigniter-orange/css/stylesheet.css'), 'stylesheet-css', '100100100100100'),
	),
	'script'   	=> array(
		array(theme_url('tastyigniter-orange/js/jquery-1.11.2.min.js'), 'jquery-js', '1'),
		array(theme_url('tastyigniter-orange/js/bootstrap.min.js'), 'bootstrap-js', '10'),
		array(theme_url('tastyigniter-orange/js/select2.js'), 'select-2-js', '12'),
		array(theme_url('tastyigniter-orange/js/jquery.raty.js'), 'jquery-raty-js', '13'),
		array(theme_url('tastyigniter-orange/js/common.js'), 'common-js', '100100100100100'),
	),
);

// Register partial areas for layout modules.
$theme['partial_area'] = array(
	array(
		'name'          => 'Content Top',
		'id'            => 'content_top',
		'open_tag'      => '<div id="{id}" class="partial partial-area {class}">',
		'close_tag'     => '</div>',
		'module_html' 	=> '<div id="{id}" class="{class}">{module}</div>',
	),
	array(
		'name'          => 'Content Left',
		'id'            => 'content_left',
		'class'         => 'col-sm-3 ',
		'open_tag'      => '<div id="{id}" class="partial partial-area {class}">',
		'close_tag'     => '</div>',
		'module_html' 	=> '<div id="{id}" class="side-bar {class}">{module}</div>',
	),
	array(
		'name'          => 'Content Footer',
		'id'            => 'content_footer',
		'class'         => 'footer-section ',
		'open_tag'      => '<div id="{id}" class="partial partial-area {class}">',
		'close_tag'     => '</div>',
		'module_html' 	=> '<div id="{id}" class="{class}">{module}</div>',
	),
	array(
		'name'          => 'Content Bottom',
		'id'            => 'content_bottom',
		'open_tag'      => '<div class="clearfix"></div><div id="{id}" class="partial partial-area {class}">',
		'close_tag'     => '</div>',
		'module_html' 	=> '<div id="{id}" class="{class}">{module}</div>',
	),
	array(
		'name'          => 'Content Right',
		'id'            => 'content_right',
		'class'         => 'col-sm-3 ',
		'open_tag'      => '<div id="{id}" class="partial partial-area {class}">',
		'close_tag'     => '</div>',
		'module_html' 	=> '<div id="{id}" class="side-bar {class}">{module}</div>',
	),
);

// Set all sections for the admin theme customisation.
$theme['customize']['sections']['general'] = array(
	'title'		=> 'General',
	'desc'		=> '',
	'icon'		=> '',
	'fields'		=> array(
		array(
			'id'		=> 'input-display-crumbs',
			'name'		=> 'display_crumbs',
			'label' 	=> 'Display Breadcrumbs',
			'type' 		=> 'button-group',
			'group'			=> array(
				array('data-btn' => 'btn-default', 'name' => 'display_crumbs', 'type' => 'radio', 'label' => 'Yes', 'value' => '1', 'checked' => TRUE),
				array('data-btn' => 'btn-default', 'name' => 'display_crumbs', 'type' => 'radio', 'label' => 'No', 'value' => '0', 'rules' => 'required|numeric'),
			)
		),
		array(
			'id'		=> 'input-hide-admin-link',
			'name'		=> 'hide_admin_link',
			'label' 	=> 'Hide footer admin link',
			'type' 		=> 'button-group',
			'group'			=> array(
				array('data-btn' => 'btn-default', 'name' => 'hide_admin_link', 'type' => 'radio', 'label' => 'Yes', 'value' => '1'),
				array('data-btn' => 'btn-default', 'name' => 'hide_admin_link', 'type' => 'radio', 'label' => 'No', 'value' => '0', 'checked' => TRUE, 'rules' => 'required|numeric'),
			)
		),
		array(
			'id'        => 'input-ga-tracking-code',
			'name'      => 'ga_tracking_code',
			'label'     => 'GA Tracking Code',
			'desc'      => 'Paste your Google Analytics Tracking Code here.',
			'type'      => 'textarea',
			'rows'      => '10',
			'value'     => ''
		),
	)
);

$theme['customize']['sections']['typography'] = array(
	'title'		=> 'Typography',
	'desc'		=> '',
	'icon'		=> '',
	'fieldset'	=> array(
		array(
			'legend'		=> 'Main body',
			'fields'	=> array(
				array(
					'id'			=> 'input-font-family',
					'name'			=> 'font[family]',
					'label' 		=> 'Font Family',
					'desc'			=> 'The font family to use for the main body text.',
					'type' 			=> 'text',
					'value'			=> '"Oxygen",Arial,sans-serif',
		            'rules'         => 'required',
				),
				array(
					'id'			=> 'input-font-weight',
					'label' 		=> 'Font Weight & Style',
					'desc'			=> 'The font weight and style to use for the main body text.',
					'type' 			=> 'input-group',
					'group'			=> array(
						array('id' => 'input-font-weight', 'name' => 'font[weight]', 'type' => 'dropdown', 'value' => 'normal', 'rules' => 'required|alpha', 'options' => array('normal' => 'Normal', 'bold' => 'Bold', 'bolder' => 'Bolder', 'lighter' => 'Lighter')),
						array('id' => 'input-font-style', 'name' => 'font[style]', 'type' => 'dropdown', 'options' => array('normal' => 'Normal', 'italic' => 'Italic'), 'value' => 'normal', 'rules' => 'required|alpha'),
					)
				),
				array(
					'id'			=> 'input-font-size',
					'label' 		=> 'Font Size & Color',
					'desc'			=> 'The font size and color to use for the main body text.',
					'type' 			=> 'input-group',
					'group'			=> array(
						array('id' => 'input-font-size', 'name' => 'font[size]', 'type' => 'text', 'r_addon' => 'px', 'value' => '13', 'rules' => 'required|numeric'),
						array('id' => 'input-font-color', 'name' => 'font[color]', 'type' => 'color', 'value' => '#333333', 'rules' => 'required'),
					)
				),
			)
		),
		array(
			'legend'		=> 'Header Menu',
			'fields'	=> array(
				array(
					'id'			=> 'input-menu-font-family',
					'name'			=> 'menu_font[family]',
					'label' 		=> 'Header menu font family',
					'desc'			=> 'The font family to use for the header menu.',
					'type' 			=> 'text',
					'value'			=> '"Oxygen",Arial,sans-serif',
		            'rules'         => 'required',
				),
				array(
					'id'			=> 'input-menu-font-weight',
					'label' 		=> 'Header menu font weight & style',
					'desc'			=> 'The font weight and style to use for the header menu.',
					'type' 			=> 'input-group',
					'group'			=> array(
						array('id' => 'input-menu-font-weight', 'name' => 'menu_font[weight]', 'type' => 'dropdown', 'value' => 'normal', 'rules' => 'required|alpha', 'options' => array('normal' => 'Normal', 'bold' => 'Bold', 'bolder' => 'Bolder', 'lighter' => 'Lighter')),
						array('id' => 'input-menu-font-style', 'name' => 'menu_font[style]', 'type' => 'dropdown', 'options' => array('normal' => 'Normal', 'italic' => 'Italic'), 'value' => 'normal', 'rules' => 'required|alpha'),
					)
				),
				array(
					'id'			=> 'input-menu-font-size',
					'label' 		=> 'Header menu font size & color',
					'desc'			=> 'The font size and color to use for the header menu.',
					'type' 			=> 'input-group',
					'group'			=> array(
						array('id' => 'input-menu-font-size', 'name' => 'menu_font[size]', 'type' => 'text', 'r_addon' => 'px', 'value' => '16', 'rules' => 'required|numeric'),
						array('id' => 'input-menu-font-color', 'name' => 'menu_font[color]', 'type' => 'color', 'value' => '#FFF', 'rules' => 'required'),
					)
				),
			)
		)
	)
);

$theme['customize']['sections']['styling'] = array(
	'title'		=> 'Styling',
	'desc'		=> '',
	'icon'		=> '',
	'fieldset'	=> array(
		array(
			'legend'		=> 'Body',
			'fields'		=> array(
				array(
					'id'			=> 'input-body-background',
					'label' 		=> 'Body background',
					'desc'			=> 'The background color or image to use for the body body background and how the image is displayed.',
					'type' 			=> 'input-group',
					'group'			=> array(
						array('id' => 'input-body-background', 'name' => 'body[background]', 'type' => 'color', 'value' => '#FFFFFF', 'rules' => 'required'),
						array('id' => 'input-body-image', 'name' => 'body[image]', 'type' => 'media', 'value' => ''),
						array('id' => 'input-body-background-display', 'name' => 'body[display]', 'type' => 'dropdown', 'options' => array('tiled' => 'Tiled', 'contain' => 'Contain', 'cover' => 'Cover', 'centered' => 'Centered'), 'value' => 'contain', 'rules' => 'required'),
					)
				),
				array(
					'id'			=> 'input-foreground',
					'label' 		=> 'Body foreground, general and border color',
					'desc'			=> 'The color to use for the foreground.',
					'type' 			=> 'input-group',
					'group'			=> array(
						array('id' => 'input-foreground', 'name' => 'body[foreground]', 'type' => 'color', 'value' => '#FFF', 'rules' => 'required'),
						array('id' => 'input-general-color', 'name' => 'body[color]', 'type' => 'color', 'value' => '#ed561a', 'rules' => 'required'),
						array('id' => 'input-border-color', 'name' => 'body[border]', 'type' => 'color', 'value' => '#DDD', 'rules' => 'required'),
					)
				),
				array(
					'id'			=> 'input-link-color',
					'label' 		=> 'Link color',
					'desc'			=> 'The normal and hover color to use for links.',
					'type' 			=> 'input-group',
					'group'			=> array(
						array('id' => 'input-link-color', 'name' => 'link[color]', 'type' => 'color', 'value' => '#337AB7', 'rules' => 'required'),
						array('id' => 'input-link-hover', 'name' => 'link[hover]', 'type' => 'color', 'value' => '#23527C', 'rules' => 'required'),
					)
				),
			)
		),
		array(
			'legend'		=> 'Heading',
			'fields'		=> array(
				array(
					'id'			=> 'input-heading-background',
					'label' 		=> 'Page heading background',
					'desc'			=> 'The background color or image to use for the page heading and how the image is displayed.',
					'type' 			=> 'input-group',
					'group'			=> array(
						array('id' => 'input-heading-background', 'name' => 'heading[background]', 'type' => 'color', 'value' => ''),
						array('id' => 'input-heading-image', 'name' => 'heading[image]', 'type' => 'media', 'value' => ''),
						array('id' => 'input-heading-display', 'name' => 'heading[display]', 'type' => 'dropdown', 'options' => array('tiled' => 'Tiled', 'contain' => 'Contain', 'cover' => 'Cover', 'centered' => 'Centered'), 'value' => 'contain', 'rules' => 'required'),
					)
				),
				array(
					'id'			=> 'input-heading-color',
					'name'			=> 'heading[color]',
					'label' 		=> 'Page heading font color',
					'desc'			=> 'The color to use for the page heading font/icons.',
					'type' 			=> 'color',
					'value'			=> '#333',
					'rules'         => 'required',
				),
				array(
					'id'			=> 'input-under-heading-image',
					'label' 		=> 'Page heading under-image',
					'desc'			=> 'The image and height to use for the page under-heading image.',
					'type' 			=> 'input-group',
					'group'			=> array(
						array('id' => 'input-under-heading-image', 'name' => 'heading[under_image]', 'type' => 'media', 'value' => '', 'rules' => ''),
						array('id' => 'input-under-heading-height', 'name' => 'heading[under_height]', 'type' => 'text', 'value' => '50', 'rules' => 'numeric'),
					)
				),
			)
		),
		array(
			'legend'		=> 'Button Colors',
			'fields'		=> array(
				array(
					'id'			=> 'input-button-default',
					'label' 		=> 'Default color',
					'desc'			=> 'The default background, border and font color',
					'type' 			=> 'input-group',
					'group'			=> array(
						array('name' => 'button[default][background]', 'type' => 'color', 'value' => '#E7E7E7', 'rules' => 'required'),
						array('name' => 'button[default][hover]', 'type' => 'color', 'value' => '#E7E7E7', 'rules' => 'required'),
						array('name' => 'button[default][font]', 'type' => 'color', 'value' => '#333333', 'rules' => 'required'),
					)
				),
				array(
					'id'			=> 'input-button-primary',
					'label' 		=> 'Primary color',
					'desc'			=> 'The primary background, border and font color',
					'type' 			=> 'input-group',
					'group'			=> array(
						array('name' => 'button[primary][background]', 'type' => 'color', 'value' => '#428bca', 'rules' => 'required'),
						array('name' => 'button[primary][hover]', 'type' => 'color', 'value' => '#428bca', 'rules' => 'required'),
						array('name' => 'button[primary][font]', 'type' => 'color', 'value' => '#FFFFFF', 'rules' => 'required'),
					)
				),
				array(
					'id'			=> 'input-button-success',
					'label' 		=> 'Success color',
					'desc'			=> 'The success background, border and font color',
					'type' 			=> 'input-group',
					'group'			=> array(
						array('name' => 'button[success][background]', 'type' => 'color', 'value' => '#5cb85c', 'rules' => 'required'),
						array('name' => 'button[success][hover]', 'type' => 'color', 'value' => '#5cb85c', 'rules' => 'required'),
						array('name' => 'button[success][font]', 'type' => 'color', 'value' => '#FFFFFF', 'rules' => 'required'),
					)
				),
				array(
					'id'			=> 'input-button-info',
					'label' 		=> 'Info color',
					'desc'			=> 'The info background, border and font color',
					'type' 			=> 'input-group',
					'group'			=> array(
						array('name' => 'button[info][background]', 'type' => 'color', 'value' => '#5BC0DE', 'rules' => 'required'),
						array('name' => 'button[info][hover]', 'type' => 'color', 'value' => '#5BC0DE', 'rules' => 'required'),
						array('name' => 'button[info][font]', 'type' => 'color', 'value' => '#FFFFFF', 'rules' => 'required'),
					)
				),
				array(
					'id'			=> 'input-button-warning',
					'label' 		=> 'Warning color',
					'desc'			=> 'The warning background, border and font color',
					'type' 			=> 'input-group',
					'group'			=> array(
						array('name' => 'button[warning][background]', 'type' => 'color', 'value' => '#f0ad4e', 'rules' => 'required'),
						array('name' => 'button[warning][hover]', 'type' => 'color', 'value' => '#f0ad4e', 'rules' => 'required'),
						array('name' => 'button[warning][font]', 'type' => 'color', 'value' => '#FFFFFF', 'rules' => 'required'),
					)
				),
				array(
					'id'			=> 'input-button-danger',
					'label' 		=> 'Danger color',
					'desc'			=> 'The danger background, border and font color',
					'type' 			=> 'input-group',
					'group'			=> array(
						array('name' => 'button[danger][background]', 'type' => 'color', 'value' => '#d9534f', 'rules' => 'required'),
						array('name' => 'button[danger][border]', 'type' => 'color', 'value' => '#d9534f', 'rules' => 'required'),
						array('name' => 'button[danger][font]', 'type' => 'color', 'value' => '#FFFFFF', 'rules' => 'required'),
					)
				),
			)
		),
	),
);

$theme['customize']['sections']['sidebar'] = array(
	'title'		=> 'Sidebar',
	'desc'		=> '',
	'icon'		=> '',
	'fields'	=> array(
		array(
			'id'			=> 'input-sidebar-background',
			'label' 		=> 'Sidebar background',
			'desc'			=> 'The background color or image to use for the sidebar background and how the image is displayed.',
			'type' 			=> 'input-group',
			'group'			=> array(
				array('id' => 'input-sidebar-background', 'name' => 'sidebar[background]', 'type' => 'color', 'value' => '#FFFFFF', 'rules' => 'required'),
				array('id' => 'input-sidebar-image', 'name' => 'sidebar[image]', 'type' => 'media', 'value' => ''),
				array('id' => 'input-sidebar-display', 'name' => 'sidebar[display]', 'type' => 'dropdown', 'options' => array('tiled' => 'Tiled', 'contain' => 'Contain', 'cover' => 'Cover', 'centered' => 'Centered'), 'value' => 'contain', 'rules' => 'required'),
			)
		),
		array(
			'id'			=> 'input-sidebar-font',
			'label' 		=> 'Sidebar font and border',
			'desc'			=> 'The font and border color to use for the sidebar.',
			'type' 			=> 'input-group',
			'group'			=> array(
				array('id' => 'input-sidebar-font', 'name' => 'sidebar[font]', 'type' => 'color', 'value' => '#484848', 'rules' => 'required'),
				array('id' => 'input-sidebar-border', 'name' => 'sidebar[border]', 'type' => 'color', 'value' => '#EEEEEE', 'rules' => 'required'),
			)
		),
	),
);

$theme['customize']['sections']['header'] = array(
	'title'		=> 'Header',
	'desc'		=> '',
	'icon'		=> '',
	'fields'		=> array(
	),
	'fieldset'	=> array(
		array(
			'fields'		=> array(
				array(
					'id'			=> 'input-header-background',
					'label' 		=> 'Header background',
					'desc'			=> 'The background color or image to use for the top header and how the image is displayed.',
					'type' 			=> 'input-group',
					'group'			=> array(
						array('id' => 'input-header-background', 'name' => 'header[background]', 'type' => 'color', 'value' => '#ED561A', 'rules' => 'required'),
						array('id' => 'input-header-image', 'name' => 'header[image]', 'type' => 'media', 'value' => ''),
						array('id' => 'input-sidebar-display', 'name' => 'header[display]', 'type' => 'dropdown', 'options' => array('tiled' => 'Tiled', 'contain' => 'Contain', 'cover' => 'Cover', 'centered' => 'Centered'), 'value' => 'contain', 'rules' => 'required'),
					)
				),
				array(
					'id'			=> 'input-header-dropdown',
					'name'			=> 'header[dropdown_background]',
					'label' 		=> 'Dropdown background color',
					'desc'			=> 'The background color to use for the top header dropdown.',
					'type' 			=> 'color',
					'value'			=> '#ED561A',
					'rules'         => 'required',
				),
				array(
					'id'			=> 'input-header-color',
					'name'			=> 'header[color]',
					'label' 		=> 'Header dropdown font color',
					'desc'			=> 'The color to use for the top header dropdown font.',
					'type' 			=> 'color',
					'value'			=> '#FFF',
					'rules'         => 'required',
				),
			)
		),
		array(
			'legend'		=> 'Logo',
			'fields'		=> array(
				array(
					'id'			=> 'input-logo',
					'label' 		=> 'Logo',
					'desc'			=> 'Upload custom logo or text to your website.',
					'type' 			=> 'input-group',
					'group'			=> array(
						array('id' => 'input-logo-image', 'name' => 'logo_image', 'type' => 'media', 'value' => '', 'rules' => 'required'),
						array('id' => 'input-logo-text', 'name' => 'logo_text', 'type' => 'text', 'value' => ''),
					)
				),
				array(
					'id'		=> 'input-logo-height',
					'name'		=> 'logo_height',
					'label' 	=> 'Logo Height',
					'desc' 		=> 'Default: 40',
					'r_addon'   => 'px',
					'type' 		=> 'text',
					'value'		=> '40',
					'rules'     => 'required|numeric',
				),
				array(
					'id'			=> 'input-logo-padding',
					'label' 		=> 'Logo padding',
					'desc'			=> 'The top and bottom padding for the logo.',
					'type' 			=> 'input-group',
					'group'			=> array(
						array('id' => 'input-logo-padding-top', 'name' => 'logo_padding_top', 'type' => 'text', 'value' => '10', 'rules' => 'numeric'),
						array('id' => 'input-logo-padding-bottom', 'name' => 'logo_padding_bottom', 'type' => 'text', 'value' => '10', 'rules' => 'numeric'),
					)
				),
			)
		),
		array(
			'legend'		=> 'Favicon',
			'fields'		=> array(
				array(
					'id'		=> 'input-favicon',
					'name'		=> 'favicon',
					'label' 	=> 'Favicon',
					'desc' 		=> 'Upload your favicon ( png, ico, jpg, gif or bmp ).',
					'type' 		=> 'media',
					'value'		=> '',
					'rules'     => '',
				),
			)
		),
	),
);

$theme['customize']['sections']['footer'] = array(
	'title'		=> 'Footer',
	'desc'		=> '',
	'icon'		=> '',
	'fields'	=> array(
		array(
			'id'			=> 'input-main-footer-background',
			'label' 		=> 'Footer background',
			'desc'			=> 'The background color or image to use for the main footer and how the image is displayed.',
			'type' 			=> 'input-group',
			'group'			=> array(
				array('id' => 'input-main-footer-background', 'name' => 'footer[background]', 'type' => 'color', 'value' => '#EDEFF1', 'rules' => 'required'),
				array('id' => 'input-main-footer-image', 'name' => 'footer[image]', 'type' => 'media', 'value' => ''),
				array('id' => 'input-main-footer-display', 'name' => 'footer[display]', 'type' => 'dropdown', 'options' => array('tiled' => 'Tiled', 'contain' => 'Contain', 'cover' => 'Cover', 'centered' => 'Centered'), 'value' => 'contain', 'rules' => 'required'),
			)
		),
		array(
			'id'			=> 'input-bottom-footer-background',
			'label' 		=> 'Bottom footer background',
			'desc'			=> 'The background color or image to use for the bottom footer and how the image is displayed.',
			'type' 			=> 'input-group',
			'group'			=> array(
				array('id' => 'input-bottom-footer-background', 'name' => 'footer[bottom_background]', 'type' => 'color', 'value' => '#FBFBFB', 'rules' => 'required'),
				array('id' => 'input-bottom-footer-image', 'name' => 'footer[bottom_image]', 'type' => 'media', 'value' => ''),
				array('id' => 'input-bottom-footer-display', 'name' => 'footer[bottom_display]', 'type' => 'dropdown', 'options' => array('tiled' => 'Tiled', 'contain' => 'Contain', 'cover' => 'Cover', 'centered' => 'Centered'), 'value' => 'contain', 'rules' => 'required'),
			)
		),
		array(
			'id'			=> 'input-footer-font',
			'label' 		=> 'Footer font color',
			'desc'			=> 'The font color to use for the main and bottom footer.',
			'type' 			=> 'input-group',
			'group'			=> array(
				array('id' => 'input-footer-main-font', 'name' => 'footer[footer_color]', 'type' => 'color', 'value' => '#9BA1A7', 'rules' => 'required'),
				array('id' => 'input-footer-bottom-font', 'name' => 'footer[bottom_footer_color]', 'type' => 'color', 'value' => '#A3AAAF', 'rules' => 'required'),
			)
		),
	)
);

$theme['customize']['sections']['social'] = array(
	'title'		=> 'Social',
	'desc'		=> 'Add full URL for your social network profiles',
	'icon'		=> '',
	'fields'	=> array(
		array(
			'id'			=> 'input-social-facebook',
			'name'			=> 'social[facebook]',
			'label' 		=> 'Facebook',
			'type' 			=> 'text',
			'value'			=> '#',
		),
		array(
			'id'			=> 'input-social-twitter',
			'name'			=> 'social[twitter]',
			'label' 		=> 'Twitter',
			'type' 			=> 'text',
			'value'			=> '#',
		),
		array(
			'id'			=> 'input-social-google',
			'name'			=> 'social[google]',
			'label' 		=> 'Google +',
			'type' 			=> 'text',
			'value'			=> '#',
		),
		array(
			'id'			=> 'input-social-youtube',
			'name'			=> 'social[youtube]',
			'label' 		=> 'Youtube',
			'type' 			=> 'text',
			'value'			=> '#',
		),
		array(
			'id'			=> 'input-social-vimeo',
			'name'			=> 'social[vimeo]',
			'label' 		=> 'Vimeo',
			'type' 			=> 'text',
			'value'			=> '',
		),
		array(
			'id'			=> 'input-social-linkedin',
			'name'			=> 'social[linkedin]',
			'label' 		=> 'LinkedIn',
			'type' 			=> 'text',
			'value'			=> '',
		),
		array(
			'id'			=> 'input-social-pinterest',
			'name'			=> 'social[pinterest]',
			'label' 		=> 'Pinterest',
			'type' 			=> 'text',
			'value'			=> '',
		),
		array(
			'id'			=> 'input-social-tumblr',
			'name'			=> 'social[tumblr]',
			'label' 		=> 'Tumblr',
			'type' 			=> 'text',
			'value'			=> '',
		),
		array(
			'id'			=> 'input-social-flickr',
			'name'			=> 'social[flickr]',
			'label' 		=> 'Flickr',
			'type' 			=> 'text',
			'value'			=> '',
		),
		array(
			'id'			=> 'input-social-instagram',
			'name'			=> 'social[instagram]',
			'label' 		=> 'Instagram',
			'type' 			=> 'text',
			'value'			=> '',
		),
		array(
			'id'			=> 'input-social-dribbble',
			'name'			=> 'social[dribbble]',
			'label' 		=> 'Dribbble',
			'type' 			=> 'text',
			'value'			=> '',
		),
		array(
			'id'			=> 'input-social-foursquare',
			'name'			=> 'social[foursquare]',
			'label' 		=> 'Foursquare',
			'type' 			=> 'text',
			'value'			=> '',
		),
	)
);

$theme['customize']['sections']['custom_script'] = array(
	'title'		=> 'Custom Scripts',
	'desc'		=> '',
	'icon'		=> '',
	'fields'	=> array(
		array('id' => 'input-custom-css', 'name' => 'custom_script[css]', 'label' => 'Add custom CSS', 'desc' => 'Paste your custom CSS code here.', 'type' => 'textarea', 'rows' => '9', 'value' => ''),
		array('id' => 'input-custom-head-script', 'name' => 'custom_script[head]', 'label' => 'Add custom Javascript to header', 'desc' => 'Paste your custom Javascript code here.', 'type' => 'textarea', 'rows' => '9', 'value' => ''),
		array('id' => 'input-custom-body-script', 'name' => 'custom_script[footer]', 'label' => 'Add custom Javascript to footer', 'desc' => 'Paste your custom Javascript code here.', 'type' => 'textarea', 'rows' => '9', 'value' => ''),
	)
);

// REFERENCE::: Sample for adding tables
//$theme['customize']['sections']['content_positions'] = array(
//    'title'		=> 'Content Positions',
//    'desc'		=> '',
//    'icon'		=> '',
//    'table'		=> array(
//        'type'	        => 'sortable',
//        'thead'			=> array('Position', 'Width', 'Min-Height'),
//        'rows'			=> array(
//            array(
//                array('data' => 'Top'),
//                array('fields' => array('id' => 'input-position-top', 'name' => 'positions[top][width]', 'type' => 'text', 'value'	=> '100%')),
//                array('fields' => array('id' => 'input-position-min-height', 'name' => 'positions[top][min_height]', 'type' => 'text', 'value' => 'auto'))
//            ),
//            array(
//                array('data' => 'Left'),
//                array('fields' => array('id' => 'input-position-left', 'name' => 'positions[left][width]', 'type' => 'text', 'value'	=> '25%')),
//                array('fields' => array('id' => 'input-position-min-height', 'name' => 'positions[left][min_height]', 'type' => 'text', 'value' => 'auto'))
//            ),
//            array(
//                array('data' => 'Right'),
//                array('fields' => array('id' => 'input-position-right', 'name' => 'positions[right][width]', 'type' => 'text', 'value'	=> '25%')),
//                array('fields' => array('id' => 'input-position-min-height', 'name' => 'positions[right][min_height]', 'type' => 'text', 'value' => 'auto'))
//            ),
//            array(
//                array('data' => 'Bottom'),
//                array('fields' => array('id' => 'input-position-bottom', 'name' => 'positions[bottom][width]', 'type' => 'text', 'value'	=> '100%')),
//                array('fields' => array('id' => 'input-position-min-height', 'name' => 'positions[bottom][min_height]', 'type' => 'text', 'value' => 'auto'))
//            ),
//        ),
//    ),
//);

// Set accepted post item when updating the admin theme options.
$theme['customize']['post_items'] = array('logo_image', 'logo_text', 'favicon', 'logo_height', 'logo_padding_top', 'logo_padding_bottom', 'display_crumbs', 'hide_admin_link',
	'ga_tracking_code', 'font', 'menu_font', 'body', 'header', 'heading', 'sidebar', 'link', 'button', 'footer', 'social', 'custom_script');


/* End of file theme_config.php */
/* Location: ./main/views/themes/tastyigniter-orange/theme_config.php */