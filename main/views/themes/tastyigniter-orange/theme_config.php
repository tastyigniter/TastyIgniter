<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
* Theme configuration options for admin panel customization.
* This file contains an array of options for use with the theme customizer.
* ONLY $theme = array() allowed
*
*/

// Set a custom theme title.
$theme['title'] = 'TastyIgniter Orange';
$theme['description'] = 'Responsive theme for front-end';
$theme['head_tags'] = array(
    'doctype'   => 'html5',
    'favicon'   => 'images/favicon.ico',
    'meta'     	=> array(
            array('name' => 'Content-type', 'content' => 'text/html; charset=utf-8', 'type' => 'equiv'),
            array('name' => 'X-UA-Compatible', 'content' => 'IE=edge', 'type' => 'equiv'),
            array('name' => 'viewport', 'content' => 'width=device-width, initial-scale=1', 'type' => 'name'),
    ),
    'style'    	=> array(
            array('css/bootstrap.min.css', 'bootstrap-css', '10'),
            array('css/font-awesome.min.css', 'font-awesome-css', '11'),
            array('css/select2.css', 'select2-css', '13'),
            array('css/select2-bootstrap.css', 'select2-bootstrap-css', '14'),
            array('css/jquery.raty.css', 'jquery-raty-css', '15'),
            array('css/stylesheet.css', 'stylesheet-css', '100100100100100'),
    ),
    'script'   	=> array(
            array('js/jquery-1.11.2.min.js', 'jquery-js', '1'),
            array('js/bootstrap.min.js', 'bootstrap-js', '10'),
            array('js/select2.js', 'select-2-js', '12'),
            array('js/jquery.raty.js', 'jquery-raty-js', '13'),
            array('js/common.js', 'common-js', '100100100100100'),
    ),
);

// Register partial areas for modules.
$theme['partial_area'] = array(
    array(
        'name'      => 'Content Top',
        'id'        => 'content_top',
        'open_tag'  => '<div id="{id}" class="partial">',
        'close_tag' => '</div>',
    ),
    array(
        'name'      => 'Content Bottom',
        'id'        => 'content_bottom',
        'open_tag'  => '<div class="clearfix"></div><div id="{id}" class="partial">',
        'close_tag' => '</div>',
    ),
    array(
        'name'      => 'Content Left',
        'id'        => 'content_left',
        'class'     => 'col-sm-3',
        'open_tag'  => '<div id="{id}" class="partial {class}"><div class="side-bar">',
        'close_tag' => '</div></div>',
    ),
    array(
        'name'      => 'Content Right',
        'id'        => 'content_right',
        'class'     => 'col-sm-3 ',
        'open_tag'  => '<div id="{id}" class="partial {class}"><div class="side-bar">',
        'close_tag' => '</div></div>',
    ),
    array(
        'name'      => 'Content Footer',
        'id'        => 'content_footer',
        'class'     => 'footer-section ',
        'open_tag'  => '<div id="{id}" class="partial {class}">',
        'close_tag' => '</div>',
    ),
);

// Set all sections for the admin theme customisation.
$theme['customize']['sections']['general'] = array(
	'title'		=> 'General',
	'desc'		=> '',
	'icon'		=> '',
	'fields'	=> array(
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
			'id'		=> 'input-logo-padding-top',
			'name'		=> 'logo_padding_top',
			'label' 	=> 'Logo margin-top',
			'desc' 		=> 'Default: 25',
			'r_addon'   => 'px',
			'type' 		=> 'text',
			'value'		=> '25',
            'rules'     => 'required|numeric',
		),
		array(
			'id'		=> 'input-logo-padding-bottom',
			'name'		=> 'logo_padding_bottom',
			'label' 	=> 'Logo margin-bottom',
			'desc' 		=> 'Default: 25',
			'r_addon'   => 'px',
			'type' 		=> 'text',
			'value'		=> '25',
            'rules'     => 'required|numeric',
		),
//		array(
//			'id'		=> 'input-display-crumbs',
//			'name'		=> 'display_crumbs',
//			'label' 	=> 'Display Breadcrumbs',
//			'type' 		=> 'button-group',
//            'group'			=> array(
//                array('data-btn' => 'btn-danger', 'name' => 'display_crumbs', 'type' => 'radio', 'label' => 'Disabled', 'value' => '0', 'checked' => TRUE, 'rules' => 'required|numeric'),
//                array('data-btn' => 'btn-success', 'name' => 'display_crumbs', 'type' => 'radio', 'label' => 'Enabled', 'value' => '1'),
//            )
//        ),
	)
);

$theme['customize']['sections']['typography'] = array(
	'title'		=> 'Typography',
	'desc'		=> '',
	'icon'		=> '',
	'fields'	=> array(
		array(
			'id'			=> 'input-font-family',
			'name'			=> 'font_family',
			'label' 		=> 'Font Family',
			'desc'			=> 'Choose custom font family to use for the main body text.',
			'type' 			=> 'text',
			'value'			=> '"Oxygen",Arial,sans-serif',
            'rules'         => 'required',
		),
		array(
			'id'			=> 'input-font-weight',
			'name'			=> 'font_weight',
			'label' 		=> 'Font Weight',
			'desc'			=> 'Choose custom font weight to use for the main body text.',
			'type' 			=> 'dropdown',
            'options'       => array(
                'normal'         => 'Normal',
                'bold'           => 'Bold',
                'bolder'         => 'Bolder',
                'lighter'        => 'Lighter',
            ),
			'value'			=> 'normal',
            'rules'         => 'required|alpha',
		),
		array(
			'id'			=> 'input-font-size',
			'label' 		=> 'Font Size',
			'desc'			=> 'Choose custom font size and color to use for the main body text.',
			'type' 			=> 'input-group',
			'group'			=> array(
				array('id' => 'input-font-size', 'name' => 'font_size', 'type' => 'text', 'r_addon' => 'px', 'value' => '13', 'rules' => 'required|numeric'),
				array('id' => 'input-font-color', 'name' => 'font_color', 'type' => 'color', 'value' => '#333333', 'rules' => 'required'),
			)
		),
	)
);

$theme['customize']['sections']['styling'] = array(
	'title'		=> 'Styling',
	'desc'		=> '',
	'icon'		=> '',
	'fields'	=> array(
		array(
			'id'			=> 'input-background',
			'label' 		=> 'Main Background',
			'desc'			=> 'Choose custom background color or image to use for the main body background.',
			'type' 			=> 'input-group',
			'group'			=> array(
				array('id' => 'input-main-background', 'name' => 'body[background]', 'type' => 'color', 'value' => '#FFFFFF', 'rules' => 'required'),
				array('id' => 'input-main-image', 'name' => 'body[image]', 'type' => 'media', 'value' => ''),
			)
		),
		array(
			'id'			=> 'input-header-background',
			'label' 		=> 'Header background',
			'desc'			=> 'Choose custom background color or image to use for the header.',
			'type' 			=> 'input-group',
			'group'			=> array(
				array('id' => 'input-header-background', 'name' => 'header[background]', 'type' => 'color', 'value' => '#fdeae2', 'rules' => 'required'),
				array('id' => 'input-header-image', 'name' => 'header[image]', 'type' => 'media', 'value' => ''),
			)
		),
		array(
			'id'			=> 'input-header-color',
			'name'			=> 'header[color]',
			'label' 		=> 'Header font color',
			'desc'			=> 'Choose custom color to use for the header font/icons.',
			'type' 			=> 'color',
			'value'			=> '#333',
            'rules'         => 'required',
		),
		array(
			'id'			=> 'input-sidebar-background',
			'label' 		=> 'Sidebar background',
			'desc'			=> 'Choose custom background color or image to use for the sidebar background.',
			'type' 			=> 'input-group',
			'group'			=> array(
				array('id' => 'input-sidebar-background', 'name' => 'sidebar[background]', 'type' => 'color', 'value' => '#FFFFFF', 'rules' => 'required'),
				array('id' => 'input-sidebar-image', 'name' => 'sidebar[image]', 'type' => 'media', 'value' => ''),
			)
		),
		array(
			'id'			=> 'input-sidebar-font',
			'label' 		=> 'Sidebar color',
			'desc'			=> 'Choose custom font and border color to use for the sidebar.',
			'type' 			=> 'input-group',
			'group'			=> array(
				array('id' => 'input-sidebar-font', 'name' => 'sidebar[font]', 'type' => 'color', 'value' => '#484848', 'rules' => 'required'),
                array('id' => 'input-sidebar-border', 'name' => 'sidebar[border]', 'type' => 'color', 'value' => '#FFFFFF', 'rules' => 'required'),
            )
		),
		array(
			'id'			=> 'input-link-color',
			'label' 		=> 'Link color',
			'desc'			=> 'Choose custom color to use for links.',
			'type' 			=> 'input-group',
			'group'			=> array(
				array('id' => 'input-link-color', 'name' => 'link[color]', 'type' => 'color', 'value' => '#428bca', 'rules' => 'required'),
				array('id' => 'input-link-hover', 'name' => 'link[hover]', 'type' => 'color', 'value' => '#2a6496', 'rules' => 'required'),
			)
		),
		array(
			'id'			=> 'input-button-default',
			'label' 		=> 'Button default color',
			'desc'			=> 'Choose custom background and border color to use for the default button.',
			'type' 			=> 'input-group',
			'group'			=> array(
				array('name' => 'button[default][background]', 'type' => 'color', 'value' => '#FFFFFF', 'rules' => 'required'),
				array('name' => 'button[default][border]', 'type' => 'color', 'value' => '#CCCCCC', 'rules' => 'required'),
			)
		),
		array(
			'id'			=> 'input-button-primary',
			'label' 		=> 'Button primary color',
			'desc'			=> 'Choose custom background and border color to use for the primary button.',
			'type' 			=> 'input-group',
			'group'			=> array(
				array('name' => 'button[primary][background]', 'type' => 'color', 'value' => '#428bca', 'rules' => 'required'),
				array('name' => 'button[primary][border]', 'type' => 'color', 'value' => '#357ebd', 'rules' => 'required'),
			)
		),
		array(
			'id'			=> 'input-button-success',
			'label' 		=> 'Button success color',
			'desc'			=> 'Choose custom background and border color to use for the success button.',
			'type' 			=> 'input-group',
			'group'			=> array(
				array('name' => 'button[success][background]', 'type' => 'color', 'value' => '#5cb85c', 'rules' => 'required'),
				array('name' => 'button[success][border]', 'type' => 'color', 'value' => '#4cae4c', 'rules' => 'required'),
			)
		),
		array(
			'id'			=> 'input-button-danger',
			'label' 		=> 'Button danger color',
			'desc'			=> 'Choose custom background and border color to use for the danger button.',
			'type' 			=> 'input-group',
			'group'			=> array(
				array('name' => 'button[danger][background]', 'type' => 'color', 'value' => '#d9534f', 'rules' => 'required'),
				array('name' => 'button[danger][border]', 'type' => 'color', 'value' => '#d43f3a', 'rules' => 'required'),
			)
		),
	)
);

$theme['customize']['sections']['custom_css'] = array(
	'title'		=> 'Custom CSS',
	'desc'		=> '',
	'icon'		=> '',
	'fields'	=> array(
		array('id' => 'input-custom-css', 'name' => 'custom_css', 'label' => 'Custom CSS', 'desc' => 'Paste your custom CSS code here.', 'type' => 'textarea', 'rows' => '15', 'value' => '')
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

// Set accepted post item for updating the admin theme customisation.
$theme['customize']['post_items'] = array('logo_height', 'logo_padding_top', 'logo_padding_bottom', 'font_family', 'font_weight', 'font_size',
    'font_color', 'body', 'header', 'sidebar', 'link', 'button', 'custom_css');


/* End of file theme_config.php */
/* Location: ./main/views/themes/tastyigniter-orange/theme_config.php */