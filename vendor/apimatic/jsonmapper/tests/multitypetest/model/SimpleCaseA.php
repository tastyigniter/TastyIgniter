<?php

namespace multitypetest\model;

use stdClass;

/**
 * This class contains simple case of oneOf.
 */
class SimpleCaseA implements \JsonSerializable
{
    /**
     * @var int[]|float[]|bool
     */
    private $value;

    /**
     * @param int[]|float[]|bool $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * Returns Value.
     *
     * @return int[]|float[]|bool
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Sets Value.
     *
     * @param int[]|float[]|bool $value
     * @required
     * @maps value
     * @mapsBy anyOf(int[],float[],bool)
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * Encode this object to JSON
     *
     * @param bool $asArrayWhenEmpty Whether to serialize this model as an array whenever no fields
     *        are set. (default: false)
     *
     * @return array|stdClass
     */
    #[\ReturnTypeWillChange]
    public function jsonSerialize($asArrayWhenEmpty = false)
    {
        $json = [];
        $json['value'] = $this->value;

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
