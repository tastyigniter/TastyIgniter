<?php

namespace multitypetest\model;

use stdClass;

/**
 * This class contains inner array case of oneOf.
 */
class SimpleCaseB implements \JsonSerializable
{
    /**
     * @var bool|int[]|array
     */
    private $value;

    /**
     * @param bool|int[]|array $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * Returns Value.
     * @return bool|int[]|array
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Sets Value.
     *
     * @param bool|int[]|array $value
     * @required
     * @maps value
     * @mapsBy oneOf(bool,int[],array)
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
     * @return mixed
     */
    #[\ReturnTypeWillChange]
    public function jsonSerialize($asArrayWhenEmpty = false)
    {
        $json = [];
        $json['value'] = $this->value;

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
