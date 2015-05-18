<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * TastyIgniter URL Helpers
 *
 * @category    Helpers
 */

// ------------------------------------------------------------------------

if ( ! function_exists('site_url'))
{
    /**
     * Site URL
     *
     * Create a local URL based on your basepath. Segments can be passed via the
     * first parameter either as a string or an array.
     *
     * @param    string $uri
     * @param    string $protocol
     * @param bool $reverse_routing
     * @return string
     */
    function site_url($uri = '', $protocol = NULL)
    {
        return get_instance()->config->site_url($uri, $protocol);
    }
}

// ------------------------------------------------------------------------

/**
 * Current URL
 *
 * Returns the full URL (including segments) of the page where this
 * function is placed
 *
 * @access	public
 * @return	string
 */
if ( ! function_exists('current_url'))
{
	function current_url()
	{
		$CI =& get_instance();
    	return $_SERVER['QUERY_STRING'] ? $CI->config->site_url($CI->uri->uri_string().'?'.$_SERVER['QUERY_STRING']) : $CI->config->site_url($CI->uri->uri_string());
	}
}

// ------------------------------------------------------------------------

/**
 * Assets URL
 *
 * Returns the full URL (including segments) of the assets directory
 *
 * @access	public
 * @return	string
 */
if ( ! function_exists('image_url'))
{
	function image_url($uri = '', $protocol = NULL)
	{
		return root_url('assets/images/'.$uri);
	}
}

// ------------------------------------------------------------------------

/**
 * Root URL
 *
 * Create a local URL based on your rootpath.
 * Segments can be passed in as a string or an array, same as root_url
 * or a URL to a file can be passed in, e.g. to an image file.
 *
 * @param	string	$uri
 * @param	string	$protocol
 * @return	string
 */
if ( ! function_exists('root_url'))
{
	function root_url($uri = '', $protocol = NULL)
	{
		$base_url = get_instance()->config->base_url('', $protocol);
		return str_replace('setup/', '', str_replace(ADMINDIR.'/', '', $base_url)).$uri;
	}
}

// ------------------------------------------------------------------------

/**
 * Page URL
 *
 * Returns the full URL (including segments) of the page where this
 * function is placed
 *
 * @access	public
 * @return	string
 */
if ( ! function_exists('page_url'))
{
	function page_url()
	{
		$CI =& get_instance();
		return $CI->config->site_url($CI->uri->uri_string());
	}
}

// ------------------------------------------------------------------------

/**
 * Referrer URL
 *
 * Returns the full URL (including segments) of the page where this
 * function is placed
 *
 * @access	public
 * @return	string
 */
if ( ! function_exists('referrer_url'))
{
	function referrer_url()
	{
        $CI =& get_instance();
        $CI->load->library('user_agent');

        if (!$CI->agent->is_referral()) {
            return $CI->agent->referrer();
        } else {
            return $CI->config->site_url();
        }
    }
}

// ------------------------------------------------------------------------

/* End of file ti_url_helper.php */
/* Location: ./system/helpers/ti_url_helper.php */
