<?php

/**
 * Country helper functions
 */
if (!function_exists('format_address')) {

    function format_address($address, $useLineBreaks = true, $useDefaultFormat = false)
    {
        return Country::addressFormat($address, $useLineBreaks, $useDefaultFormat);
    }
}

if (!function_exists('countries')) {

    function countries($column = 'country_name', $key = 'country_id')
    {
        return Country::listAll($column, $key);
    }
}
