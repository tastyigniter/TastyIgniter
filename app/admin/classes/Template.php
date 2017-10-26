<?php namespace Admin\Classes;

use File;
use Html;
use Main\Classes\Page;
use Main\Classes\ThemeManager;
use System\Classes\BaseController;
use SystemException;

/**
 * Template Class
 * @package Admin
 */
class Template
{
    protected $_breadcrumb = [
        'divider'    => '&raquo;',
        'tag_open'   => '<li class="{class}">',
        'tag_close'  => '</li>',
        'link_open'  => '<a href="{link}">',
        'link_close' => '</a>',
    ];

    protected $_title_separator = ' - ';

    protected $themeCode;

    protected $pageTitle;

    protected $pageHeading;

    protected $pageButtons = [];

    protected $pageIcons = [];

    protected $pageCrumbs = [];

    public $blocks = [];

    public function __construct($config = [])
    {
        $this->initialize($config);
    }

    public function initialize($config = [])
    {
        if (!empty($config)) foreach ($config as $key => $val) {
            $key = '_'.$key;
            if (property_exists($this, $key))
                $this->{$key} = $val;
        }
    }

    /**
     * Returns the layout block contents but does not deletes the block from memory.
     *
     * @param string $name Specifies the block name.
     * @param string $default Specifies a default block value to use if the block requested is not exists.
     *
     * @return string
     */
    public function getBlock($name, $default = null)
    {
        if (!isset($this->blocks[$name])) {
            return $default;
        }

        return $this->blocks[$name];
    }

    /**
     * Appends a content of the layout block.
     *
     * @param string $name Specifies the block name.
     * @param string $contents Specifies the block content.
     */
    public function appendBlock($name, $contents)
    {
        if (!isset($this->blocks[$name])) {
            $this->blocks[$name] = null;
        }

        $this->blocks[$name] .= $contents;
    }

    /**
     * Sets a content of the layout block.
     *
     * @param string $name Specifies the block name.
     * @param string $contents Specifies the block content.
     */
    public function setBlock($name, $contents)
    {
        $this->blocks[$name] = $contents;
    }

    public function getTheme()
    {
        return $this->themeCode;
    }

    public function getTitle()
    {
        return $this->pageTitle;
    }

    public function getHeading()
    {
        return $this->pageHeading;
    }

    public function getButtonList()
    {
        return implode(PHP_EOL, $this->pageButtons);
    }

    public function getIconList()
    {
        return implode(PHP_EOL, $this->pageIcons);
    }

    /**
     * @param array $options default:
     *      [
     *          'tag_open' = '<li class="{class}">',
     *          'link_open' = '<a href="{link}">',
     *          'link_close' = '</a>',
     *          'tag_close' = '</li>',
     *      ]
     *
     * @return string
     */
    public function getBreadcrumb($options = [])
    {
        $options = array_merge($this->_breadcrumb, $options);

        foreach ($this->pageCrumbs as $crumb) {
            $replaceData = array_merge([
                'class'  => '',
                'active' => FALSE,
                'link'   => site_url(trim($crumb['uri'], '/')),
            ], $crumb['replace']);

            if ($replaceData['active']) {
                $options['link_open'] = '<span class="{class}">';
                $options['link_close'] = '</span>';
            }

            $options['tag_open'] = parse_values($replaceData, $options['tag_open']);
            $options['link_open'] = parse_values($replaceData, $options['link_open']);

            $crumbs[] = $options['tag_open'].$options['link_open'].$crumb['name'].$options['link_close'].$options['tag_close'];
        }

        return !empty($crumbs) ? implode(PHP_EOL, $crumbs) : null;
    }

    public function setTitle($options = null)
    {
        if (func_num_args()) {
            $this->pageTitle = implode($this->_title_separator, func_get_args());
        }
    }

    public function setHeading($heading)
    {
        if (count($heading_array = explode(':', $heading)) === 2) {
            $heading = $heading_array[0].'&nbsp;<small>'.$heading_array[1].'</small>';
        }

        $this->pageHeading = $heading;
    }

    public function setButton($name, $attributes = [])
    {
        $this->pageButtons[] = '<a'.Html::attributes($attributes).'>'.$name.'</a>';
    }

    /**
     * @param $name
     * @param string $uri
     * @param array $replace ex. ['class' => 'crumb-link', 'active' => TRUE]
     *
     * @return $this
     */
    public function setBreadcrumb($name, $uri = '', $replace = [])
    {
        $this->pageCrumbs[] = ['name' => $name, 'uri' => $uri, 'replace' => $replace];

        return $this;
    }
}