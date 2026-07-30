<?php

namespace multitypetest\model;

use stdClass;

/**
 * This class contains simple case of oneOf.
 */
class SimpleCase implements \JsonSerializable
{
    /**
     * @var string[]
     */
    private $value;

    /**
     * @param string[] $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * Returns Value.
     *
     * @return string[]
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Sets Value.
     *
     * @param string[] $value
     * @required
     * @maps value
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
