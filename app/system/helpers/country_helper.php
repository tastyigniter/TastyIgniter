<?php

/**
 * Country helper functions
 * @package System
 */

if (!function_exists('format_address')) {

    function format_address($address, $useLineBreaks = TRUE)
    {
        return app('country')->addressFormat($address, $useLineBreaks);
    }
}

if (!function_exists('countries')) {

    function countries($column = 'country_name', $key = 'country_id')
    {
        return app('country')->listAll($column, $key);
    }
}
