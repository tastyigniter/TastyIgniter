<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * TastyIgniter Date Helpers
 *
 */

// ------------------------------------------------------------------------

if ( ! function_exists('time_elapsed')) {
    /**
     * Get time elapsed
     *
     * Returns a time elapsed of seconds, minutes, hours, days in this format:
     *    10 days, 14 hours, 36 minutes, 47 seconds, now
     *
     * @param string $datetime
     * @param bool $full
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

        if (!$full) $string = array_slice($string, 0, 1);
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
     * @return string
     */
    function day_elapsed($datetime) {
        $datetime = strtotime($datetime);

        if ($datetime >= strtotime('today')) {
            return 'Today';
        } else if ($datetime >= strtotime('yesterday')) {
            return 'Yesterday';
        }

        if (mdate('%Y', $datetime) === mdate('%Y', time())) {
            return mdate('%d %M', $datetime);
        }

        return mdate('%d %M %y', $datetime);
    }
}
/* End of file ti_date_helper.php */
/* Location: ./system/tastyigniter/helpers/ti_date_helper.php */