<?php
/**
 * TastyIgniter
 *
 * An open source online ordering, reservation and management system for restaurants.
 *
 * @package   TastyIgniter
 * @author    SamPoyigi
 * @copyright (c) 2013 - 2016. TastyIgniter
 * @link      http://tastyigniter.com
 * @license   http://opensource.org/licenses/GPL-3.0 The GNU GENERAL PUBLIC LICENSE
 * @since     File available since Release 1.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * PATH helper functions
 *
 * @category       Helpers
 * @package        TastyIgniter\Helpers\TI_path_helper.php
 * @link           http://docs.tastyigniter.com
 */

if ( ! function_exists('base_path'))
{
	/**
	 * Get the path to the base folder.
	 *
	 * @param	string	$path	The path to prepend
	 *
	 * @return	string
	 */
	function base_path($path = null)
	{
		return rtrim(ROOTPATH, '/') . ($path ? DIRECTORY_SEPARATOR.$path : $path);
	}
}

if ( ! function_exists('app_path'))
{
    /**
	 * Get the path to the application folder.
     *
     * @param	string	$path	The path to prepend
     *
     * @return	string
     */
    function app_path($path = null)
    {
    	return rtrim(ROOTPATH, '/') . APPDIR . ($path ? DIRECTORY_SEPARATOR.$path : $path);
    }
}

if ( ! function_exists('assets_path'))
{
    /**
	 * Get the path to the assets folder.
     *
     * @param	string	$path	The path to prepend
     *
     * @return	string
     */
    function assets_path($path = null)
    {
    	return rtrim(ASSETPATH, '/') . ($path ? DIRECTORY_SEPARATOR.$path : $path);
    }
}

if ( ! function_exists('image_path'))
{
    /**
	 * Get the path to the assets image folder.
     *
     * @param	string	$path	The path to prepend
     *
     * @return	string
     */
    function image_path($path = null)
    {
    	return rtrim(IMAGEPATH, '/') . ($path ? DIRECTORY_SEPARATOR.$path : $path);
    }
}

if ( ! function_exists('storage_path'))
{
    /**
	 * Get the path to the assets downloads folder.
     *
     * @param	string	$path	The path to prepend
     *
     * @return	string
     */
    function storage_path($path = null)
    {
		return rtrim(ASSETPATH, '/') .'/downloads' . ($path ? DIRECTORY_SEPARATOR.$path : $path);
    }
}

if ( ! function_exists('temp_path'))
{
    /**
	 * Get the path to the downloads temp folder.
     *
     * @param	string	$path	The path to prepend
     *
     * @return	string
     */
    function temp_path($path = null)
    {
		return rtrim(ASSETPATH, '/') .'/downloads/temp' . ($path ? DIRECTORY_SEPARATOR.$path : $path);
    }
}