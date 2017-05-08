<?php
/**
 * TastyIgniter
 *
 * An open source online ordering, reservation and management system for restaurants.
 *
 * @package Igniter
 * @author Samuel Adepoyigi
 * @copyright (c) 2013 - 2016. Samuel Adepoyigi
 * @copyright (c) 2016 - 2017. TastyIgniter Dev Team
 * @link https://tastyigniter.com
 * @license http://opensource.org/licenses/MIT The MIT License
 * @since File available since Release 1.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * URL helper functions
 *
 * @category       Helpers
 * @package        Igniter\Helpers\TI_url_helper.php
 * @link           http://docs.tastyigniter.com
 */

// ------------------------------------------------------------------------

if (!function_exists('site_url')) {
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
    function site_url($uri = '', $protocol = null)
    {
        return get_instance()->config->site_url($uri, $protocol);
    }
}

// ------------------------------------------------------------------------

if (!function_exists('current_url')) {
    /**
     * Current URL
     *
     * Returns the full URL (including segments and query string) of the page where this
     * function is placed
     *
     * @return    string
     */
    function current_url()
    {
        $CI =& get_instance();
        $url = $CI->config->site_url($CI->uri->uri_string());
        return !empty($_SERVER['QUERY_STRING']) ? $url.'?'.$_SERVER['QUERY_STRING'] : $url;
    }
}

// ------------------------------------------------------------------------

if (!function_exists('assets_url')) {
    /**
     * Assets URL
     *
     * Returns the full URL (including segments) of the assets directory
     *
     * @param string $uri
     * @param null $protocol
     *
     * @return string
     */
    function assets_url($uri = '', $protocol = null)
    {
        return get_instance()->config->root_url('assets/'.$uri, $protocol);
    }
}

// ------------------------------------------------------------------------

if (!function_exists('image_url')) {
    /**
     * Image Assets URL
     *
     * Returns the full URL (including segments) of the assets image directory
     *
     * @param string $uri
     * @param null $protocol
     *
     * @return string
     */
    function image_url($uri = '', $protocol = null)
    {
        return get_instance()->config->root_url('assets/images/'.$uri, $protocol);
    }
}

// ------------------------------------------------------------------------

if (!function_exists('root_url')) {
    /**
     * Root URL
     *
     * Create a local URL based on your root path.
     * Segments can be passed in as a string.
     *
     * @param    string $uri
     * @param    string $protocol
     *
     * @return    string
     */
    function root_url($uri = '', $protocol = null)
    {
        return get_instance()->config->root_url($uri, $protocol, TRUE);
    }
}

// ------------------------------------------------------------------------

if (!function_exists('admin_url')) {
    /**
     * Admin URL
     *
     * Create a local URL based on your admin path.
     * Segments can be passed in as a string.
     *
     * @param    string $uri
     * @param    string $protocol
     *
     * @return    string
     */
    function admin_url($uri = '', $protocol = null)
    {
        if (!starts_with($uri, ADMINDIR))
            $uri = ADMINDIR.'/'.ltrim($uri, '/');

        return get_instance()->config->root_url($uri, $protocol);
    }
}

// ------------------------------------------------------------------------

if (!function_exists('extension_url')) {
    /**
     * Extensions URL
     *
     * Create a local URL based on your extensions path.
     * Segments can be passed in as a string.
     *
     * @param    string $uri
     * @param    string $protocol
     *
     * @return    string
     */
    function extension_url($uri = '', $protocol = null)
    {
        return get_instance()->config->root_url(EXTPATH.$uri, $protocol);
    }
}

// ------------------------------------------------------------------------

if (!function_exists('admin_extension_url')) {
    /**
     * Admin Extensions URL
     *
     * Create a local URL based on your extensions path.
     * Segments can be passed in as a string.
     *
     * @param    string $uri
     * @param    string $protocol
     *
     * @return    string
     */
    function admin_extension_url($uri = '', $protocol = null)
    {
        return get_instance()->config->root_url(ADMINDIR.'/extensions/'.$uri, $protocol);
    }
}

// ------------------------------------------------------------------------

if (!function_exists('theme_url')) {
    /**
     * Theme URL
     *
     * Create a local URL based on your theme path.
     * Segments can be passed in as a string.
     *
     * @param    string $uri
     * @param    string $protocol
     *
     * @return    string
     */
    function theme_url($uri = '', $protocol = null)
    {
        return get_instance()->config->theme_url($uri, $protocol, TRUE);
    }
}

// ------------------------------------------------------------------------

if (!function_exists('page_url')) {
    /**
     * Page URL
     *
     * Returns the full URL (including segments) of the page where this
     * function is placed
     *
     * @return    string
     */
    function page_url()
    {
        $CI =& get_instance();

        return root_url($CI->uri->uri_string());
    }
}

// ------------------------------------------------------------------------

if (!function_exists('restaurant_url')) {
    /**
     * Restaurant URL
     *
     * Returns the full URL (including segments) of the local restaurant if any,
     * else locations URL is returned
     *
     * @param string $uri
     * @param string $protocol
     *
     * @return string
     */
    function restaurant_url($uri = '', $protocol = null)
    {
        $CI =& get_instance();

        return $CI->config->restaurant_url($uri, $protocol);
    }
}

// ------------------------------------------------------------------------

if (!function_exists('referrer_url')) {
    /**
     * Referrer URL
     *
     * Returns the full URL (including segments) of the page where this
     * function is placed
     *
     * @return    string
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

if (!function_exists('redirect')) {
    /**
     * Header Redirect
     *
     * Header redirect in two flavors
     * For very fine grained control over headers, you could use the Output
     * Library's set_header() function.
     *
     * @param    string $uri URL
     * @param    string $method Redirect method
     *                          'auto', 'location' or 'refresh'
     * @param    int $code HTTP Response status code
     *
     * @throws CIPHPUnitTestRedirectException
     */
    function redirect($uri = '', $method = 'auto', $code = null)
    {
        if (!preg_match('#^(\w+:)?//#i', $uri)) {
//            if (APPDIR != MAINDIR AND substr($uri, 0, strlen(APPDIR)) !== (string)APPDIR)
//                $uri = APPDIR.'/'.ltrim($uri, '/');

            $uri = site_url($uri);
        }

        // IIS environment likely? Use 'refresh' for better compatibility
        if ($method === 'auto' && isset($_SERVER['SERVER_SOFTWARE']) && strpos($_SERVER['SERVER_SOFTWARE'], 'Microsoft-IIS') !== FALSE) {
            $method = 'refresh';
        } elseif ($method !== 'refresh' && (empty($code) OR !is_numeric($code))) {
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
                header('Refresh:0;url='.$uri);
                break;
            default:
                header('Location: '.$uri, TRUE, $code);
                break;
        }

        if (ENVIRONMENT !== 'testing') {
            exit;
        } else {
            while (ob_get_level() > 1) {
                ob_end_clean();
            }
            if (class_exists('CIPHPUnitTestRedirectException', FALSE)) {
                throw new CIPHPUnitTestRedirectException('Redirect to '.$uri, $code);
            }
        }
    }
}

// ------------------------------------------------------------------------

/* End of file ti_url_helper.php */
/* Location: ./system/helpers/ti_url_helper.php */
