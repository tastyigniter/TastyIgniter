<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * TastyIgniter Template Helpers
 *
 * @category    Helpers
 */

// ------------------------------------------------------------------------

/**
 * Get Header
 *
 *
 * @access	public
 * @return	string
 */
if ( ! function_exists('get_header'))
{
    function get_header()
    {
        return get_instance()->template->getPartials('header');
    }
}

// ------------------------------------------------------------------------

/**
 * Get Footer
 *
 *
 * @access	public
 * @return	string
 */
if ( ! function_exists('get_footer'))
{
    function get_footer()
    {
        return get_instance()->template->getPartials('footer');
    }
}

// ------------------------------------------------------------------------

/**
 * Get Partial
 *
 *
 * @access	public
 * @return	string
 */
if ( ! function_exists('get_partial'))
{
    function get_partial($partial = '')
    {
        return get_instance()->template->getPartials($partial);
    }
}

// ------------------------------------------------------------------------

/**
 * Check if Partial Exist in layout
 *
 * @access	public
 * @return	string
 */
if ( ! function_exists('partial_exists'))
{
    function partial_exists($partial = '')
    {
        return (get_instance()->template->getPartials($partial)) ? TRUE : FALSE;
    }
}

// ------------------------------------------------------------------------

/**
 * Get Doctype
 *
 * @access	public
 * @return	string
 */
if ( ! function_exists('get_doctype'))
{
    function get_doctype()
    {
        return get_instance()->template->getDocType();
    }
}

// ------------------------------------------------------------------------

/**
 * Set Doctype
 *
 *
 * @access	public
 * @return	string
 */
if ( ! function_exists('set_doctype'))
{
    function set_doctype($doctype = '')
    {
        get_instance()->template->setHeadTag('doctype', $doctype);
    }
}


// ------------------------------------------------------------------------

/**
 * Get template metas
 *
 *
 * @access	public
 * @return	string
 */
if ( ! function_exists('get_metas'))
{
    function get_metas()
    {
        return get_instance()->template->getMetas();
    }
}

// ------------------------------------------------------------------------

/**
 * Set template metas
 *
 *
 * @access	public
 * @return	string
 */
if ( ! function_exists('set_meta'))
{
    function set_meta($meta = array())
    {
        get_instance()->template->setHeadTag('meta', $meta);
    }
}

// ------------------------------------------------------------------------

/**
 * Get template favicon
 *
 *
 * @access	public
 * @return	string
 */
if ( ! function_exists('get_favicon'))
{
    function get_favicon()
    {
        return get_instance()->template->getFavIcon();
    }
}


// ------------------------------------------------------------------------

/**
 * Set template favicon
 *
 *
 * @access	public
 * @return	string
 */
if ( ! function_exists('set_favicon'))
{
    function set_favicon($href = '')
    {
        get_instance()->template->setHeadTag('favicon', $href);
    }
}


// ------------------------------------------------------------------------

/**
 * Get template title
 *
 *
 * @access	public
 * @return	string
 */
if ( ! function_exists('get_title'))
{
    function get_title()
    {
        return get_instance()->template->getTitle();
    }
}

// ------------------------------------------------------------------------

/**
 * Set template title
 *
 *
 * @access	public
 * @return	string
 */
if ( ! function_exists('set_title'))
{
    function set_title($title = '')
    {
        get_instance()->template->setHeadTag('title', $title);
    }
}

// ------------------------------------------------------------------------

/**
 * Get template heading
 *
 *
 * @access	public
 * @return	string
 */
if ( ! function_exists('get_heading'))
{
    function get_heading()
    {
        return get_instance()->template->getHeading();
    }
}

// ------------------------------------------------------------------------

/**
 * Set template heading
 *
 *
 * @access	public
 * @return	string
 */
if ( ! function_exists('set_heading'))
{
    function set_heading($heading = '')
    {
        get_instance()->template->setHeadTag('heading', $heading);
    }
}

// ------------------------------------------------------------------------

/**
 * Get template styles tag
 *
 *
 * @access	public
 * @return	string
 */
if ( ! function_exists('get_style_tags'))
{
    function get_style_tags()
    {
        return get_instance()->template->getStyleTags();
    }
}

// ------------------------------------------------------------------------

/**
 * Set template styles tag
 *
 *
 * @access	public
 * @return	string
 */
if ( ! function_exists('set_style_tag'))
{
    function set_style_tag($href = '', $name = '', $priority = NULL)
    {
        get_instance()->template->setStyleTag($href, $name, $priority);
    }
}

// ------------------------------------------------------------------------

/**
 * Set template styles tag
 *
 *
 * @access	public
 * @return	string
 */
if ( ! function_exists('set_style_tags'))
{
    function set_style_tags($tags = array())
    {
        get_instance()->template->setStyleTag($tags);
    }
}

// ------------------------------------------------------------------------

/**
 * Get template scripts tag
 *
 *
 * @access	public
 * @return	string
 */
if ( ! function_exists('get_script_tags'))
{
    function get_script_tags()
    {
        return get_instance()->template->getScriptTags();
    }
}

// ------------------------------------------------------------------------

/**
 * Set template scripts tag
 *
 *
 * @access	public
 * @return	string
 */
if ( ! function_exists('set_script_tag'))
{
    function set_script_tag($href = '', $name = '', $priority = NULL)
    {
        get_instance()->template->setScriptTag($href, $name, $priority);
    }
}

// ------------------------------------------------------------------------

/**
 * Set template scripts tag
 *
 *
 * @access	public
 * @return	string
 */
if ( ! function_exists('set_script_tags'))
{
    function set_script_tags($tags = array())
    {
        get_instance()->template->setScriptTag($tags);
    }
}

// ------------------------------------------------------------------------

/**
 * Get template active styles
 *
 *
 * @access	public
 * @return	string
 */
if ( ! function_exists('get_active_styles'))
{
    function get_active_styles()
    {
        return get_instance()->template->getActiveStyle();
    }
}


// ------------------------------------------------------------------------

/**
 * Get template breadcrumbs
 *
 *
 * @access	public
 * @return	string
 */
if ( ! function_exists('get_breadcrumbs'))
{
    function get_breadcrumbs()
    {
        return get_instance()->template->getBreadcrumb();
    }
}


// ------------------------------------------------------------------------

/**
 * Get template menu buttons
 *
 *
 * @access	public
 * @return	string
 */
if ( ! function_exists('get_button_list'))
{
    function get_button_list()
    {
        return get_instance()->template->getButtonList();
    }
}


// ------------------------------------------------------------------------

/**
 * Get template menu icons
 *
 *
 * @access	public
 * @return	string
 */
if ( ! function_exists('get_icon_list'))
{
    function get_icon_list()
    {
        return get_instance()->template->getIconList();
    }
}


// ------------------------------------------------------------------------

/**
 * Get template back butotn
 *
 *
 * @access	public
 * @return	string
 */
if ( ! function_exists('get_back_button'))
{
    function get_back_button()
    {
        return get_instance()->template->getBackButton();
    }
}


// ------------------------------------------------------------------------

/* End of file template_helper.php */
/* Location: ./system/tastyigniter/helpers/template_helper.php */