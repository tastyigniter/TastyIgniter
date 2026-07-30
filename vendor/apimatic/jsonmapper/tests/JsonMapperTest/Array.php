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
class JsonMapperTest_Array
{

    /**
     * @var float[]
     */
    public $flArray;

    /**
     * @var string[]
     */
    public $strArray;

    /**
     * @var array<string|null>
     */
    public $nullableStrArray;

    /**
     * @var array<string,string>
     */
    public $strMap;

    /**
     * @var array<string,string[]>
     */
    public $strMapOfArray;

    /**
     * @var array<string,string>[]
     */
    public $strArrayOfMap;

    /**
     * @var JsonMapperTest_Simple[]
     * @see http://phpdoc.org/docs/latest/references/phpdoc/types.html#arrays
     */
    public $typedArray;

    /**
     * @var array<JsonMapperTest_Simple|null>
     * @see http://phpdoc.org/docs/latest/references/phpdoc/types.html#arrays
     */
    public $nullableTypedArray;

    /**
     * @var array<string,JsonMapperTest_Simple>
     * @see http://phpdoc.org/docs/latest/references/phpdoc/types.html#arrays
     */
    public $typedMap;

    /**
     * @var array<string,JsonMapperTest_Simple>[]
     * @see http://phpdoc.org/docs/latest/references/phpdoc/types.html#arrays
     */
    public $typedArrayOfMap;

    /**
     * @var DateTime[]
     */
    public $typedSimpleArray;

    /**
     * This generates an array object with original json values
     * @var ArrayObject
     */
    public $pArrayObject;

    /**
     * This generates an array object with JsonMapperTest_Simple instances
     * @var ArrayObject[JsonMapperTest_Simple]
     */
    public $pTypedArrayObject;

    /**
     * @var ArrayObject[int]
     */
    public $pSimpleArrayObject;

}
?>
