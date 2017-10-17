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
 * String helper functions
 *
 * @category       Helpers
 * @package        TastyIgniter\Helpers\TI_string_helper.php
 * @link           http://docs.tastyigniter.com
 */

// ------------------------------------------------------------------------

if ( ! function_exists('convert_camelcase_to_underscore'))
{
    /**
     * Convert CamelCase to underscore Camel_Case
     *
     * Converts a StringWithCamelCase into string_with_underscore. Strings can be passed via the
     * first parameter either as a string or an array.
     *
     * @param string $string
     * @param bool $lowercase
     * @return CamelCase string
     */

    function convert_camelcase_to_underscore($string = '', $lowercase = FALSE)
    {
        preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $string, $matches);
        $ret = $matches[0];

        foreach ($ret as &$match) {
            $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
        }

        $string = implode('_', $ret);
        return (!$lowercase) ? $string : strtolower($string);
    }
}

// ------------------------------------------------------------------------

/**
 * Current URL
 *
 * Converts a string_with_underscore into StringWithCamelCase. Strings can be passed via the
 * first parameter either as a string or an array.
 *
 * @access	public
 * @return	string
 */
if ( ! function_exists('convert_underscore_to_camelcase'))
{
	function convert_underscore_to_camelcase($string = '')
	{
        return str_replace(' ', '', ucwords(str_replace('_', ' ', $string)));
    }
}

// ------------------------------------------------------------------------

/* End of file ti_string_helper.php */
/* Location: ./system/helpers/ti_string_helper.php */
