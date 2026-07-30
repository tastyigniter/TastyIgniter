<?php
namespace Ably;

/**
 * Ably logger, this is a static class
 */
class Log {
    const NONE    = 0;
    const ERROR   = 1;
    const WARNING = 2;
    const DEBUG   = 3;
    const VERBOSE = 4;

    protected static $logLevel;
    protected static $logCallback;

    private function __construct() {
        // this is a static class!
    }

    /**
     * @return integer currently set log level
     */
    public static function getLogLevel() {
        return self::$logLevel;
    }

    /**
     * Sets the log level
     * @param integer $loglevel one of the log level constants, e.g. Log::DEBUG
     */
    public static function setLogLevel( $logLevel ) {
        self::$logLevel = $logLevel;
    }

    /**
     * Sets a custom logging function that will be called in place of self::log()
     * @param function|null $function Custom function or leave empty to revert to default
     */
    public static function setLogCallback( $function = null ) {
        self::$logCallback = $function;
    }

    /**
     * Log verbose level information.
     * @param mixed ... Any number of variables or messages to log
     */
    public static function v(/*...*/) {
        self::log( Log::VERBOSE, func_get_args() );
    }

    /**
     * Log debug level information.
     * @param mixed ... Any number of variables or messages to log
     */
    public static function d(/*...*/) {
        self::log( Log::DEBUG, func_get_args() );
    }

    /**
     * Log warning level information.
     * @param mixed ... Any number of variables or messages to log
     */
    public static function w(/*...*/) {
        self::log( Log::WARNING, func_get_args() );
    }

    /**
     * Log error level information.
     * @param mixed ... Any number of variables or messages to log
     */
    public static function e(/*...*/) {
        self::log( Log::ERROR, func_get_args() );
    }

    /**
     * Logs provided message if log level matches requested level.
     * Calls either built-in function or a custom callback if provided
     * @param integer $level Log level
     * @param array $args arguments to dump
     */
    public static function log( $level, $args ) {
        if ( self::$logLevel >= $level ) {
            $function = self::$logCallback;
            return $function ? $function( $level, $args ) : self::defaultLogCallback( $level, $args );
        }
    }

    /**
     * The default logging function
     */
    private static function defaultLogCallback( $level, $args ) {
        $last = count($args) - 1;

        $timestamp = date( "Y-m-d H:i:s\t" );

        foreach ($args as $i => $arg) {
            if (is_string($arg)) {
                file_put_contents( 'php://stdout', $timestamp . $arg . ($i == $last ? "\n" : "\t") );
            }
            else if (is_bool($arg)) {
                file_put_contents( 'php://stdout', $timestamp . ($arg ? 'true' : 'false') . ($i == $last ? "\n" : "\t") );
            }
            else if (is_scalar($arg)) {
                file_put_contents( 'php://stdout', $timestamp . $arg . ($i == $last ? "\n" : "\t") );
            }
            else {
                file_put_contents( 'php://stdout', $timestamp . print_r( $arg, true ). "\n" );
            }
        }
    }
}
