<?php

/**
 * Country helper functions
 *
 * @package System
 */

if (!function_exists('format_address')) {

    function format_address($address, $useLineBreaks = true)
    {
        get_instance()->load->library('country');
        return get_instance()->country->addressFormat($address, $useLineBreaks);
    }
}