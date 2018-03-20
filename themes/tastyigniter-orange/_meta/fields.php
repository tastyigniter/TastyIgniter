<?php

/**
 * Theme config file
 *
 */

$backgroundOptions = [
    'contain'  => 'Contain',
    'tiled'    => 'Tiled',
    'cover'    => 'Cover',
    'centered' => 'Centered',
];

return [
    // Set form fields for the admin theme customisation.
    'form' => [
        'general'       => [
            'title'   => 'General',
            'comment' => '',
            'icon'    => '',
            'fields'  => [
                'display_crumbs'   => [
                    'label'   => 'Display Breadcrumbs',
                    'type'    => 'switch',
                    'default' => 1,
                    'rules'   => 'required|numeric',
                ],
                'hide_admin_link'  => [
                    'label' => 'Hide footer admin link',
                    'type'  => 'switch',
                    'rules' => 'required|numeric',
                ],
                'ga_tracking_code' => [
                    'label'     => 'GA Tracking Code',
                    'type'      => 'textarea',
                    'comment'   => 'Paste your Google Analytics Tracking Code here.',
                    'attribute' => [
                        'rows' => '10',
                    ],
                ],
            ],
        ],
        'main_body'     => [
            'title'   => 'Typography - Main body',
            'comment' => '',
            'icon'    => '',
            'fields'  => [
                'font[family]' => [
                    'label'   => 'Font Family',
                    'type'    => 'text',
                    'default' => '"Titillium Web",Arial,sans-serif',
                    'comment' => 'The font family to use for the main body text.',
                    'rules'   => 'required',
                ],
                'font[weight]' => [
                    'label'   => 'Font Weight',
                    'type'    => 'select',
                    'comment' => 'The font weight and style to use for the main body text.',
                    'rules'   => 'required|alpha',
                    'default' => 'normal',
                    'options' => [
                        'normal'  => 'Normal',
                        'bold'    => 'Bold',
                        'bolder'  => 'Bolder',
                        'lighter' => 'Lighter',
                    ],
                ],
                'font[style]'  => [
                    'label'   => 'Font Style',
                    'type'    => 'select',
                    'rules'   => 'required|alpha',
                    'default' => 'normal',
                    'options' => [
                        'normal' => 'Normal',
                        'italic' => 'Italic',
                    ],
                ],
                'font[size]'   => [
                    'label'      => 'Font Size',
                    'comment'    => 'The font size and color to use for the main body text.',
                    'type'       => 'text',
                    'addonRight' => 'px',
                    'default'    => '13',
                    'rules'      => 'required|numeric',
                ],
                'font[color]'  => [
                    'label'   => 'Font Color',
                    'type'    => 'colorpicker',
                    'default' => '#333333',
                    'rules'   => 'required',
                ],
            ],
        ],
        'main_menu'     => [
            'title'   => 'Typography - Main Menu',
            'comment' => '',
            'icon'    => '',
            'fields'  => [
                'menu_font[family]' => [
                    'label'   => 'Font family',
                    'comment' => 'The font family to use for the header menu.',
                    'type'    => 'text',
                    'default' => '"Titillium Web",Arial,sans-serif',
                    'rules'   => 'required',
                ],
                'menu_font[weight]' => [
                    'label'   => 'Font weight',
                    'type'    => 'select',
                    'comment' => 'The font weight to use for the header menu.',
                    'default' => 'normal',
                    'rules'   => 'required|alpha',
                    'options' => [
                        'normal'  => 'Normal',
                        'bold'    => 'Bold',
                        'bolder'  => 'Bolder',
                        'lighter' => 'Lighter',
                    ],
                ],
                'menu_font[style]'  => [
                    'label'   => 'Font style',
                    'comment' => 'The font style to use for the header menu.',
                    'type'    => 'select',
                    'options' => [
                        'normal' => 'Normal',
                        'italic' => 'Italic',
                    ],
                    'default' => 'normal',
                    'rules'   => 'required|alpha',
                ],
                'menu_font[size]'   => [
                    'label'      => 'Font size',
                    'comment'    => 'The font size to use for the header menu.',
                    'type'       => 'addon',
                    'addonRight' => 'px',
                    'default'    => '16',
                    'rules'      => 'required|numeric',
                ],
                'menu_font[color]'  => [
                    'label'   => 'Font color',
                    'comment' => 'The font color to use for the header menu.',
                    'type'    => 'colorpicker',
                    'default' => '#FFF',
                    'rules'   => 'required',
                ],
            ],
        ],
        'body'          => [
            'title'   => 'Styling - Body',
            'comment' => '',
            'icon'    => '',
            'fields'  => [
                'body[background_type]' => [
                    'label'   => 'Body background',
                    'comment' => 'The background color or image to use for the body body background and how the image is displayed.',
                    'type'    => 'radio',
                    'span'    => 'left',
                    'default' => 'color',
                    'options' => [
                        'color' => 'Color',
                        'image' => 'Image',
                    ],
                ],
                'body[foreground]'      => [
                    'label'   => 'Body foreground color',
                    'type'    => 'colorpicker',
                    'span'    => 'right',
                    'comment' => 'The color to use for the foreground.',
                    'default' => '#FFF',
                    'rules'   => 'required',
                ],
                'body[background]'      => [
                    'label'   => 'Body background color',
                    'type'    => 'colorpicker',
                    'default' => '#F5F5F5',
                    'rules'   => 'required',
                    'trigger' => [
                        'action'    => 'hide',
                        'field'     => 'body[background_type]',
                        'condition' => 'value[image]',
                    ],
                ],
                'body[image]'           => [
                    'label'   => 'Body background image',
                    'type'    => 'mediafinder',
                    'trigger' => [
                        'action'    => 'show',
                        'field'     => 'body[background_type]',
                        'condition' => 'value[image]',
                    ],
                ],
                'body[display]'         => [
                    'label'   => 'Body background display',
                    'type'    => 'select',
                    'options' => $backgroundOptions,
                    'rules'   => 'required',
                    'trigger' => [
                        'action'    => 'show',
                        'field'     => 'body[background_type]',
                        'condition' => 'value[image]',
                    ],
                ],
                'body[color]'           => [
                    'label'   => 'Body general color',
                    'type'    => 'colorpicker',
                    'span'    => 'left',
                    'default' => '#ed561a',
                    'rules'   => 'required',
                ],
                'body[border]'          => [
                    'label'   => 'Body general border color',
                    'type'    => 'colorpicker',
                    'span'    => 'right',
                    'default' => '#DDD',
                    'rules'   => 'required',
                ],
                'link[color]'           => [
                    'label'   => 'Link normal color',
                    'type'    => 'colorpicker',
                    'span'    => 'left',
                    'comment' => 'The normal color to use for links.',
                    'default' => '#337AB7',
                    'rules'   => 'required',
                ],
                'link[hover]'           => [
                    'label'   => 'Link hover color',
                    'comment' => 'The hover color to use for links.',
                    'type'    => 'colorpicker',
                    'span'    => 'right',
                    'default' => '#23527C',
                    'rules'   => 'required',
                ],
            ],
        ],
        'heading'       => [
            'title'   => 'Styling - Heading',
            'comment' => '',
            'icon'    => '',
            'fields'  => [
                'heading[background_type]' => [
                    'label'   => 'Body background',
                    'comment' => 'The background color or image to use for the page heading and how the image is displayed.',
                    'type'    => 'radio',
                    'default' => 'color',
                    'options' => [
                        'color' => 'Color',
                        'image' => 'Image',
                    ],
                ],
                'heading[background]'      => [
                    'label'   => 'Header color',
                    'type'    => 'colorpicker',
                    'trigger' => [
                        'action'    => 'hide',
                        'field'     => 'heading[background_type]',
                        'condition' => 'value[image]',
                    ],
                ],
                'heading[image]'           => [
                    'label'   => 'Heading image',
                    'type'    => 'mediafinder',
                    'trigger' => [
                        'action'    => 'show',
                        'field'     => 'heading[background_type]',
                        'condition' => 'value[image]',
                    ],
                ],
                'heading[display]'         => [
                    'label'   => 'Heading display',
                    'type'    => 'select',
                    'rules'   => 'required',
                    'options' => $backgroundOptions,
                    'trigger' => [
                        'action'    => 'show',
                        'field'     => 'heading[background_type]',
                        'condition' => 'value[image]',
                    ],
                ],
                'heading[color]'           => [
                    'label'   => 'Page heading font color',
                    'comment' => 'The color to use for the page heading font/icons.',
                    'type'    => 'colorpicker',
                    'default' => '#333',
                    'rules'   => 'required',
                ],
                'heading[under_image]'     => [
                    'label'   => 'Page under-heading image',
                    'comment' => 'The image to use for the page under-heading image.',
                    'type'    => 'mediafinder',
                    'default' => '',
                    'rules'   => '',
                ],
                'heading[under_height]'    => [
                    'label'      => 'Page under-heading height',
                    'comment'    => 'The height to use for the page under-heading height.',
                    'type'       => 'addon',
                    'addonRight' => 'px',
                    'default'    => '50',
                    'rules'      => 'numeric',
                ],
            ],
        ],
        'button_colors' => [
            'title'   => 'Styling - Button Colors',
            'comment' => '',
            'icon'    => '',
            'fields'  => [
                'button[default][background]' => [
                    'label'   => 'Default background color',
                    'type'    => 'colorpicker',
                    'default' => '#E7E7E7',
                    'rules'   => 'required',
                ],
                'button[default][border]'     => [
                    'label'   => 'Default border color',
                    'type'    => 'colorpicker',
                    'span'    => 'left',
                    'default' => '#E7E7E7',
                    'rules'   => 'required',
                ],
                'button[default][font]'       => [
                    'label'   => 'Default font color',
                    'type'    => 'colorpicker',
                    'span'    => 'right',
                    'rules'   => 'required',
                    'default' => '#333333',
                ],
                'button[primary][background]' => [
                    'label'   => 'Primary background color',
                    'type'    => 'colorpicker',
                    'default' => '#428bca',
                    'rules'   => 'required',
                ],
                'button[primary][border]'     => [
                    'label'   => 'Primary border color',
                    'type'    => 'colorpicker',
                    'span'    => 'left',
                    'default' => '#428bca',
                    'rules'   => 'required',
                ],
                'button[primary][font]'       => [
                    'label'   => 'Primary font color',
                    'type'    => 'colorpicker',
                    'span'    => 'right',
                    'default' => '#FFFFFF',
                    'rules'   => 'required',
                ],
                'button[success][background]' => [
                    'label'   => 'Success background color',
                    'type'    =>
                        'colorpicker',
                    'default' => '#5cb85c',
                    'rules'   => 'required',
                ],
                'button[success][border]'     => [
                    'label'   => 'Success border color',
                    'type'    => 'colorpicker',
                    'span'    => 'left',
                    'default' => '#5cb85c',
                    'rules'   => 'required',
                ],
                'button[success][font]'       => [
                    'label'   => 'Success font color',
                    'type'    => 'colorpicker',
                    'span'    => 'right',
                    'default' => '#FFFFFF',
                    'rules'   => 'required',
                ],
                'button[info][background]'    => [
                    'label'   => 'Info background color',
                    'type'    => 'colorpicker',
                    'default' => '#5BC0DE',
                    'rules'   => 'required',
                ],
                'button[info][border]'        => [
                    'label'   => 'Info border color',
                    'type'    => 'colorpicker',
                    'span'    => 'left',
                    'default' => '#5BC0DE',
                    'rules'   => 'required',
                ],
                'button[info][font]'          => [
                    'label'   => 'Info font color',
                    'type'    => 'colorpicker',
                    'span'    => 'right',
                    'default' => '#FFFFFF',
                    'rules'   => 'required',
                ],
                'button[warning][background]' => [
                    'label'   => 'Warning background color',
                    'type'    => 'colorpicker',
                    'default' => '#f0ad4e',
                    'rules'   => 'required',
                ],
                'button[warning][border]'     => [
                    'label'   => 'Warning border color',
                    'type'    => 'colorpicker',
                    'span'    => 'left',
                    'default' => '#f0ad4e',
                    'rules'   => 'required',
                ],
                'button[warning][font]'       => [
                    'label'   => 'Warning font color',
                    'type'    => 'colorpicker',
                    'span'    => 'right',
                    'default' => '#FFFFFF',
                    'rules'   => 'required',
                ],
                'button[danger][background]'  => [
                    'label'   => 'Danger background color',
                    'type'    => 'colorpicker',
                    'default' => '#d9534f',
                    'rules'   => 'required',
                ],
                'button[danger][border]'      => [
                    'label'   => 'Danger border color',
                    'type'    => 'colorpicker',
                    'span'    => 'left',
                    'default' => '#d9534f',
                    'rules'   => 'required',
                ],
                'button[danger][font]'        => [
                    'label'   => 'Danger font color',
                    'type'    => 'colorpicker',
                    'span'    => 'right',
                    'default' => '#FFFFFF',
                    'rules'   => 'required',
                ],
            ],
        ],
        'sidebar'       => [
            'title'   => 'Sidebar',
            'comment' => '',
            'icon'    => '',
            'fields'  => [
                'sidebar[background_type]' => [
                    'label'   => 'Sidebar background',
                    'comment' => 'The background color or image to use for the sidebar background and how the image is displayed.',
                    'type'    => 'radio',
                    'default' => 'color',
                    'options' => [
                        'color' => 'Color',
                        'image' => 'Image',
                    ],
                ],
                'sidebar[background]'      => [
                    'label'   => 'Sidebar background color',
                    'type'    => 'colorpicker',
                    'default' => '#FFFFFF',
                    'rules'   => 'required',
                    'trigger' => [
                        'action'    => 'hide',
                        'field'     => 'sidebar[background_type]',
                        'condition' => 'value[image]',
                    ],
                ],
                'sidebar[image]'           => [
                    'label'   => 'Sidebar background image',
                    'type'    => 'mediafinder',
                    'trigger' => [
                        'action'    => 'show',
                        'field'     => 'sidebar[background_type]',
                        'condition' => 'value[image]',
                    ],
                ],
                'sidebar[display]'         => [
                    'label'   => 'Sidebar background display',
                    'type'    => 'select',
                    'options' => $backgroundOptions,
                    'default' => 'contain',
                    'rules'   => 'required',
                    'trigger' => [
                        'action'    => 'show',
                        'field'     => 'sidebar[background_type]',
                        'condition' => 'value[image]',
                    ],
                ],
                'sidebar[font]'            => [
                    'label'   => 'Sidebar font',
                    'comment' => 'The font and border color to use for the sidebar.',
                    'type'    => 'colorpicker',
                    'default' => '#484848',
                    'rules'   => 'required',
                ],
                'sidebar[border]'          => [
                    'label'   => 'Sidebar border',
                    'type'    => 'colorpicker',
                    'default' => '#EEEEEE',
                    'rules'   => 'required',
                ],
            ],
        ],
        'header'        => [
            'title'   => 'Header',
            'comment' => '',
            'icon'    => '',
            'fields'  => [
                'header[background_type]'     => [
                    'label'   => 'Header background',
                    'comment' => 'The background color or image to use for the top header and how the image is displayed.',
                    'type'    => 'radio',
                    'default' => 'color',
                    'options' => [
                        'color' => 'Color',
                        'image' => 'Image',
                    ],
                ],
                'header[background]'          => [
                    'label'   => 'Header background color',
                    'type'    => 'colorpicker',
                    'default' => '#ED561A',
                    'rules'   => 'required',
                    'trigger' => [
                        'action'    => 'hide',
                        'field'     => 'header[background_type]',
                        'condition' => 'value[image]',
                    ],
                ],
                'header[image]'               => [
                    'label'   => 'Header background image',
                    'type'    => 'mediafinder',
                    'trigger' => [
                        'action'    => 'show',
                        'field'     => 'header[background_type]',
                        'condition' => 'value[image]',
                    ],
                ],
                'header[display]'             => [
                    'label'   => 'Header background image display',
                    'type'    => 'select',
                    'default' => 'contain',
                    'options' => $backgroundOptions,
                    'rules'   => 'required',
                    'trigger' => [
                        'action'    => 'show',
                        'field'     => 'header[background_type]',
                        'condition' => 'value[image]',
                    ],
                ],
                'header[dropdown_background]' => [
                    'label'   => 'Dropdown background color',
                    'comment' => 'The background color to use for the top header dropdown.',
                    'type'    => 'colorpicker',
                    'default' => '#ED561A',
                    'rules'   => 'required',
                ],
                'header[color]'               => [
                    'label'   => 'Header dropdown font color',
                    'comment' => 'The color to use for the top header dropdown font.',
                    'type'    => 'colorpicker',
                    'default' => '#FFF',
                    'rules'   => 'required',
                ],
            ],
        ],
        'logo'          => [
            'title'   => 'Header - Logo',
            'comment' => '',
            'icon'    => '',
            'fields'  => [
                'logo_image'          => [
                    'label'   => 'Logo',
                    'comment' => 'Upload custom logo or text to your website.',
                    'type'    => 'mediafinder',
                ],
                'logo_text'           => [
                    'label' => 'Logo',
                    'type'  => 'text',
                ],
                'logo_height'         => [
                    'label'      => 'Logo Height',
                    'type'       => 'addon',
                    'addonRight' => 'px',
                    'comment'    => 'Default: 40',
                    'default'    => '40',
                    'rules'      => 'required|numeric',
                ],
                'logo_padding_top'    => [
                    'label'      => 'Logo padding',
                    'type'       => 'addon',
                    'addonRight' => 'px',
                    'comment'    => 'The top and bottom padding for the logo.',
                    'default'    => '10',
                    'rules'      => 'numeric',
                ],
                'logo_padding_bottom' => [
                    'label'      => 'Logo padding',
                    'type'       => 'addon',
                    'addonRight' => 'px',
                    'default'    => '10',
                    'rules'      => 'numeric',
                ],
            ],
        ],
        'favicon'       => [
            'title'   => 'Header - Favicon',
            'comment' => '',
            'icon'    => '',
            'fields'  => [
                'favicon' => [
                    'label'   => 'Favicon',
                    'type'    => 'mediafinder',
                    'comment' => 'Upload your favicon ( png, ico, jpg, gif or bmp ).',
                ],
            ],
        ],
        'footer'        => [
            'title'   => 'Footer',
            'comment' => '',
            'icon'    => '',
            'fields'  => [
                'footer[background_type]'        => [
                    'label'   => 'Footer background',
                    'comment' => 'The background color or image to use for the main footer and how the image is displayed.',
                    'type'    => 'radio',
                    'default' => 'color',
                    'options' => [
                        'color' => 'Color',
                        'image' => 'Image',
                    ],
                ],
                'footer[background]'             => [
                    'label'   => 'Footer background color',
                    'type'    => 'colorpicker',
                    'default' => '#EDEFF1',
                    'rules'   => 'required',
                    'trigger' => [
                        'action'    => 'hide',
                        'field'     => 'footer[background_type]',
                        'condition' => 'value[image]',
                    ],
                ],
                'footer[image]'                  => [
                    'label'   => 'Footer background',
                    'type'    => 'mediafinder',
                    'trigger' => [
                        'action'    => 'show',
                        'field'     => 'footer[background_type]',
                        'condition' => 'value[image]',
                    ],
                ],
                'footer[display]'                => [
                    'label'   => 'Footer background',
                    'type'    => 'select',
                    'options' => $backgroundOptions,
                    'default' => 'contain',
                    'rules'   => 'required',
                    'trigger' => [
                        'action'    => 'show',
                        'field'     => 'footer[background_type]',
                        'condition' => 'value[image]',
                    ],
                ],
                'footer[bottom_background_type]' => [
                    'label'   => 'Bottom footer background',
                    'comment' => 'The background color or image to use for the bottom footer and how the image is displayed.',
                    'type'    => 'radio',
                    'default' => 'color',
                    'options' => [
                        'color' => 'Color',
                        'image' => 'Image',
                    ],
                ],
                'footer[bottom_background]'      => [
                    'label'   => 'Bottom footer background color',
                    'type'    => 'colorpicker',
                    'default' => '#FBFBFB',
                    'rules'   => 'required',
                    'trigger' => [
                        'action'    => 'hide',
                        'field'     => 'footer[bottom_background_type]',
                        'condition' => 'value[image]',
                    ],
                ],
                'footer[bottom_image]'           => [
                    'label'   => 'Bottom footer background',
                    'type'    => 'mediafinder',
                    'default' => '',
                    'trigger' => [
                        'action'    => 'show',
                        'field'     => 'footer[bottom_background_type]',
                        'condition' => 'value[image]',
                    ],
                ],
                'footer[bottom_display]'         => [
                    'label'   => 'Bottom footer background',
                    'type'    => 'select',
                    'options' => $backgroundOptions,
                    'default' => 'contain',
                    'rules'   => 'required',
                    'trigger' => [
                        'action'    => 'show',
                        'field'     => 'footer[bottom_background_type]',
                        'condition' => 'value[image]',
                    ],
                ],
                'footer[footer_color]'           => [
                    'label'   => 'Footer font color',
                    'comment' => 'The font color to use for the main and bottom footer.',
                    'type'    => 'colorpicker',
                    'default' => '#9BA1A7',
                    'rules'   => 'required',
                ],
                'footer[bottom_footer_color]'    => [
                    'label'   => 'Footer font color',
                    'type'    => 'colorpicker',
                    'default' => '#A3AAAF',
                    'rules'   => 'required',
                ],
            ],
        ],
        'social'        => [
            'title'   => 'Social',
            'comment' => 'Add full URL for your social network profiles',
            'icon'    => '',
            'fields'  => [
                'social[facebook]'   => [
                    'label'   => 'Facebook',
                    'type'    => 'text',
                    'default' => '#',
                ],
                'social[twitter]'    => [
                    'label'   => 'Twitter',
                    'type'    => 'text',
                    'default' => '#',
                ],
                'social[google]'     => [
                    'label'   => 'Google +',
                    'type'    => 'text',
                    'default' => '#',
                ],
                'social[youtube]'    => [
                    'label'   => 'Youtube',
                    'type'    => 'text',
                    'default' => '#',
                ],
                'social[vimeo]'      => [
                    'label' => 'Vimeo',
                    'type'  => 'text',
                ],
                'social[linkedin]'   => [
                    'label' => 'LinkedIn',
                    'type'  => 'text',
                ],
                'social[pinterest]'  => [
                    'label' => 'Pinterest',
                    'type'  => 'text',
                ],
                'social[tumblr]'     => [
                    'label' => 'Tumblr',
                    'type'  => 'text',
                ],
                'social[flickr]'     => [
                    'label' => 'Flickr',
                    'type'  => 'text',
                ],
                'social[instagram]'  => [
                    'label' => 'Instagram',
                    'type'  => 'text',
                ],
                'social[dribbble]'   => [
                    'label' => 'Dribbble',
                    'type'  => 'text',
                ],
                'social[foursquare]' => [
                    'label' => 'Foursquare',
                    'type'  => 'text',
                ],
            ],
        ],
        'custom_script' => [
            'title'   => 'Custom Scripts',
            'comment' => '',
            'icon'    => '',
            'fields'  => [
                'custom_script[css]'    => [
                    'label'   => 'Add custom CSS',
                    'comment' => 'Paste your custom CSS code here.',
                    'type'    => 'textarea',
                    'rows'    => '9',
                ],
                'custom_script[head]'   => [
                    'label'   => 'Add custom Javascript to header',
                    'comment' => 'Paste your custom Javascript code here.',
                    'type'    => 'textarea',
                    'rows'    => '9',
                ],
                'custom_script[footer]' => [
                    'label'   => 'Add custom Javascript to footer',
                    'comment' => 'Paste your custom Javascript code here.',
                    'type'    => 'textarea',
                    'rows'    => '9',
                ],
            ],
        ],
    ],
];
//$fields['sections']['general'] = [
//    'title'   => 'General',
//    'comment' => '',
//    'icon'    => '',
//    'fields'  => [
//        'display_crumbs'   => [
//            'label'   => 'Display Breadcrumbs',
//            'type'    => 'switch',
//            'default' => 1,
//            'rules'   => 'required|numeric',
//        ],
//        'hide_admin_link'  => [
//            'label' => 'Hide footer admin link',
//            'type'  => 'switch',
//            'rules' => 'required|numeric',
//        ],
//        'ga_tracking_code' => [
//            'label'     => 'GA Tracking Code',
//            'type'      => 'textarea',
//            'comment'   => 'Paste your Google Analytics Tracking Code here.',
//            'attribute' => [
//                'rows' => '10',
//            ],
//        ],
//    ],
//];
//
//$fields['sections']['main_body'] = [
//    'title'   => 'Typography - Main body',
//    'comment' => '',
//    'icon'    => '',
//    'fields'  => [
//        'font[family]' => [
//            'label'   => 'Font Family',
//            'type'    => 'text',
//            'default' => '"Titillium Web",Arial,sans-serif',
//            'comment' => 'The font family to use for the main body text.',
//            'rules'   => 'required',
//        ],
//        'font[weight]' => [
//            'label'   => 'Font Weight',
//            'type'    => 'select',
//            'comment' => 'The font weight and style to use for the main body text.',
//            'rules'   => 'required|alpha',
//            'default' => 'normal',
//            'options' => [
//                'normal'  => 'Normal',
//                'bold'    => 'Bold',
//                'bolder'  => 'Bolder',
//                'lighter' => 'Lighter',
//            ],
//        ],
//        'font[style]'  => [
//            'label'   => 'Font Style',
//            'type'    => 'select',
//            'rules'   => 'required|alpha',
//            'default' => 'normal',
//            'options' => [
//                'normal' => 'Normal',
//                'italic' => 'Italic',
//            ],
//        ],
//        'font[size]'   => [
//            'label'      => 'Font Size',
//            'comment'    => 'The font size and color to use for the main body text.',
//            'type'       => 'text',
//            'addonRight' => 'px',
//            'default'    => '13',
//            'rules'      => 'required|numeric',
//        ],
//        'font[color]'  => [
//            'label'   => 'Font Color',
//            'type'    => 'colorpicker',
//            'default' => '#333333',
//            'rules'   => 'required',
//        ],
//    ],
//];
//
//$fields['sections']['main_menu'] = [
//    'title'   => 'Typography - Main Menu',
//    'comment' => '',
//    'icon'    => '',
//    'fields'  => [
//        'menu_font[family]' => [
//            'label'   => 'Font family',
//            'comment' => 'The font family to use for the header menu.',
//            'type'    => 'text',
//            'default' => '"Titillium Web",Arial,sans-serif',
//            'rules'   => 'required',
//        ],
//        'menu_font[weight]' => [
//            'label'   => 'Font weight',
//            'type'    => 'select',
//            'comment' => 'The font weight to use for the header menu.',
//            'default' => 'normal',
//            'rules'   => 'required|alpha',
//            'options' => [
//                'normal'  => 'Normal',
//                'bold'    => 'Bold',
//                'bolder'  => 'Bolder',
//                'lighter' => 'Lighter',
//            ],
//        ],
//        'menu_font[style]'  => [
//            'label'   => 'Font style',
//            'comment' => 'The font style to use for the header menu.',
//            'type'    => 'select',
//            'options' => [
//                'normal' => 'Normal',
//                'italic' => 'Italic',
//            ],
//            'default' => 'normal',
//            'rules'   => 'required|alpha',
//        ],
//        'menu_font[size]'   => [
//            'label'      => 'Font size',
//            'comment'    => 'The font size to use for the header menu.',
//            'type'       => 'addon',
//            'addonRight' => 'px',
//            'default'    => '16',
//            'rules'      => 'required|numeric',
//        ],
//        'menu_font[color]'  => [
//            'label'   => 'Font color',
//            'comment' => 'The font color to use for the header menu.',
//            'type'    => 'colorpicker',
//            'default' => '#FFF',
//            'rules'   => 'required',
//        ],
//    ],
//];
//
//$fields['sections']['body'] = [
//    'title'   => 'Styling - Body',
//    'comment' => '',
//    'icon'    => '',
//    'fields'  => [
//        'body[background_type]' => [
//            'label'   => 'Body background',
//            'comment' => 'The background color or image to use for the body body background and how the image is displayed.',
//            'type'    => 'radio',
//            'span'    => 'left',
//            'default' => 'color',
//            'options' => [
//                'color' => 'Color',
//                'image' => 'Image',
//            ],
//        ],
//        'body[foreground]'      => [
//            'label'   => 'Body foreground color',
//            'type'    => 'colorpicker',
//            'span'    => 'right',
//            'comment' => 'The color to use for the foreground.',
//            'default' => '#FFF',
//            'rules'   => 'required',
//        ],
//        'body[background]'      => [
//            'label'   => 'Body background color',
//            'type'    => 'colorpicker',
//            'default' => '#F5F5F5',
//            'rules'   => 'required',
//            'trigger' => [
//                'action'    => 'hide',
//                'field'     => 'body[background_type]',
//                'condition' => 'value[image]',
//            ],
//        ],
//        'body[image]'           => [
//            'label'   => 'Body background image',
//            'type'    => 'mediafinder',
//            'trigger' => [
//                'action'    => 'show',
//                'field'     => 'body[background_type]',
//                'condition' => 'value[image]',
//            ],
//        ],
//        'body[display]'         => [
//            'label'   => 'Body background display',
//            'type'    => 'select',
//            'options' => $backgroundOptions,
//            'rules'   => 'required',
//            'trigger' => [
//                'action'    => 'show',
//                'field'     => 'body[background_type]',
//                'condition' => 'value[image]',
//            ],
//        ],
//        'body[color]'           => [
//            'label'   => 'Body general color',
//            'type'    => 'colorpicker',
//            'span'    => 'left',
//            'default' => '#ed561a',
//            'rules'   => 'required',
//        ],
//        'body[border]'          => [
//            'label'   => 'Body general border color',
//            'type'    => 'colorpicker',
//            'span'    => 'right',
//            'default' => '#DDD',
//            'rules'   => 'required',
//        ],
//        'link[color]'           => [
//            'label'   => 'Link normal color',
//            'type'    => 'colorpicker',
//            'span'    => 'left',
//            'comment' => 'The normal color to use for links.',
//            'default' => '#337AB7',
//            'rules'   => 'required',
//        ],
//        'link[hover]'           => [
//            'label'   => 'Link hover color',
//            'comment' => 'The hover color to use for links.',
//            'type'    => 'colorpicker',
//            'span'    => 'right',
//            'default' => '#23527C',
//            'rules'   => 'required',
//        ],
//    ],
//];
//
//$fields['sections']['heading'] = [
//    'title'   => 'Styling - Heading',
//    'comment' => '',
//    'icon'    => '',
//    'fields'  => [
//        'heading[background_type]' => [
//            'label'   => 'Body background',
//            'comment' => 'The background color or image to use for the page heading and how the image is displayed.',
//            'type'    => 'radio',
//            'default' => 'color',
//            'options' => [
//                'color' => 'Color',
//                'image' => 'Image',
//            ],
//        ],
//        'heading[background]'      => [
//            'label'   => 'Header color',
//            'type'    => 'colorpicker',
//            'trigger' => [
//                'action'    => 'hide',
//                'field'     => 'heading[background_type]',
//                'condition' => 'value[image]',
//            ],
//        ],
//        'heading[image]'           => [
//            'label'   => 'Heading image',
//            'type'    => 'mediafinder',
//            'trigger' => [
//                'action'    => 'show',
//                'field'     => 'heading[background_type]',
//                'condition' => 'value[image]',
//            ],
//        ],
//        'heading[display]'         => [
//            'label'   => 'Heading display',
//            'type'    => 'select',
//            'rules'   => 'required',
//            'options' => $backgroundOptions,
//            'trigger' => [
//                'action'    => 'show',
//                'field'     => 'heading[background_type]',
//                'condition' => 'value[image]',
//            ],
//        ],
//        'heading[color]'           => [
//            'label'   => 'Page heading font color',
//            'comment' => 'The color to use for the page heading font/icons.',
//            'type'    => 'colorpicker',
//            'default' => '#333',
//            'rules'   => 'required',
//        ],
//        'heading[under_image]'     => [
//            'label'   => 'Page under-heading image',
//            'comment' => 'The image to use for the page under-heading image.',
//            'type'    => 'mediafinder',
//            'default' => '',
//            'rules'   => '',
//        ],
//        'heading[under_height]'    => [
//            'label'      => 'Page under-heading height',
//            'comment'    => 'The height to use for the page under-heading height.',
//            'type'       => 'addon',
//            'addonRight' => 'px',
//            'default'    => '50',
//            'rules'      => 'numeric',
//        ],
//    ],
//];
//
//$fields['sections']['button_colors'] = [
//    'title'   => 'Styling - Button Colors',
//    'comment' => '',
//    'icon'    => '',
//    'fields'  => [
//        'button[default][background]' => [
//            'label'   => 'Default background color',
//            'type'    => 'colorpicker',
//            'default' => '#E7E7E7',
//            'rules'   => 'required',
//        ],
//        'button[default][border]'     => [
//            'label'   => 'Default border color',
//            'type'    => 'colorpicker',
//            'span'    => 'left',
//            'default' => '#E7E7E7',
//            'rules'   => 'required',
//        ],
//        'button[default][font]'       => [
//            'label'   => 'Default font color',
//            'type'    => 'colorpicker',
//            'span'    => 'right',
//            'rules'   => 'required',
//            'default' => '#333333',
//        ],
//        'button[primary][background]' => [
//            'label'   => 'Primary background color',
//            'type'    => 'colorpicker',
//            'default' => '#428bca',
//            'rules'   => 'required',
//        ],
//        'button[primary][border]'     => [
//            'label'   => 'Primary border color',
//            'type'    => 'colorpicker',
//            'span'    => 'left',
//            'default' => '#428bca',
//            'rules'   => 'required',
//        ],
//        'button[primary][font]'       => [
//            'label'   => 'Primary font color',
//            'type'    => 'colorpicker',
//            'span'    => 'right',
//            'default' => '#FFFFFF',
//            'rules'   => 'required',
//        ],
//        'button[success][background]' => [
//            'label'   => 'Success background color',
//            'type'    =>
//                'colorpicker',
//            'default' => '#5cb85c',
//            'rules'   => 'required',
//        ],
//        'button[success][border]'     => [
//            'label'   => 'Success border color',
//            'type'    => 'colorpicker',
//            'span'    => 'left',
//            'default' => '#5cb85c',
//            'rules'   => 'required',
//        ],
//        'button[success][font]'       => [
//            'label'   => 'Success font color',
//            'type'    => 'colorpicker',
//            'span'    => 'right',
//            'default' => '#FFFFFF',
//            'rules'   => 'required',
//        ],
//        'button[info][background]'    => [
//            'label'   => 'Info background color',
//            'type'    => 'colorpicker',
//            'default' => '#5BC0DE',
//            'rules'   => 'required',
//        ],
//        'button[info][border]'        => [
//            'label'   => 'Info border color',
//            'type'    => 'colorpicker',
//            'span'    => 'left',
//            'default' => '#5BC0DE',
//            'rules'   => 'required',
//        ],
//        'button[info][font]'          => [
//            'label'   => 'Info font color',
//            'type'    => 'colorpicker',
//            'span'    => 'right',
//            'default' => '#FFFFFF',
//            'rules'   => 'required',
//        ],
//        'button[warning][background]' => [
//            'label'   => 'Warning background color',
//            'type'    => 'colorpicker',
//            'default' => '#f0ad4e',
//            'rules'   => 'required',
//        ],
//        'button[warning][border]'     => [
//            'label'   => 'Warning border color',
//            'type'    => 'colorpicker',
//            'span'    => 'left',
//            'default' => '#f0ad4e',
//            'rules'   => 'required',
//        ],
//        'button[warning][font]'       => [
//            'label'   => 'Warning font color',
//            'type'    => 'colorpicker',
//            'span'    => 'right',
//            'default' => '#FFFFFF',
//            'rules'   => 'required',
//        ],
//        'button[danger][background]'  => [
//            'label'   => 'Danger background color',
//            'type'    => 'colorpicker',
//            'default' => '#d9534f',
//            'rules'   => 'required',
//        ],
//        'button[danger][border]'      => [
//            'label'   => 'Danger border color',
//            'type'    => 'colorpicker',
//            'span'    => 'left',
//            'default' => '#d9534f',
//            'rules'   => 'required',
//        ],
//        'button[danger][font]'        => [
//            'label'   => 'Danger font color',
//            'type'    => 'colorpicker',
//            'span'    => 'right',
//            'default' => '#FFFFFF',
//            'rules'   => 'required',
//        ],
//    ],
//];
//
//$fields['sections']['sidebar'] = [
//    'title'   => 'Sidebar',
//    'comment' => '',
//    'icon'    => '',
//    'fields'  => [
//        'sidebar[background_type]' => [
//            'label'   => 'Sidebar background',
//            'comment' => 'The background color or image to use for the sidebar background and how the image is displayed.',
//            'type'    => 'radio',
//            'default' => 'color',
//            'options' => [
//                'color' => 'Color',
//                'image' => 'Image',
//            ],
//        ],
//        'sidebar[background]'      => [
//            'label'   => 'Sidebar background color',
//            'type'    => 'colorpicker',
//            'default' => '#FFFFFF',
//            'rules'   => 'required',
//            'trigger' => [
//                'action'    => 'hide',
//                'field'     => 'sidebar[background_type]',
//                'condition' => 'value[image]',
//            ],
//        ],
//        'sidebar[image]'           => [
//            'label'   => 'Sidebar background image',
//            'type'    => 'mediafinder',
//            'trigger' => [
//                'action'    => 'show',
//                'field'     => 'sidebar[background_type]',
//                'condition' => 'value[image]',
//            ],
//        ],
//        'sidebar[display]'         => [
//            'label'   => 'Sidebar background display',
//            'type'    => 'select',
//            'options' => $backgroundOptions,
//            'default' => 'contain',
//            'rules'   => 'required',
//            'trigger' => [
//                'action'    => 'show',
//                'field'     => 'sidebar[background_type]',
//                'condition' => 'value[image]',
//            ],
//        ],
//        'sidebar[font]'            => [
//            'label'   => 'Sidebar font',
//            'comment' => 'The font and border color to use for the sidebar.',
//            'type'    => 'colorpicker',
//            'default' => '#484848',
//            'rules'   => 'required',
//        ],
//        'sidebar[border]'          => [
//            'label'   => 'Sidebar border',
//            'type'    => 'colorpicker',
//            'default' => '#EEEEEE',
//            'rules'   => 'required',
//        ],
//    ],
//];
//
//$fields['sections']['header'] = [
//    'title'   => 'Header',
//    'comment' => '',
//    'icon'    => '',
//    'fields'  => [
//        'header[background_type]'     => [
//            'label'   => 'Header background',
//            'comment' => 'The background color or image to use for the top header and how the image is displayed.',
//            'type'    => 'radio',
//            'default' => 'color',
//            'options' => [
//                'color' => 'Color',
//                'image' => 'Image',
//            ],
//        ],
//        'header[background]'          => [
//            'label'   => 'Header background color',
//            'type'    => 'colorpicker',
//            'default' => '#ED561A',
//            'rules'   => 'required',
//            'trigger' => [
//                'action'    => 'hide',
//                'field'     => 'header[background_type]',
//                'condition' => 'value[image]',
//            ],
//        ],
//        'header[image]'               => [
//            'label'   => 'Header background image',
//            'type'    => 'mediafinder',
//            'trigger' => [
//                'action'    => 'show',
//                'field'     => 'header[background_type]',
//                'condition' => 'value[image]',
//            ],
//        ],
//        'header[display]'             => [
//            'label'   => 'Header background image display',
//            'type'    => 'select',
//            'default' => 'contain',
//            'options' => $backgroundOptions,
//            'rules'   => 'required',
//            'trigger' => [
//                'action'    => 'show',
//                'field'     => 'header[background_type]',
//                'condition' => 'value[image]',
//            ],
//        ],
//        'header[dropdown_background]' => [
//            'label'   => 'Dropdown background color',
//            'comment' => 'The background color to use for the top header dropdown.',
//            'type'    => 'colorpicker',
//            'default' => '#ED561A',
//            'rules'   => 'required',
//        ],
//        'header[color]'               => [
//            'label'   => 'Header dropdown font color',
//            'comment' => 'The color to use for the top header dropdown font.',
//            'type'    => 'colorpicker',
//            'default' => '#FFF',
//            'rules'   => 'required',
//        ],
//    ],
//];
//
//$fields['sections']['logo'] = [
//    'title'   => 'Header - Logo',
//    'comment' => '',
//    'icon'    => '',
//    'fields'  => [
//        'logo_image'          => [
//            'label'   => 'Logo',
//            'comment' => 'Upload custom logo or text to your website.',
//            'type'    => 'mediafinder',
//        ],
//        'logo_text'           => [
//            'label' => 'Logo',
//            'type'  => 'text',
//        ],
//        'logo_height'         => [
//            'label'      => 'Logo Height',
//            'type'       => 'addon',
//            'addonRight' => 'px',
//            'comment'    => 'Default: 40',
//            'default'    => '40',
//            'rules'      => 'required|numeric',
//        ],
//        'logo_padding_top'    => [
//            'label'      => 'Logo padding',
//            'type'       => 'addon',
//            'addonRight' => 'px',
//            'comment'    => 'The top and bottom padding for the logo.',
//            'default'    => '10',
//            'rules'      => 'numeric',
//        ],
//        'logo_padding_bottom' => [
//            'label'      => 'Logo padding',
//            'type'       => 'addon',
//            'addonRight' => 'px',
//            'default'    => '10',
//            'rules'      => 'numeric',
//        ],
//    ],
//];
//
//$fields['sections']['favicon'] = [
//    'title'   => 'Header - Favicon',
//    'comment' => '',
//    'icon'    => '',
//    'fields'  => [
//        'favicon' => [
//            'label'   => 'Favicon',
//            'type'    => 'mediafinder',
//            'comment' => 'Upload your favicon ( png, ico, jpg, gif or bmp ).',
//        ],
//    ],
//];
//
//$fields['sections']['footer'] = [
//    'title'   => 'Footer',
//    'comment' => '',
//    'icon'    => '',
//    'fields'  => [
//        'footer[background_type]'        => [
//            'label'   => 'Footer background',
//            'comment' => 'The background color or image to use for the main footer and how the image is displayed.',
//            'type'    => 'radio',
//            'default' => 'color',
//            'options' => [
//                'color' => 'Color',
//                'image' => 'Image',
//            ],
//        ],
//        'footer[background]'             => [
//            'label'   => 'Footer background color',
//            'type'    => 'colorpicker',
//            'default' => '#EDEFF1',
//            'rules'   => 'required',
//            'trigger' => [
//                'action'    => 'hide',
//                'field'     => 'footer[background_type]',
//                'condition' => 'value[image]',
//            ],
//        ],
//        'footer[image]'                  => [
//            'label'   => 'Footer background',
//            'type'    => 'mediafinder',
//            'trigger' => [
//                'action'    => 'show',
//                'field'     => 'footer[background_type]',
//                'condition' => 'value[image]',
//            ],
//        ],
//        'footer[display]'                => [
//            'label'   => 'Footer background',
//            'type'    => 'select',
//            'options' => $backgroundOptions,
//            'default' => 'contain',
//            'rules'   => 'required',
//            'trigger' => [
//                'action'    => 'show',
//                'field'     => 'footer[background_type]',
//                'condition' => 'value[image]',
//            ],
//        ],
//        'footer[bottom_background_type]' => [
//            'label'   => 'Bottom footer background',
//            'comment' => 'The background color or image to use for the bottom footer and how the image is displayed.',
//            'type'    => 'radio',
//            'default' => 'color',
//            'options' => [
//                'color' => 'Color',
//                'image' => 'Image',
//            ],
//        ],
//        'footer[bottom_background]'      => [
//            'label'   => 'Bottom footer background color',
//            'type'    => 'colorpicker',
//            'default' => '#FBFBFB',
//            'rules'   => 'required',
//            'trigger' => [
//                'action'    => 'hide',
//                'field'     => 'footer[bottom_background_type]',
//                'condition' => 'value[image]',
//            ],
//        ],
//        'footer[bottom_image]'           => [
//            'label'   => 'Bottom footer background',
//            'type'    => 'mediafinder',
//            'default' => '',
//            'trigger' => [
//                'action'    => 'show',
//                'field'     => 'footer[bottom_background_type]',
//                'condition' => 'value[image]',
//            ],
//        ],
//        'footer[bottom_display]'         => [
//            'label'   => 'Bottom footer background',
//            'type'    => 'select',
//            'options' => $backgroundOptions,
//            'default' => 'contain',
//            'rules'   => 'required',
//            'trigger' => [
//                'action'    => 'show',
//                'field'     => 'footer[bottom_background_type]',
//                'condition' => 'value[image]',
//            ],
//        ],
//        'footer[footer_color]'           => [
//            'label'   => 'Footer font color',
//            'comment' => 'The font color to use for the main and bottom footer.',
//            'type'    => 'colorpicker',
//            'default' => '#9BA1A7',
//            'rules'   => 'required',
//        ],
//        'footer[bottom_footer_color]'    => [
//            'label'   => 'Footer font color',
//            'type'    => 'colorpicker',
//            'default' => '#A3AAAF',
//            'rules'   => 'required',
//        ],
//    ],
//];
//
//$fields['sections']['social'] = [
//    'title'   => 'Social',
//    'comment' => 'Add full URL for your social network profiles',
//    'icon'    => '',
//    'fields'  => [
//        'social[facebook]'   => [
//            'label'   => 'Facebook',
//            'type'    => 'text',
//            'default' => '#',
//        ],
//        'social[twitter]'    => [
//            'label'   => 'Twitter',
//            'type'    => 'text',
//            'default' => '#',
//        ],
//        'social[google]'     => [
//            'label'   => 'Google +',
//            'type'    => 'text',
//            'default' => '#',
//        ],
//        'social[youtube]'    => [
//            'label'   => 'Youtube',
//            'type'    => 'text',
//            'default' => '#',
//        ],
//        'social[vimeo]'      => [
//            'label' => 'Vimeo',
//            'type'  => 'text',
//        ],
//        'social[linkedin]'   => [
//            'label' => 'LinkedIn',
//            'type'  => 'text',
//        ],
//        'social[pinterest]'  => [
//            'label' => 'Pinterest',
//            'type'  => 'text',
//        ],
//        'social[tumblr]'     => [
//            'label' => 'Tumblr',
//            'type'  => 'text',
//        ],
//        'social[flickr]'     => [
//            'label' => 'Flickr',
//            'type'  => 'text',
//        ],
//        'social[instagram]'  => [
//            'label' => 'Instagram',
//            'type'  => 'text',
//        ],
//        'social[dribbble]'   => [
//            'label' => 'Dribbble',
//            'type'  => 'text',
//        ],
//        'social[foursquare]' => [
//            'label' => 'Foursquare',
//            'type'  => 'text',
//        ],
//    ],
//];
//
//$fields['sections']['custom_script'] = [
//    'title'   => 'Custom Scripts',
//    'comment' => '',
//    'icon'    => '',
//    'fields'  => [
//        'custom_script[css]'    => [
//            'label'   => 'Add custom CSS',
//            'comment' => 'Paste your custom CSS code here.',
//            'type'    => 'textarea',
//            'rows'    => '9',
//        ],
//        'custom_script[head]'   => [
//            'label'   => 'Add custom Javascript to header',
//            'comment' => 'Paste your custom Javascript code here.',
//            'type'    => 'textarea',
//            'rows'    => '9',
//        ],
//        'custom_script[footer]' => [
//            'label'   => 'Add custom Javascript to footer',
//            'comment' => 'Paste your custom Javascript code here.',
//            'type'    => 'textarea',
//            'rows'    => '9',
//        ],
//    ],
//];

//return $fields;