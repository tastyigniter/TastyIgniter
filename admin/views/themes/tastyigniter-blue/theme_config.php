<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
* Theme configuration options for admin panel customization.
* This file contains an array of options for use with the theme customizer.
* ONLY $theme = array() allowed
*
*/
$CI =& get_instance();
$CI->load->helper('admin_theme_helper');
$theme = array();

// Set a custom theme name. Don't forget to replace spaces with underscores!
$theme['theme_name'] = 'TastyIgniter Blue';
$theme['basename'] = 'tastyigniter-blue';
$theme['theme_desc'] = 'Responsive theme for admin panel';

// Set all sections for the admin theme customisation. Don't forget to replace spaces with underscores!
$theme['sections']['general'] = array(
	'title'		=> 'General',
	'desc'		=> '',
	'icon'		=> '',
	'fields'	=> createFields(array(
		array(
			'id'		=> 'input-logo-width',
			'name'		=> 'logo_width',
			'label' 	=> 'Logo Width',
			'desc' 		=> 'Default: 220',
			'group_addon' => 'px',
			'type' 		=> 'text',
			'value'		=> set_value('logo_width', ''),
		),
		array(
			'id'		=> 'input-logo-top',
			'name'		=> 'logo_top',
			'label' 	=> 'Logo margin-top',
			'desc' 		=> 'Default: 10',
			'group_addon' => 'px',
			'type' 		=> 'text',
			'value'		=> set_value('logo_top', '0'),
		),
		array(
			'id'		=> 'input-logo-left',
			'name'		=> 'logo_left',
			'label' 	=> 'Logo margin-left',
			'desc' 		=> 'Default: 30',
			'group_addon' => 'px',
			'type' 		=> 'text',
			'value'		=> set_value('logo_left', '30'),
		),
	))
);

$theme['sections']['typography'] = array(
	'title'		=> 'Typography',
	'desc'		=> '',
	'icon'		=> '',
	'fields'	=> createFields(array(
		array(
			'id'			=> 'input-font-family',
			'name'			=> 'font_family',
			'label' 		=> 'Font Family',
			'desc'			=> 'Choose custom font family to use for the main body text.',
			'type' 			=> 'text',
			'font-family'	=> TRUE,
			'value'			=> set_value('font_family', '"Oxygen",Arial,sans-serif'),
		),
		array(
			'id'			=> 'input-font-weight',
			'name'			=> 'font_weight',
			'label' 		=> 'Font Weight',
			'desc'			=> 'Choose custom font weight to use for the main body text.',
			'type' 			=> 'text',
			'font-weight'	=> TRUE,
			'value'			=> set_value('font_weight', 'normal'),
		),
		array(
			'id'			=> 'input-font-size',
			'label' 		=> 'Font Size',
			'desc'			=> 'Choose custom font size and color to use for the main body text.',
			'type' 			=> 'control-group',
			'group'			=> array(
				array('id' => 'input-font-size', 'name' => 'font_size', 'type' => 'text', 'group_addon' => 'px', 'value' => set_value('font_size', '13')),
				array('id' => 'input-font-color', 'name' => 'font_color', 'type' => 'text', 'color' => TRUE, 'value' => set_value('font_color', '#333333')),
			)
		),
	))
);

$theme['sections']['styling'] = array(
	'title'		=> 'Styling',
	'desc'		=> '',
	'icon'		=> '',
	'fields'	=> createFields(array(
		array(
			'id'			=> 'input-background',
			'label' 		=> 'Main Background',
			'desc'			=> 'Choose custom background color or image to use for the main body background.',
			'type' 			=> 'control-group',
			'group'			=> array(
				array('id' => 'input-main-background', 'name' => 'body[background]', 'type' => 'text', 'color' => TRUE, 'value' => set_value('body[background]', '#FCFCFC')),
				array('id' => 'input-main-image', 'name' => 'body[image]', 'type' => 'text', 'media' => TRUE, 'value' => set_value('body[image]', '')),
			)
		),
		array(
			'id'			=> 'input-border-color',
			'name'			=> 'body[border]',
			'label' 		=> 'Main border color',
			'desc'			=> 'Choose custom color to use for the main body borders.',
			'type' 			=> 'text',
			'color'			=> TRUE,
			'value'			=> set_value('body[border]', '#E7E7E7')
		),
		array(
			'id'			=> 'input-header-background',
			'label' 		=> 'Header background',
			'desc'			=> 'Choose custom background color or image to use for the header.',
			'type' 			=> 'control-group',
			'group'			=> array(
				array('id' => 'input-header-background', 'name' => 'header[background]', 'type' => 'text', 'color' => TRUE, 'value' => set_value('header[background]', '#0074a2')),
				array('id' => 'input-header-image', 'name' => 'header[image]', 'type' => 'text', 'media' => TRUE, 'value' => set_value('header[image]', '')),
			)
		),
		array(
			'id'			=> 'input-header-color',
			'name'			=> 'header[color]',
			'label' 		=> 'Header font color',
			'desc'			=> 'Choose custom color to use for the header font/icons.',
			'type' 			=> 'text',
			'color'			=> TRUE,
			'value'			=> set_value('header[color]', '#9dc8e0')
		),
		array(
			'id'			=> 'input-sidebar-background',
			'label' 		=> 'Sidebar background',
			'desc'			=> 'Choose custom background color or image to use for the sidebar background.',
			'type' 			=> 'control-group',
			'group'			=> array(
				array('id' => 'input-sidebar-background', 'name' => 'sidebar[background]', 'type' => 'text', 'color' => TRUE, 'value' => set_value('sidebar[background]', '#F4F4F4')),
				array('id' => 'input-sidebar-image', 'name' => 'sidebar[image]', 'type' => 'text', 'media' => TRUE, 'value' => set_value('sidebar[image]', '')),
			)
		),
		array(
			'id'			=> 'input-sidebar-font',
			'label' 		=> 'Sidebar color',
			'desc'			=> 'Choose custom font and border color to use for the sidebar.',
			'type' 			=> 'control-group',
			'group'			=> array(
				array('id' => 'input-sidebar-font', 'name' => 'sidebar[font]', 'type' => 'text', 'color' => TRUE, 'value' => set_value('sidebar[font]', '#484848')),
				array('id' => 'input-sidebar-border', 'name' => 'sidebar[border]', 'type' => 'text', 'color' => TRUE, 'value' => set_value('sidebar[border]', '#E7E7E7')),
			)
		),
		array(
			'id'			=> 'input-link-color',
			'label' 		=> 'Link color',
			'desc'			=> 'Choose custom color to use for links.',
			'type' 			=> 'control-group',
			'group'			=> array(
				array('id' => 'input-link-color', 'name' => 'link[color]', 'type' => 'text', 'color' => TRUE, 'value' => set_value('link[color]', '#428bca')),
				array('id' => 'input-link-hover', 'name' => 'link[hover]', 'type' => 'text', 'color' => TRUE, 'value' => set_value('link[hover]', '#2a6496')),
			)
		),
		array(
			'id'			=> 'input-button-default',
			'label' 		=> 'Button default color',
			'desc'			=> 'Choose custom background and border color to use for the default button.',
			'type' 			=> 'control-group',
			'group'			=> array(
				array('name' => 'button[0][background]', 'type' => 'text', 'color' => TRUE, 'value' => set_value('button[0][background]', '#FFFFFF')),
				array('name' => 'button[0][border]', 'type' => 'text', 'color' => TRUE, 'value' => set_value('button[0][border]', '#CCCCCC')),
				array('name' => 'button[0][type]', 'type' => 'hidden', 'value' => set_value('button[0][type]', 'default')),
			)
		),
		array(
			'id'			=> 'input-button-primary',
			'label' 		=> 'Button primary color',
			'desc'			=> 'Choose custom background and border color to use for the primary button.',
			'type' 			=> 'control-group',
			'group'			=> array(
				array('name' => 'button[1][background]', 'type' => 'text', 'color' => TRUE, 'value' => set_value('button[1][background]', '#428bca')),
				array('name' => 'button[1][border]', 'type' => 'text', 'color' => TRUE, 'value' => set_value('button[1][border]', '#357ebd')),
				array('name' => 'button[1][type]', 'type' => 'hidden', 'value' => set_value('button[1][type]', 'primary')),
			)
		),
		array(
			'id'			=> 'input-button-success',
			'label' 		=> 'Button success color',
			'desc'			=> 'Choose custom background and border color to use for the success button.',
			'type' 			=> 'control-group',
			'group'			=> array(
				array('name' => 'button[2][background]', 'type' => 'text', 'color' => TRUE, 'value' => set_value('button[2][background]', '#5cb85c')),
				array('name' => 'button[2][border]', 'type' => 'text', 'color' => TRUE, 'value' => set_value('button[2][border]', '#4cae4c')),
				array('name' => 'button[2][type]', 'type' => 'hidden', 'value' => set_value('button[2][type]', 'success')),
			)
		),
		array(
			'id'			=> 'input-button-danger',
			'label' 		=> 'Button danger color',
			'desc'			=> 'Choose custom background and border color to use for the danger button.',
			'type' 			=> 'control-group',
			'group'			=> array(
				array('name' => 'button[3][background]', 'type' => 'text', 'color' => TRUE, 'value' => set_value('button[3][background]', '#d9534f')),
				array('name' => 'button[3][border]', 'type' => 'text', 'color' => TRUE, 'value' => set_value('button[3][border]', '#d43f3a')),
				array('name' => 'button[3][type]', 'type' => 'hidden', 'value' => set_value('button[3][type]', 'danger')),
			)
		),
	))
);

$theme['sections']['custom_css'] = array(
	'title'		=> 'Custom CSS',
	'desc'		=> '',
	'icon'		=> '',
	'fields'	=> createFields(array(
		array('id' => 'input-custom-css', 'name' => 'custom_css', 'label' => 'Custom CSS', 'desc' => 'Paste your custom CSS code here.', 'type' => 'textarea', 'rows' => '15', 'value' => set_value('custom_css', ''))
	))
);

$theme['sections']['content_positions'] = array(
	'title'		=> 'Content Positions',
	'desc'		=> '',
	'icon'		=> '',
	'fields'	=> createFields(array(
		array(
			'id'			=> 'input-content-top',
			'name'			=> 'content_top',
			'label' 		=> 'Content Top',
			'desc'			=> 'Set the width and min-height of the content top container.',
			'type' 			=> 'control-group',
			'group'			=> array(
				array('id' => 'input-top-with', 'name' => 'content_top[width]', 'type' => 'text', 'group_addon' => 'px', 'value' => set_value('content_top[width]', '200')),
				array('id' => 'input-top-min-height', 'name' => 'content_top[min_height]', 'type' => 'text', 'group_addon' => 'px', 'value' => set_value('content_top[min_height]', '250')),
			)
		),
	))
);

$theme['config_items'] = array('logo_width', 'logo_top', 'logo_left', 'font_family',
	'font_weight', 'font_size', 'font_color', 'body', 'header', 'sidebar', 'link', 'button', 'custom_css');

$theme['validate_fields'] = array(
	array('field' => 'logo_width', 'label' => 'Logo width', 'rules' => 'required|numeric'),
	array('field' => 'logo_top', 'label' => 'Logo margin-top', 'rules' => 'required|numeric'),
	array('field' => 'logo_left', 'label' => 'Logo margin-left', 'rules' => 'required|numeric'),
	array('field' => 'font_family', 'label' => 'Font family', 'rules' => 'required'),
	array('field' => 'font_weight', 'label' => 'Font weight', 'rules' => 'required|alpha'),
	array('field' => 'font_size', 'label' => 'Font size', 'rules' => 'required|numeric'),
	array('field' => 'font_color', 'label' => 'Font color', 'rules' => 'required'),
	array('field' => 'body[background]', 'label' => 'Main background color', 'rules' => 'required'),
	array('field' => 'body[image]', 'label' => 'Main background image', 'rules' => ''),
	array('field' => 'body[border]', 'label' => 'Main border color', 'rules' => 'required'),
	array('field' => 'header[background]', 'label' => 'Header background', 'rules' => 'required'),
	array('field' => 'header[image]', 'label' => 'Header background image', 'rules' => ''),
	array('field' => 'header[color]', 'label' => 'Header font color', 'rules' => 'required'),
	array('field' => 'sidebar[background]', 'label' => 'Sidebar background', 'rules' => 'required'),
	array('field' => 'sidebar[image]', 'label' => 'Sidebar background image', 'rules' => ''),
	array('field' => 'sidebar[border]', 'label' => 'Sidebar border color', 'rules' => 'required'),
	array('field' => 'sidebar[font]', 'label' => 'Sidebar font color', 'rules' => 'required'),
	array('field' => 'link[color]', 'label' => 'Link color', 'rules' => 'required'),
	array('field' => 'link[hover]', 'label' => 'Link hover', 'rules' => 'required'),
	array('field' => 'button[0][background]', 'label' => 'Button background color', 'rules' => 'required'),
	array('field' => 'button[0][border]', 'label' => 'Button border color', 'rules' => 'required'),
	array('field' => 'button[0][type]', 'label' => 'Button type', 'rules' => 'required|alpha_dash'),
	array('field' => 'button[1][background]', 'label' => 'Button background color', 'rules' => 'required'),
	array('field' => 'button[1][border]', 'label' => 'Button border color', 'rules' => 'required'),
	array('field' => 'button[1][type]', 'label' => 'Button type', 'rules' => 'required|alpha_dash'),
	array('field' => 'button[2][background]', 'label' => 'Button background color', 'rules' => 'required'),
	array('field' => 'button[2][border]', 'label' => 'Button border color', 'rules' => 'required'),
	array('field' => 'button[2][type]', 'label' => 'Button type', 'rules' => 'required|alpha_dash'),
	array('field' => 'button[3][background]', 'label' => 'Button background color', 'rules' => 'required'),
	array('field' => 'button[3][border]', 'label' => 'Button border color', 'rules' => 'required'),
	array('field' => 'button[3][type]', 'label' => 'Button type', 'rules' => 'required|alpha_dash'),
	array('field' => 'custom_css', 'label' => 'Custom css'),
);

$theme['error_fields'] = validateFields($theme['validate_fields']);

/*
$theme['sections']['content_positions'] = array(
	'title'		=> 'Content Positions',
	'desc'		=> '',
	'icon'		=> '',
	'table'		=> array(
		'table_open'	=> '<table class="table table-striped table-border table-sortable">',
		'thead'			=> array('', 'Position', 'Width', 'Min-Height'),
		'class'			=> array('action action-one', '', '', ''),
		'rows'			=> array(
			array(
				array('class' => 'action action-one', 'data' => '<a class="btn btn-danger" onclick="$(this).parent().parent().remove();" data-original-title="" title=""><i class="fa fa-times-circle"></i></a>'),
				array('data' => 'Top'),
				array('data' => array(
					array('id' => 'input-position-top', 'name' => 'positions[0][width]', 'type' => 'text', 'value'	=> '200px'),
					array('id' => 'input-position-name', 'name' => 'positions[0][name]', 'type' => 'hidden', 'value' => 'content_top' ),
				)),
				array('data' => array('id' => 'input-position-min-height', 'name' => 'positions[0][min_height]', 'type' => 'text', 'value' => '250px'))
			),
			array(
				array('class' => 'action action-one', 'data' => '<a class="btn btn-danger" onclick="$(this).parent().parent().remove();" data-original-title="" title=""><i class="fa fa-times-circle"></i></a>'),
				array('data' => 'Left'),
				array('data' => array(
					array('id' => 'input-position-left', 'name' => 'positions[1][width]', 'type' => 'text', 'value'	=> '200px'),
					array('id' => 'input-position-name', 'name' => 'positions[1][name]', 'type' => 'hidden', 'value' => 'content_left' ),
				)),
				array('data' => array('id' => 'input-position-min-height', 'name' => 'positions[1][min_height]', 'type' => 'text', 'value' => '250px'))
			),
			array(
				array('class' => 'action action-one', 'data' => '<a class="btn btn-danger" onclick="$(this).parent().parent().remove();" data-original-title="" title=""><i class="fa fa-times-circle"></i></a>'),
				array('data' => 'Right'),
				array('data' => array(
					array('id' => 'input-position-right', 'name' => 'positions[2][width]', 'type' => 'text', 'value'	=> '200px'),
					array('id' => 'input-position-name', 'name' => 'positions[2][name]', 'type' => 'hidden', 'value' => 'content_right' ),
				)),
				array('data' => array('id' => 'input-position-min-height', 'name' => 'positions[2][min_height]', 'type' => 'text', 'value' => '250px'))
			),
			array(
				array('class' => 'action action-one', 'data' => '<a class="btn btn-danger" onclick="$(this).parent().parent().remove();" data-original-title="" title=""><i class="fa fa-times-circle"></i></a>'),
				array('data' => 'Bottom'),
				array('data' => array(
					array('id' => 'input-position-bottom', 'name' => 'positions[3][width]', 'type' => 'text', 'value'	=> '200px'),
					array('id' => 'input-position-name', 'name' => 'positions[3][name]', 'type' => 'hidden', 'value' => 'content_bottom' ),
				)),
				array('data' => array('id' => 'input-position-min-height', 'name' => 'positions[3][min_height]', 'type' => 'text', 'value' => '250px'))
			),
			array(
				array('class' => 'action action-one', 'data' => '<i class="fa fa-plus" onclick="addTableRow();"></i>'),
				array('colspan' => '3'),
			)
		),
	),
);
*/