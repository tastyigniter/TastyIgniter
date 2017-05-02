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
namespace Igniter\Core;

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Extendable Class
 *
 * Adapted from the October Extendable Class
 * @link https://github.com/octobercms/library/tree/master/src/Extension/Extendable.php
 *
 * @package Igniter\Core
 * @author Alexey Bobkov, Samuel Georges
 * @author TastyIgniter Dev Team
 * @link https://docs.tastyigniter.com
 */
class Extendable
{
    use \Igniter\Traits\ExtendableTrait;

    public $implement;

    public function __construct()
    {
        $this->extendableConstruct();
    }

    public function __get($name)
    {
        return $this->extendableGet($name);
    }

    public function __set($name, $value)
    {
        $this->extendableSet($name, $value);
    }

    public function __call($name, $params)
    {
        return $this->extendableCall($name, $params);
    }

    public static function __callStatic($name, $params)
    {
        return self::extendableCallStatic($name, $params);
    }

    public static function extend(callable $callback)
    {
        self::extendableExtendCallback($callback);
    }

}