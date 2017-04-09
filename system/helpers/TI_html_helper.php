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
 * HTML helper functions
 *
 * @category       Helpers
 * @package        Igniter\Helpers\TI_html_helper.php
 * @link           http://docs.tastyigniter.com
 */

if ( ! function_exists('doctype'))
{
    /**
     * Doctype
     *
     * Generates a page document type declaration
     *
     * Examples of valid options: html5, xhtml-11, xhtml-strict, xhtml-trans,
     * xhtml-frame, html4-strict, html4-trans, and html4-frame.
     * All values are saved in the doctypes config file.
     *
     * @param	string	type	The doctype to be generated
     *
     * @return	string
     */
    function doctype($type = 'xhtml1-strict')
    {
        static $doctypes;

        if ( ! is_array($doctypes))
        {
            if (file_exists(ROOTPATH.'config/doctypes.php'))
            {
                include(ROOTPATH.'config/doctypes.php');
            }

            if (file_exists(ROOTPATH.'config/'.ENVIRONMENT.'/doctypes.php'))
            {
                include(ROOTPATH.'config/'.ENVIRONMENT.'/doctypes.php');
            }

            if (empty($_doctypes) OR ! is_array($_doctypes))
            {
                $doctypes = array();
                return FALSE;
            }

            $doctypes = $_doctypes;
        }

        return isset($doctypes[$type]) ? $doctypes[$type] : FALSE;
    }
}
