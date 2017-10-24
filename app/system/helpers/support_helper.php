<?php

use Carbon\Carbon;
use Illuminate\Routing\UrlGenerator;

if (!function_exists('current_url')) {
    /**
     * Current URL
     *
     * Returns the full URL (including segments and query string) of the page where this
     * function is placed
     *
     * @return    string
     */
    function current_url()
    {
        return app(UrlGenerator::class)->current();
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
    function page_url($uri = '', $params = [])
    {
        return app(UrlGenerator::class)->to($uri, $params);
    }
}

if (!function_exists('site_url')) {
    /**
     * Site URL
     * Create a local URL based on your basepath. Segments can be passed via the
     * first parameter either as a string or an array.
     *
     * @param string $uri
     * @param string $protocol
     * @param array $params
     *
     * @return string
     */
    function site_url($uri = '', $protocol = null, $params = [])
    {
        return app(UrlGenerator::class)->to($uri, $params, $protocol);
    }
}

if (!function_exists('restaurant_url')) {
    /**
     * Restaurant URL
     *
     * Returns the full URL (including segments) of the local restaurant if any,
     * else locations URL is returned
     *
     * @param string $uri
     * @param string $protocol
     *
     * @return string
     */
    function restaurant_url($uri = '', $params = [])
    {
        return $uri;
        return app(UrlGenerator::class)->route('local', array_merge([
            'uri' => $uri,
        ], $params));
    }
}

if (!function_exists('assets_url')) {
    /**
     * Assets URL
     *
     * Returns the full URL (including segments) of the assets directory
     *
     * @param string $uri
     * @param null $protocol
     *
     * @return string
     */
    function assets_url($uri = '', $protocol = null)
    {
        return app(UrlGenerator::class)->asset('assets/'.$uri, $protocol);
    }
}

if (!function_exists('image_url')) {
    /**
     * Image Assets URL
     *
     * Returns the full URL (including segments) of the assets image directory
     *
     * @param string $uri
     * @param null $protocol
     *
     * @return string
     */
    function image_url($uri = '', $protocol = null)
    {
        return app(UrlGenerator::class)->asset('assets/images/'.$uri, $protocol);
    }
}

if (!function_exists('admin_url')) {
    /**
     * Admin URL
     *
     * Create a local URL based on your admin path.
     * Segments can be passed in as a string.
     *
     * @param    string $uri
     * @param    array $params
     *
     * @return    string
     */
    function admin_url($uri = '', $params = [])
    {
        return Admin::url($uri, $params);
    }
}

if (!function_exists('theme_url')) {
    /**
     * Theme URL
     *
     * Create a local URL based on your theme path.
     * Segments can be passed in as a string.
     *
     * @param    string $uri
     * @param    string $params
     *
     * @return    string
     */
    function theme_url($uri = '', $params = [])
    {
        return app(UrlGenerator::class)->asset('themes/'.$uri, $params);
    }
}

if (!function_exists('referrer_url')) {
    /**
     * Referrer URL
     *
     * Returns the full URL (including segments) of the page where this
     * function is placed
     *
     * @return    string
     */
    function referrer_url()
    {
        return app(UrlGenerator::class)->previous();
    }
}

if (!function_exists('root_url')) {
    /**
     * Root URL
     *
     * Create a local URL based on your root path.
     * Segments can be passed in as a string.
     *
     * @param    string $uri
     * @param    array $params
     *
     * @return    string
     */
    function root_url($uri = '', $params = [])
    {
        return app(UrlGenerator::class)->to($uri, $params);
    }
}

if (!function_exists('extension_path')) {
    /**
     * Get the path to the extensions folder.
     *
     * @param    string $path The path to prepend
     *
     * @return    string
     */
    function extension_path($path = null)
    {
        return rtrim(app('path.extensions'), DIRECTORY_SEPARATOR).($path ? DIRECTORY_SEPARATOR.$path : $path);
    }
}

if (!function_exists('assets_path')) {
    /**
     * Get the path to the assets folder.
     *
     * @param    string $path The path to prepend
     *
     * @return    string
     */
    function assets_path($path = null)
    {
        return rtrim(app('path.assets'), DIRECTORY_SEPARATOR).($path ? DIRECTORY_SEPARATOR.$path : $path);
    }
}

if (!function_exists('image_path')) {
    /**
     * Get the path to the assets image folder.
     *
     * @param    string $path The path to prepend
     *
     * @return    string
     */
    function image_path($path = null)
    {
        return assets_path('images').($path ? DIRECTORY_SEPARATOR.$path : $path);
    }
}

if (!function_exists('temp_path')) {
    /**
     * Get the path to the downloads temp folder.
     *
     * @param    string $path The path to prepend
     *
     * @return    string
     */
    function temp_path($path = null)
    {
        return storage_path('temp').($path ? DIRECTORY_SEPARATOR.$path : $path);
    }
}

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
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);

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

        if (!empty($options['REFERER'])) {
            curl_setopt($curl, CURLOPT_REFERER, current_url());
        }

        if (!empty($options['POSTFIELDS'])) {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($options['POSTFIELDS'], '', '&'));
        }

        if (!empty($options['FILE'])) {
            curl_setopt($curl, CURLOPT_FILE, $options['FILE']);
        }

        // Get response from the server.
        $response = curl_exec($curl);

        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if ($httpCode == 500) {
            log_message('error', 'cURL: Error --> ' . print_r(curl_getinfo($curl)) .' '. $url);
        }

        if (curl_error($curl)) {
            log_message('error', 'cURL: Error --> ' . curl_errno($curl) . ': ' . curl_error($curl) .' '. $url);
        }

        curl_close($curl);

        return $response;
    }
}

if ( ! function_exists('strip_class_basename'))
{
    function strip_class_basename($class = '', $chop = null)
    {
        $basename = class_basename($class);

        if (is_null($chop))
            return $basename;

        return substr($basename, 0, -strlen($chop));
    }
}

if ( ! function_exists('mdate'))
{
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
        if (is_null($format))
            $format = setting('date_format', config('system.dateFormat'));

        if (is_null($time))
            return null;

        if (empty($time))
            $time = time();

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
     *
     * Returns a time elapsed of seconds, minutes, hours, days in this format:
     *    10 days, 14 hours, 36 minutes, 47 seconds, now
     *
     * @param string $datetime
     * @param bool $full
     *
     * @return string
     */
    function time_elapsed($datetime, $full = FALSE)
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

        return $string ? implode(', ', $string).' ago' : 'just now';
    }
}

if (!function_exists('day_elapsed')) {
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
    function day_elapsed($datetime)
    {
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

if (!function_exists('time_range')) {
    /**
     * Date range
     *
     * Returns a list of time within a specified period.
     *
     * @param    int    unix_start    UNIX timestamp of period start time
     * @param    int    unix_end    UNIX timestamp of period end time
     * @param    int    interval        Specifies the second interval
     * @param    string  time_format    Output time format, same as in date()
     *
     * @return    array
     */
    function time_range($unix_start, $unix_end, $interval, $time_format = '%H:%i')
    {
        if ($unix_start == '' OR $unix_end == '' OR $interval == '') {
            return FALSE;
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
        } elseif ($value instanceof DateTime) {
            $value = Carbon::instance($value);
        } elseif (is_numeric($value)) {
            $value = Carbon::createFromTimestamp($value);
        } elseif (preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $value)) {
            $value = Carbon::createFromFormat('Y-m-d', $value)->startOfDay();
        } else {
            try {
                $value = Carbon::parse($value);
            } catch (Exception $ex) {
            }
        }

        if (!$value instanceof Carbon && $throwException) {
            throw new InvalidArgumentException('Invalid date value supplied to DateTime helper.');
        }

        return $value;
    }
}

if ( ! function_exists('is_single_location'))
{
    /**
     * Is Single Location Mode
     *
     * Test to see system config multi location mode is set to single.
     *
     * @return bool
     */
    function is_single_location()
    {
        return (setting('site_location_mode') === 'single');
    }
}

if ( ! function_exists('log_message'))
{
    /**
     * Error Logging Interface
     *
     * We use this as a simple mechanism to access the logging
     * class and send messages to be logged.
     *
     * @param	string	the error level: 'error', 'debug' or 'info'
     * @param	string	the error message
     * @return	void
     */
    function log_message($level, $message)
    {
        Log::$level($message);
    }
}

if ( ! function_exists('sort_array'))
{
    /**
     * Sort an array by key
     *
     * @param array  $array
     * @param string $sort_key
     * @param array  $option
     *
     * @return array
     */
    function sort_array($array = array(), $sort_key = 'priority', $option = SORT_ASC) {
        if (!empty($array)) {
            foreach ($array as $key => $value) {
                $sort_array[$key] = $value[$sort_key];
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
     *
     * Converts a StringWithCamelCase into string_with_underscore. Strings can be passed via the
     * first parameter either as a string or an array.
     *
     * @param string $string
     * @param bool $lowercase
     *
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

if (!function_exists('convert_underscore_to_camelcase')) {
    /**
     * Current URL
     *
     * Converts a string_with_underscore into StringWithCamelCase. Strings can be passed via the
     * first parameter either as a string or an array.
     *
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
     *
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

