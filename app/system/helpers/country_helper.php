<?php

/**
 * Country helper functions
 * @package System
 */

if (!function_exists('format_address')) {

    function format_address($address, $useLineBreaks = TRUE)
    {
        return Country::addressFormat($address, $useLineBreaks);
    }
}

if (!function_exists('countries')) {

    function countries($column = 'country_name', $key = 'country_id')
    {
        return Country::listAll($column, $key);
    }
}
