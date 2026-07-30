<?php
/**
 * Part of JsonMapper
 *
 * PHP version 5
 *
 * @package  JsonMapper
 * @author   Mehdi Raza <mehdi.jaffery@apimatic.io>
 * @license  OSL-3.0 http://opensource.org/licenses/osl-3.0
 * @link     https://apimatic.io/
 */

/**
 * Unit test helper class for testing property mapping
 *
 * @package  JsonMapper
 * @author   Mehdi Raza <mehdi.jaffery@apimatic.io>
 * @license  OSL-3.0 http://opensource.org/licenses/osl-3.0
 * @link     https://apimatic.io/
 */
class FactoryMethod
{
    private $privateValue;

    /**
     * @var string
     */
    public $simple;

    /**
     * @factory FactoryMethod::createFromValue
     */
    public $value;

    /**
     * @var bool
     * @factory FactoryMethod::createFromInt
     */
    public $bool;

    /**
     * @factory FactoryMethod::createFromTimestamp
     */
    public $datetime;

    /**
     * @factory FactoryMethod::createObjectFromValue
     */
    public $object;

    /**
     * @factory FactoryMethod::createObjectFromValue
     */
    public $objObj;

    /**
     * @var int[]
     * @factory FactoryMethod::createArrayFromArray
     */
    public $array;

    /**
     * @var int
     * @factory FactoryMethod::createValueFromArray
     */
    public $valueArr;

    /**
     * @factory FactoryMethod::createFromValue
     */
    public function setPrivateValue($val)
    {
        $this->privateValue = $val;
    }

    public function getPrivateValue()
    {
        return $this->privateValue;
    }

    public static function createFromValue($value)
    {
        return 'value is ' . $value;
    }

    public static function createFromBoolStrict($value)
    {
        if (!is_bool($value)) {
            throw new InvalidArgumentException('Only boolean types are allowed');
        }
        return 'value is ' . $value;
    }

    public static function createFromInt($value)
    {
        return $value === 1;
    }

    public static function createFromIntStrict($value)
    {
        if (!is_numeric($value)) {
            throw new InvalidArgumentException('Only integer types are allowed');
        }
        return $value === 1;
    }

    public static function createFromTimestamp($value)
    {
        return new DateTime('@' . $value);
    }

    public static function createObjectFromValue($value)
    {
        return new JsonMapperTest_ValueObject($value);
    }

    public static function createArrayFromArray($value)
    {
        return array_map('FactoryMethod::cube', $value);
    }

    public static function createValueFromArray($value)
    {
        $val = 0;
        for ($i=0; $i < count($value); $i++) { 
            $val += $value[$i];
        }
        return $val;
    }

    public static function cube($n)
    {
        return($n * $n);
    }
}
?>
