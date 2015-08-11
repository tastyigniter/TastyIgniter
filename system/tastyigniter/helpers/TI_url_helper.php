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
        return get_instance()->config->root_url('assets/images/'.$uri, $protocol);
	}
}

// ------------------------------------------------------------------------

/**
 * Root URL
 *
 * Create a local URL based on your root path.
 * Segments can be passed in as a string.
 *
 * @param	string	$uri
 * @param	string	$protocol
 * @return	string
 */
if ( ! function_exists('root_url'))
{
	function root_url($uri = '', $protocol = NULL)
	{
        return get_instance()->config->root_url($uri, $protocol);
	}
}

// ------------------------------------------------------------------------

/**
 * Admin URL
 *
 * Create a local URL based on your admin path.
 * Segments can be passed in as a string.
 *
 * @param	string	$uri
 * @param	string	$protocol
 * @return	string
 */
if ( ! function_exists('admin_url'))
{
	function admin_url($uri = '', $protocol = NULL)
	{
        return get_instance()->config->root_url(ADMINDIR.'/'.$uri, $protocol);
	}
}
if ( ! function_exists('roott_url'))
{
	function roott_url($uri = '', $protocol = NULL)
	{
        return get_instance()->config->root_url(ADMINDIR.'/'.$uri, $protocol);
	}
}

// ------------------------------------------------------------------------

/**
 * Extensions URL
 *
 * Create a local URL based on your extensions path.
 * Segments can be passed in as a string.
 *
 * @param	string	$uri
 * @param	string	$protocol
 * @return	string
 */
if ( ! function_exists('extension_url'))
{
	function extension_url($uri = '', $protocol = NULL)
	{
		return get_instance()->config->root_url(EXTPATH.$uri, $protocol);
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
            return ($CI->agent->referrer() == page_url()) ? $CI->config->site_url() : $CI->agent->referrer();
        } else {
            return $CI->config->site_url();
        }
    }
}

// ------------------------------------------------------------------------

if ( ! function_exists('redirect')) {
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
