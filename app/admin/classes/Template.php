<?php namespace Admin\Classes;

use Html;

/**
 * Template Class
 * @package Admin
 */
class Template
{
    protected $themeCode;

    protected $pageTitle;

    protected $pageHeading;

    protected $pageButtons = [];

    public $blocks = [];

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

    public function setTitle($title)
    {
        $this->pageTitle = $title;
    }

    public function setHeading($heading)
    {
        if (strpos($heading, ':')) {
            list($normal, $small) = explode(':', $heading);
            $heading = $normal.'&nbsp;<small>'.$small.'</small>';
        }

        $this->pageHeading = $heading;
    }

    public function setButton($name, array $attributes = [])
    {
        $this->pageButtons[] = '<a'.Html::attributes($attributes).'>'.$name.'</a>';
    }
}