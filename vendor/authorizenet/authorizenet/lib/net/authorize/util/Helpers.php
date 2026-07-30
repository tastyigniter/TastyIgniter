<?php
namespace net\authorize\util;

/**
 * A class defining helpers
 *
 * @package    AuthorizeNet
 * @subpackage net\authorize\util
 */
class Helpers
{
    private static $initialized = false;

    /**
     * @return string current date-time
     */
    public static function now()
    {
        //init only once
        if ( ! self::$initialized)
        {
            self::$initialized = true;
        }
        return date( DATE_RFC2822);
    }
}
