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
 * TastyIgniter helper functions
 *
 * @category       Helpers
 * @package        TastyIgniter\Helpers\tastyigniter_helper.php
 * @link           http://docs.tastyigniter.com
 */

if ( ! function_exists('log_activity'))
{
    /**
     * Log Activity
     *
     * @param string $user_id
     * @param string $action
     * @param string $context
     * @param string $message
     *
     * @return string
     */
    function log_activity($user_id, $action, $context, $message)
    {
        $CI =& get_instance();
        $CI->load->model('Activities_model');
        return $CI->Activities_model->logActivity($user_id, $action, $context, $message);
    }
}

// ------------------------------------------------------------------------

if ( ! function_exists('get_activity_message'))
{
    /**
     * Retrieve and parse activity message from language file
     *
     * @param       $lang
     * @param array $search
     * @param array $replace
     *
     * @return string
     */
    function get_activity_message($lang, $search = array(), $replace = array())
    {
        $CI =& get_instance();
        $CI->load->model('Activities_model');
        return $CI->Activities_model->getMessage($lang, $search, $replace);
    }
}

// ------------------------------------------------------------------------

if ( ! function_exists('sort_array'))
{
    /**
     * Sort an array by key
     *
     * @param array  $array
     * @param string $sort_key
     * @param array  $sort_array
     *
     * @return string
     */
    function sort_array($array = array(), $sort_key = 'priority', $sort_array = array()) {
        if (!empty($array)) {
            foreach ($array as $key => $value) {
                $sort_array[$key] = $value[$sort_key];
            }

            array_multisort($sort_array, SORT_ASC, $array);
        }

        return $array;
    }
}

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
        return $CI->currency->format($num);
    }
}
// ------------------------------------------------------------------------


// ------------------------------------------------------------------------

if ( ! function_exists('flush_output'))
{
    /**
     * Output message to browser during script execution
     *
     * @param        $message
     * @param bool   $is_message
     *
     */
    function flush_output($message, $is_message = TRUE)
    {
        if ($is_message) {
            echo "<p>{$message}</p>" . PHP_EOL;
        } else {
            echo $message . PHP_EOL;
        }

        echo str_pad('',4096). PHP_EOL;
        ob_flush();
        flush();
    }
}

// ------------------------------------------------------------------------

if ( ! function_exists('get_remote_data'))
{
    /**
     * Get remote data (cURL)
     *
     * @param       $url
     * @param array $options
     *
     * @return string
     */
    function get_remote_data($url, $options = array('TIMEOUT' => 10))
    {
        // Set the curl parameters.
        $curl = curl_init($url);

        curl_setopt($curl, CURLOPT_HEADER, FALSE);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);

        if (!empty($options['TIMEOUT'])) {
            curl_setopt($curl, CURLOPT_TIMEOUT, $options['TIMEOUT']);
            curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $options['TIMEOUT']);
        }

        if (!empty($options['HTTPHEADER'])) {
            curl_setopt($curl, CURLOPT_HTTPHEADER, $options['HTTPHEADER']);
        }

        if (!empty($options['USERAGENT'])) {
            curl_setopt($curl, CURLOPT_USERAGENT, $options['USERAGENT']);
        }

        if (isset($options['AUTOREFERER'])) {
            curl_setopt($curl, CURLOPT_AUTOREFERER, $options['AUTOREFERER']);
        }

        if (isset($options['FAILONERROR'])) {
            curl_setopt($curl, CURLOPT_FAILONERROR, $options['FAILONERROR']);
        }

        if (isset($options['FOLLOWLOCATION'])) {
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, $options['FOLLOWLOCATION']);
        }

        curl_setopt($curl, CURLOPT_MAXREDIRS, 20);

        if (!empty($options['REFERER'])) {
            curl_setopt($curl, CURLOPT_REFERER, current_url());
        }

        if (!empty($options['POSTFIELDS'])) {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($options['POSTFIELDS'], '', '&'));
        }

        // Get response from the server.
        $response = curl_exec($curl);

        if (curl_error($curl)) {
            log_message('error', 'cURL: Error --> ' . curl_errno($curl) . ': ' . curl_error($curl) .' '. $url);
        }

        curl_close($curl);

        return $response;
    }
}

// ------------------------------------------------------------------------

if ( ! function_exists('get_context_help'))
{
    /**
     * Get Context-sensitive help
     *
     * @param string $context
     *
     * @return string
     */
    function get_context_help($context = '')
    {
        // @TO-DO
        return FALSE;
    }
}

// ------------------------------------------------------------------------

/* End of file tastyigniter_helper.php */
/* Location: ./system/tastyigniter/helpers/tastyigniter_helper.php */