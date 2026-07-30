<?php

namespace multitypetest\model;

use stdClass;

/**
 * This class contains simple case of oneOf.
 */
class Car extends Vehicle implements \JsonSerializable
{
    /**
     * @var bool
     */
    private $haveTrunk;

    /**
     * @param string $numberOfTyres
     * @param bool $haveTrunk
     */
    public function __construct($numberOfTyres, $haveTrunk)
    {
        parent::__construct($numberOfTyres);
        $this->haveTrunk = $haveTrunk;
    }

    /**
     * Returns HaveTrunk.
     * @return bool
     */
    public function getHaveTrunk()
    {
        return $this->haveTrunk;
    }

    /**
     * Sets HaveTrunk.
     * @param bool $haveTrunk
     *
     * @maps haveTrunk
     */
    public function setHaveTrunk($haveTrunk)
    {
        $this->haveTrunk = $haveTrunk;
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
        $json['haveTrunk'] = $this->haveTrunk;
        $json = array_merge($json, parent::jsonSerialize(true));

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
