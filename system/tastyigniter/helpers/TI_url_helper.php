<?php
/**
 * TastyIgniter
 *
 * An open source online ordering, reservation and management system for restaurants.
 *
 * @package   TastyIgniter
 * @author    SamPoyigi
 * @copyright TastyIgniter
 * @link      http://tastyigniter.com
 * @license   http://opensource.org/licenses/GPL-3.0 The GNU GENERAL PUBLIC LICENSE
 * @since     File available since Release 1.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * URL helper functions
 *
 * @category       Helpers
 * @package        TastyIgniter\Helpers\TI_url_helper.php
 * @link           http://docs.tastyigniter.com
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
	 *
	 * @return string
	 */
    function site_url($uri = '', $protocol = NULL)
    {
        return get_instance()->config->site_url($uri, $protocol);
    }
}

// ------------------------------------------------------------------------

if ( ! function_exists('current_url'))
{
	/**
	 * Current URL
	 *
	 * Returns the full URL (including segments and query string) of the page where this
	 * function is placed
	 *
	 * @return	string
	 */
	function current_url()
	{
		$CI =& get_instance();
        $url = $CI->config->site_url($CI->uri->uri_string());
        return $_SERVER['QUERY_STRING'] ? $url.'?'.$_SERVER['QUERY_STRING'] : $url;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('assets_url'))
{
	/**
	 * Assets URL
	 *
	 * Returns the full URL (including segments) of the assets directory
	 *
	 * @param string $uri
	 * @param null   $protocol
	 *
	 * @return string
	 */
	function assets_url($uri = '', $protocol = NULL)
	{
        return get_instance()->config->root_url('assets/'.$uri, $protocol);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('image_url'))
{
	/**
	 * Image Assets URL
	 *
	 * Returns the full URL (including segments) of the assets image directory
	 *
	 * @param string $uri
	 * @param null   $protocol
	 *
	 * @return string
	 */
	function image_url($uri = '', $protocol = NULL)
	{
        return get_instance()->config->root_url('assets/images/'.$uri, $protocol);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('root_url'))
{
	/**
	 * Root URL
	 *
	 * Create a local URL based on your root path.
	 * Segments can be passed in as a string.
	 *
	 * @param	string	$uri
	 * @param	string	$protocol
	 *
	 * @return	string
	 */
	function root_url($uri = '', $protocol = NULL)
	{
        return get_instance()->config->root_url($uri, $protocol, TRUE);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('admin_url'))
{
	/**
	 * Admin URL
	 *
	 * Create a local URL based on your admin path.
	 * Segments can be passed in as a string.
	 *
	 * @param	string	$uri
	 * @param	string	$protocol
	 *
	 * @return	string
	 */
	function admin_url($uri = '', $protocol = NULL)
	{
		return get_instance()->config->root_url(ADMINDIR.'/'.$uri, $protocol);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('extension_url'))
{
	/**
	 * Extensions URL
	 *
	 * Create a local URL based on your extensions path.
	 * Segments can be passed in as a string.
	 *
	 * @param	string	$uri
	 * @param	string	$protocol
	 *
	 * @return	string
	 */
	function extension_url($uri = '', $protocol = NULL)
	{
		return get_instance()->config->root_url(EXTPATH.$uri, $protocol);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('theme_url'))
{
	/**
	 * Theme URL
	 *
	 * Create a local URL based on your theme path.
	 * Segments can be passed in as a string.
	 *
	 * @param	string	$uri
	 * @param	string	$protocol
	 *
	 * @return	string
	 */
	function theme_url($uri = '', $protocol = NULL) {
		return get_instance()->config->root_url(APPDIR . '/views/themes/' . $uri, $protocol, TRUE);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('page_url'))
{
	/**
	 * Page URL
	 *
	 * Returns the full URL (including segments) of the page where this
	 * function is placed
	 *
	 * @return	string
	 */
	function page_url()
	{
		$CI =& get_instance();
		return rtrim($CI->config->site_url(), '/').'/'.$CI->uri->uri_string();
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('restaurant_url'))
{
	/**
	 * Restaurant URL
	 *
	 * Returns the full URL (including segments) of the local restaurant if any,
	 * else locations URL is returned
	 *
	 * @return	string
	 */
	function restaurant_url()
	{
		$CI =& get_instance();
        if (isset($CI->location) AND is_numeric($CI->location->getId())) {
            return site_url('local?location_id='.$CI->location->getId());
        } else {
            return site_url('locations');
        }
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('referrer_url'))
{
	/**
	 * Referrer URL
	 *
	 * Returns the full URL (including segments) of the page where this
	 * function is placed
	 *
	 * @return	string
	 */
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

if ( ! function_exists('redirect')) {
	/**
	 * Header Redirect
	 *
	 * Header redirect in two flavors
	 * For very fine grained control over headers, you could use the Output
	 * Library's set_header() function.
	 *
	 * @param    string $uri    URL
	 * @param    string $method Redirect method
	 *                          'auto', 'location' or 'refresh'
	 * @param    int    $code   HTTP Response status code
	 *
	 * @throws CIPHPUnitTestRedirectException
	 */
	function redirect($uri = '', $method = 'auto', $code = NULL) {
        if ( ! preg_match('#^(\w+:)?//#i', $uri)) {
            $uri = site_url($uri);
        }
        // IIS environment likely? Use 'refresh' for better compatibility
        if ($method === 'auto' && isset($_SERVER['SERVER_SOFTWARE']) && strpos($_SERVER['SERVER_SOFTWARE'], 'Microsoft-IIS') !== FALSE) {
            $method = 'refresh';
        } elseif ($method !== 'refresh' && (empty($code) OR ! is_numeric($code))) {
            if (isset($_SERVER['SERVER_PROTOCOL'], $_SERVER['REQUEST_METHOD']) && $_SERVER['SERVER_PROTOCOL'] === 'HTTP/1.1') {
                $code = ($_SERVER['REQUEST_METHOD'] !== 'GET')
                    ? 303    // reference: http://en.wikipedia.org/wiki/Post/Redirect/Get
                    : 307;
            } else {
                $code = 302;
            }
        }
        switch ($method) {
            case 'refresh':
                header('Refresh:0;url=' . $uri);
                break;
            default:
                header('Location: ' . $uri, TRUE, $code);
                break;
        }
        if (ENVIRONMENT !== 'testing') {
            exit;
        } else {
            while (ob_get_level() > 1) {
                ob_end_clean();
            }
            if (class_exists('CIPHPUnitTestRedirectException', FALSE)) {
                throw new CIPHPUnitTestRedirectException('Redirect to ' . $uri, $code);
            }
        }
    }
}

// ------------------------------------------------------------------------

/* End of file ti_url_helper.php */
/* Location: ./system/helpers/ti_url_helper.php */
