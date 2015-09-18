<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * TastyIgniter Core Helpers
 *
 * @category    Helpers
 */

// ------------------------------------------------------------------------

/**
 * Log Activity
 *
 *
 * @access	public
 * @return	string
 */
if ( ! function_exists('log_activity'))
{
    function log_activity($user_id, $action, $context, $message)
    {
        $CI =& get_instance();
        $CI->load->model('Activities_model');
        return $CI->Activities_model->logActivity($user_id, $action, $context, $message);
    }
}

// ------------------------------------------------------------------------

/**
 * Get Activity Message from language file
 *
 * @access	public
 * @return	string
 */
if ( ! function_exists('get_activity_message'))
{
    function get_activity_message($lang, $search = array(), $replace = array())
    {
        $CI =& get_instance();
        $CI->load->model('Activities_model');
        return $CI->Activities_model->getMessage($lang, $search, $replace);
    }
}

// ------------------------------------------------------------------------

/**
 * Sort Array
 *
 * @access	public
 * @return	string
 */
if ( ! function_exists('sort_array'))
{
    function sort_array($array = array(), $sort_key = 'priority', $sory_array = array()) {
        if (!empty($array)) {
            foreach ($array as $key => $value) {
                $sory_array[$key] = $value[$sort_key];
            }

            array_multisort($sory_array, SORT_ASC, $array);
        }

        return $array;
    }
}

// ------------------------------------------------------------------------

/**
 * Currency Format
 *
 *
 * @access	public
 * @return	string
 */
if ( ! function_exists('currency_format'))
{
    function currency_format($num = '')
    {
        $CI =& get_instance();
        return $CI->currency->format($num);
    }
}

// ------------------------------------------------------------------------


/* End of file tastyigniter_helper.php */
/* Location: ./system/tastyigniter/helpers/tastyigniter_helper.php */