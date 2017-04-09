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
 * Number helper functions
 *
 * @category       Helpers
 * @package        Igniter\Helpers\TI_number_helper.php
 * @link           http://docs.tastyigniter.com
 */

// ------------------------------------------------------------------------

if ( ! function_exists('currency_format'))
{
    /**
     * Append or Prepend the default currency symbol to amounts
     *
     * @param string $num
     *
     * @return string
     */
    function currency_format($num = '')
    {
        $CI =& get_instance();

        if (!isset($CI->currency)) {
            $CI->load->library('currency');
        }

        return $CI->currency->format($num);
    }
}

// ------------------------------------------------------------------------

if ( ! function_exists('format_number'))
{
    /**
     * Format number to two decimal places
     *
     * @param string $num
     *
     * @return string
     */
    function format_number($num = '')
    {
        $CI =& get_instance();

        if (!isset($CI->currency)) {
            $CI->load->library('currency');
        }

        return $CI->currency->format($num, '', FALSE);
    }
}

// ------------------------------------------------------------------------

/* End of file TI_number_helper.php */
/* Location: ./system/helpers/TI_number_helper.php */
