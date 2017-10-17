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
 * Date helper functions
 *
 * @category       Helpers
 * @package        TastyIgniter\Helpers\TI_date_helper.php
 * @link           http://docs.tastyigniter.com
 */

if ( ! function_exists('time_elapsed')) {
    /**
     * Get time elapsed
     *
     * Returns a time elapsed of seconds, minutes, hours, days in this format:
     *    10 days, 14 hours, 36 minutes, 47 seconds, now
     *
     * @param string $datetime
     * @param bool $full
     *
     * @return string
     */
    function time_elapsed($datetime, $full = FALSE) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );

        foreach ($string as $key => &$value) {
            if ($diff->$key) {
                $value = $diff->$key . ' ' . $value . ($diff->$key > 1 ? 's' : '');
            } else {
                unset($string[$key]);
            }
        }

        if (!empty($full)) {
            $intersect = array_intersect_key($string, array_flip($full));
            $string = (empty($intersect)) ? $string : $intersect;
        } else {
            $string = array_slice($string, 0, 1);
        }

        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }
}

// ------------------------------------------------------------------------

if ( ! function_exists('day_elapsed')) {
    /**
     * Get day elapsed
     *
     * Returns a day elapsed as today, yesterday or date d/M/y:
     *    Today or Yesterday or 12 Jan 15
     *
     * @param string $datetime
     *
     * @return string
     */
    function day_elapsed($datetime) {
        $datetime = strtotime($datetime);

        if (mdate('%d %M', $datetime) === mdate('%d %M', time())) {
            return 'Today';
        } else if (mdate('%d %M', $datetime) === mdate('%d %M', strtotime('yesterday'))) {
            return 'Yesterday';
        }

        if (mdate('%Y', $datetime) === mdate('%Y', time())) {
            return mdate('%d %M %y', $datetime);
        }

        return mdate('%d %M %y', $datetime);
    }
}

// ------------------------------------------------------------------------

if ( ! function_exists('time_range')) {
    /**
     * Date range
     *
     * Returns a list of time within a specified period.
     *
     * @param	int	unix_start	UNIX timestamp of period start time
     * @param	int	unix_end	UNIX timestamp of period end time
     * @param	int	interval		Specifies the second interval
     * @param	string  time_format	Output time format, same as in date()
     *
     * @return	array
     */
    function time_range($unix_start, $unix_end, $interval, $time_format = '%H:%i') {
        if ($unix_start == '' OR $unix_end == '' OR $interval == '') {
            return FALSE;
        }

        $interval = ctype_digit($interval) ? $interval . ' mins' : $interval;

        $start_time = strtotime($unix_start);
        $end_time   = strtotime($unix_end);

        $current    = time();
        $add_time   = strtotime('+'.$interval, $current);
        $diff       = $add_time-$current;

        $times = array();
        while ($start_time < $end_time) {
            $times[] = mdate($time_format, $start_time);
            $start_time += $diff;
        }
        $times[] = mdate($time_format, $start_time);
        return $times;
    }
}

// ------------------------------------------------------------------------


/* End of file ti_date_helper.php */
/* Location: ./system/tastyigniter/helpers/ti_date_helper.php */