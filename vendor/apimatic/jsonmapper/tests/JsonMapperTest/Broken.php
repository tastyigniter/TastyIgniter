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
class JsonMapperTest_Broken
{
    /**
     * @var ArrayObject[ThisClassDoesNotExist]
     */
    public $pTypedArrayObjectNoClass;

    /**
     *
     * @var string
     * @required
     */
    public $pMissingData;
}
?>
