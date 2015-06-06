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
 * Get Activity Message
 * from language file
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

/* End of file tastyigniter_helper.php */
/* Location: ./system/tastyigniter/helpers/tastyigniter_helper.php */