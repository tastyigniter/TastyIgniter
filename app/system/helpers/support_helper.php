<?php

use Carbon\Carbon;

if (!function_exists('controller')) {
    /**
     * Get the page controller
     * @return Main\Classes\MainController
     */
    function controller()
    {
        return \Main\Classes\MainController::getController();
    }
}

if (!function_exists('page_url')) {
    /**
     * Page URL
     * Returns the full URL (including segments) of the page where this
     * function is placed
     *
     * @param string $uri
     * @param array $params
     *
     * @return string
     */
    function page_url($uri = null, array $params = [])
    {
        return controller()->pageUrl($uri, $params);
    }
}

if (!function_exists('site_url')) {
    /**
     * Site URL
     * Create a local URL based on your basepath. Segments can be passed via the
     * first parameter either as a string or an array.
     *
     * @param string $uri
     * @param array $params
     *
     * @return string
     */
    function site_url($uri = null, $params = [])
    {
        return controller()->url($uri, $params);
    }
}

if (!function_exists('restaurant_url')) {
    /**
     * Restaurant URL
     * Returns the full URL (including segments) of the local restaurant if any,
     * else locations URL is returned
     *
     * @param string $uri
     * @param array $params
     *
     * @return string
     */
    function restaurant_url($uri = null, array $params = [])
    {
        if (App::bound('location')
            AND !isset($params['location'])
            AND $current = App::make('location')->current()
        ) $params['location'] = $current->permalink_slug;

        return page_url($uri, $params);
    }
}

if (!function_exists('admin_url')) {
    /**
     * Admin URL
     * Create a local URL based on your admin path.
     * Segments can be passed in as a string.
     *
     * @param    string $uri
     * @param    array $params
     *
     * @return    string
     */
    function admin_url($uri = '', array $params = [])
    {
        return Admin::url($uri, $params);
    }
}

if (!function_exists('uploads_url')) {
    /**
     * Media Uploads URL
     * Returns the full URL (including segments) of the assets media uploads directory
     *
     * @param null $path
     * @return string
     */
    function uploads_url($path = null)
    {
        return \Main\Classes\MediaLibrary::instance()->getMediaUrl($path);
    }
}

if (!function_exists('strip_class_basename')) {
    function strip_class_basename($class = '', $chop = null)
    {
        $basename = class_basename($class);

        if (is_null($chop))
            return $basename;

        if (!ends_with($basename, $chop))
            return $basename;

        return substr($basename, 0, -strlen($chop));
    }
}

if (!function_exists('mdate')) {
    /**
     * Convert MySQL Style Datecodes
     * This function is identical to PHPs date() function,
     * except that it allows date codes to be formatted using
     * the MySQL style, where each code letter is preceded
     * with a percent sign:  %Y %m %d etc...
     * The benefit of doing dates this way is that you don't
     * have to worry about escaping your text letters that
     * match the date codes.
     *
     * @param string $format
     * @param string $time
     *
     * @return int
     */
    function mdate($format = null, $time = null)
    {
        if (is_null($time) AND $format) {
            $time = $format;
            $format = null;
        }

        if (is_null($format))
            $format = setting('date_format', config('system.dateFormat'));

        if (is_null($time))
            return null;

        if (empty($time))
            $time = time();

        if (str_contains($format, '%'))
            $format = str_replace(
                '%\\',
                '',
                preg_replace('/([a-z]+?){1}/i', '\\\\\\1', $format)
            );

        return date($format, $time);
    }
}

if (!function_exists('time_elapsed')) {
    /**
     * Get time elapsed
     * Returns a time elapsed of seconds, minutes, hours, days in this format:
     *    10 days, 14 hours, 36 minutes, 47 seconds, now
     *
     * @param string $datetime
     * @param array $full
     *
     * @return string
     */
    function time_elapsed($datetime, $full = null)
    {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = [
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        ];

        foreach ($string as $key => &$value) {
            if ($diff->$key) {
                $value = $diff->$key.' '.$value.($diff->$key > 1 ? 's' : '');
            }
            else {
                unset($string[$key]);
            }
        }

        if (!empty($full)) {
            $intersect = array_intersect_key($string, array_flip($full));
            $string = (empty($intersect)) ? $string : $intersect;
        }
        else {
            $string = array_slice($string, 0, 1);
        }

        return $string ? implode(', ', $string).' ago' : 'just now';
    }
}

if (!function_exists('day_elapsed')) {
    /**
     * Get day elapsed
     * Returns a day elapsed as today, yesterday or date d/M/y:
     *    Today or Yesterday or 12 Jan 15
     *
     * @param string $datetime
     *
     * @return string
     */
    function day_elapsed($datetime)
    {
        $datetime = strtotime($datetime);

        if (mdate('%d %M', $datetime) === mdate('%d %M', time())) {
            return 'Today';
        }
        else if (mdate('%d %M', $datetime) === mdate('%d %M', strtotime('yesterday'))) {
            return 'Yesterday';
        }

        if (mdate('%Y', $datetime) === mdate('%Y', time())) {
            return mdate('%d %M %y', $datetime);
        }

        return mdate('%d %M %y', $datetime);
    }
}

if (!function_exists('time_range')) {
    /**
     * Date range
     * Returns a list of time within a specified period.
     *
     * @param    int $unix_start UNIX timestamp of period start time
     * @param    int $unix_end UNIX timestamp of period end time
     * @param    int $interval Specifies the second interval
     * @param    string $time_format Output time format, same as in date()
     *
     * @return    array
     */
    function time_range($unix_start, $unix_end, $interval, $time_format = '%H:%i')
    {
        if ($unix_start == '' OR $unix_end == '' OR $interval == '') {
            return null;
        }

        $interval = ctype_digit($interval) ? $interval.' mins' : $interval;

        $start_time = strtotime($unix_start);
        $end_time = strtotime($unix_end);

        $current = time();
        $add_time = strtotime('+'.$interval, $current);
        $diff = $add_time - $current;

        $times = [];
        while ($start_time < $end_time) {
            $times[] = mdate($time_format, $start_time);
            $start_time += $diff;
        }
        $times[] = mdate($time_format, $start_time);

        return $times;
    }
}

if (!function_exists('make_carbon')) {
    /**
     * Converts mixed inputs to a Carbon object.
     *
     * @param $value
     * @param bool $throwException
     *
     * @return \Carbon\Carbon
     */
    function make_carbon($value, $throwException = TRUE)
    {
        if ($value instanceof Carbon) {
            // Do nothing
        }
        elseif ($value instanceof DateTime) {
            $value = Carbon::instance($value);
        }
        elseif (is_numeric($value)) {
            $value = Carbon::createFromTimestamp($value);
        }
        elseif (preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $value)) {
            $value = Carbon::createFromFormat('Y-m-d', $value)->startOfDay();
        }
        else {
            try {
                $value = Carbon::parse($value);
            }
            catch (Exception $ex) {
            }
        }

        if (!$value instanceof Carbon && $throwException) {
            throw new InvalidArgumentException('Invalid date value supplied to DateTime helper.');
        }

        return $value;
    }
}

if (!function_exists('is_single_location')) {
    /**
     * Is Single Location Mode
     * Test to see system config multi location mode is set to single.
     * @return bool
     */
    function is_single_location()
    {
        return (setting('site_location_mode') === 'single');
    }
}

if (!function_exists('log_message')) {
    /**
     * Error Logging Interface
     * We use this as a simple mechanism to access the logging
     * class and send messages to be logged.
     *
     * @param    string $level the error level: 'error', 'debug' or 'info'
     * @param    string $message the error message
     *
     * @return    void
     */
    function log_message($level, $message)
    {
        Log::$level($message);
    }
}

if (!function_exists('sort_array')) {
    /**
     * Sort an array by key
     *
     * @param array $array
     * @param string $sort_key
     * @param array $option
     *
     * @return array
     */
    function sort_array($array = [], $sort_key = 'priority', $option = SORT_ASC)
    {
        if (!empty($array)) {
            foreach ($array as $key => $value) {
                $sort_array[$key] = $value[$sort_key] ?? 0;
            }

            array_multisort($sort_array, $option, $array);
        }

        return $array;
    }
}

if (!function_exists('name_to_id')) {
    /**
     * Converts a HTML array string to an identifier string.
     * HTML: user[location][city]
     * Result: user-location-city
     *
     * @param $string String to process
     *
     * @return string
     */
    function name_to_id($string)
    {
        return rtrim(str_replace('--', '-', str_replace(['[', ']'], '-', str_replace('_', '-', $string))), '-');
    }
}

if (!function_exists('name_to_array')) {

    /**
     * Converts a HTML named array string to a PHP array. Empty values are removed.
     * HTML: user[location][city]
     * PHP:  ['user', 'location', 'city']
     *
     * @param $string String to process
     *
     * @return array
     */
    function name_to_array($string)
    {
        $result = [$string];

        if (strpbrk($string, '[]') === FALSE)
            return $result;

        if (preg_match('/^([^\]]+)(?:\[(.+)\])+$/', $string, $matches)) {
            if (count($matches) < 2)
                return $result;

            $result = explode('][', $matches[2]);
            array_unshift($result, $matches[1]);
        }

        $result = array_filter($result, function ($val) {
            return strlen($val);
        });

        return $result;
    }
}

if (!function_exists('convert_camelcase_to_underscore')) {
    /**
     * Convert CamelCase to underscore Camel_Case
     * Converts a StringWithCamelCase into string_with_underscore. Strings can be passed via the
     * first parameter either as a string or an array.
     *
     * @param string $string
     * @param bool $lowercase
     *
     * @return string CamelCase
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

if (!function_exists('convert_underscore_to_camelcase')) {
    /**
     * Current URL
     * Converts a string_with_underscore into StringWithCamelCase. Strings can be passed via the
     * first parameter either as a string or an array.
     * @access    public
     * @return    string
     */
    function convert_underscore_to_camelcase($string = '')
    {
        return str_replace(' ', '', ucwords(str_replace('_', ' ', $string)));
    }
}

if (!function_exists('contains_substring')) {
    /**
     * Determine if a given string contains a given substring.
     * @access    public
     *
     * @param  string $haystack
     * @param  string|array $needles
     *
     * @return bool
     */
    function contains_substring($haystack, $needles)
    {
        foreach ((array)$needles as $needle) {
            if ($needle != '' && mb_strpos($haystack, $needle) !== FALSE) {
                return TRUE;
            }
        }

        return FALSE;
    }
}

