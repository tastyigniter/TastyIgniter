<?php
/**
 * Part of JsonMapper
 *
 * PHP version 5
 *
 * @category Netresearch
 * @package  JsonMapper
 * @author   Christian Weiske <christian.weiske@netresearch.de>
 * @license  OSL-3.0 http://opensource.org/licenses/osl-3.0
 * @link     http://www.netresearch.de/
 */

/**
 * Unit test helper class for testing property mapping
 *
 * @category Netresearch
 * @package  JsonMapper
 * @author   Christian Weiske <christian.weiske@netresearch.de>
 * @license  OSL-3.0 http://opensource.org/licenses/osl-3.0
 * @link     http://www.netresearch.de/
 */
class JsonMapperTest_Simple
{
    /**
     * @var bool
     */
    public $pbool;

    /**
     * @var boolean
     */
    public $pboolean;

    /**
     * @var int
     */
    public $pint;

    /**
     * @var integer
     */
    public $pinteger;

    /**
     * @var int|null
     */
    public $pnullable;

    /**
     * @var float
     */
    public $fl;

    /**
     * @var double
     */
    public $db;

    /**
     * @var mixed
     */
    public $mixed;

    /**
     * @var string
     */
    public $str;

    /**
     * This property has no @-var type hint
     */
    public $notype;

    /**
     * @var \DateTime
     */
    public $datetime;

    /**
     * @var string A protected property without a setter method
     */
    protected $protectedStrNoSetter;
    /**
     * @var JsonMapperTest_Simple
     */
    public $simple;

    public $internalData;

    /**
     * Variable name with underscore
     * @var string
     */
    public $under_score;

    /**
     * @var
     */
    public $empty;

    /**
     * @var string
     */
    public $setterPreferredOverProperty;

    /**
     * Value object which needs to be set as an instance (without mapping)
     * @var JsonMapperTest_ValueObject
     */
    public $valueObject;

    public function setSimpleSetterOnlyTypeHint(JsonMapperTest_Simple $s)
    {
        $this->internalData['typehint'] = $s;
    }

    /**
     * @param JsonMapperTest_Simple $s Some test object
     */
    public function setSimpleSetterOnlyDocblock($s)
    {
        $this->internalData['docblock'] = $s;
    }

    public function setSimpleSetterOnlyNoType($s)
    {
        $this->internalData['notype'] = $s;
    }

    public function getProtectedStrNoSetter()
    {
        return $this->protectedStrNoSetter;
    }

    public function setUnderScoreSetter($v)
    {
        $this->internalData['under_score_setter'] = $v;
    }

    public function setSetterPreferredOverProperty($v)
    {
        $this->setterPreferredOverProperty = 'set via setter: ' . $v;
    }

    /**
     * @return JsonMapperTest_ValueObject
     */
    public function getValueObject()
    {
        return $this->valueObject;
    }

    /**
     * @param JsonMapperTest_ValueObject $valueObject
     */
    public function setValueObject(JsonMapperTest_ValueObject $valueObject)
    {
        $this->valueObject = $valueObject;
    }

    public $additional = [];

    public function addAdditionalProperty($key, $value)
    {
        $this->additional[$key] = $value;
    }

    /**
     * @param string $key
     * @param int $value
     */
    public function addTypedAdditionalProperty($key, $value)
    {
        $this->additional[$key] = $value;
    }

    /**
     * @param string $key
     * @param JsonMapperTest_Simple $value
     */
    public function addCustomTypedAdditionalProperty($key, $value)
    {
        $this->additional[$key] = $value;
    }

    /**
     * @factory FactoryMethod::createFromInt
     *
     * @param string $key
     * @param bool $value
     */
    public function addFactoryAdditionalProperty($key, $value)
    {
        $this->additional[$key] = $value;
    }

    /**
     * @mapsBy oneOf(float,mixed)
     *
     * @param string $key
     * @param int|float $value
     */
    public function addMapsByAdditionalProperty($key, $value)
    {
        $this->additional[$key] = $value;
    }

    /**
     * @mapsBy anyOf(int,bool)
     * @factory FactoryMethod::createFromIntStrict int
     * @factory FactoryMethod::createFromBoolStrict bool
     *
     * @param string $key
     * @param int|bool $value
     */
    public function addMapsByFactoryAdditionalProperty($key, $value)
    {
        $this->additional[$key] = $value;
    }

    private function privateAddAdditionalProperty($key, $value)
    {
        $this->additional[$key] = $value;
    }

    public function brokenAddAdditionalProperty($value)
    {
        $this->additional[] = $value;
    }
}
?>
