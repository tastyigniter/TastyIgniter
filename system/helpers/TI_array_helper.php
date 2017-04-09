<?php
/**
 * TastyIgniter
 *
 * An open source online ordering, reservation and management system for restaurants.
 *
 * @package Igniter
 * @author Samuel Adepoyigi
 * @copyright (c) 2013 - 2016. Samuel Adepoyigi
 * @copyright (c) 2016 - 2017. TastyIgniter Dev Team
 * @link https://tastyigniter.com
 * @license http://opensource.org/licenses/MIT The MIT License
 * @since File available since Release 1.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Array helper functions
 *
 * @category       Helpers
 * @package        Igniter\Helpers\TI_array_helper.php
 * @link           http://docs.tastyigniter.com
 */

if (!function_exists('array_get')) {
    /**
     * Get an item from an array using "dot" notation.
     *
     * @param  array $array
     * @param  string $key
     * @param  mixed $default
     *
     * @return mixed
     */
    function array_get($array, $key, $default = null)
    {
        if (is_null($key)) {
            return $array;
        }

        if (isset($array[$key])) {
            return $array[$key];
        }

        foreach (explode('.', $key) as $segment) {
            if (!is_array($array) OR !array_key_exists($segment, $array)) {
                return $default;
            }

            $array = $array[$segment];
        }

        return $array;
    }
}

if (!function_exists('name_to_array')) {
    /**
     * Converts named array string to array
     * ex. field[key][key2] => ['field', 'key', 'key2']
     *
     * @param  string $string
     *
     * @return array
     */
    function name_to_array($string)
    {
        $result = [$string];

        if (strpbrk($string, '[]') === FALSE)
            return $result;

        $indexes = [];
        if (($is_array = (bool)preg_match_all('/\[(.*?)\]/', $string, $matches)) === TRUE) {
            sscanf($string, '%[^[][', $indexes[0]);

            for ($i = 0, $c = count($matches[0]); $i < $c; $i++) {
                if ($matches[1][$i] !== '') {
                    $indexes[] = $matches[1][$i];
                }
            }
        }

        return $indexes;
    }
}
