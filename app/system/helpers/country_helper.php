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