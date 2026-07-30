<?php

namespace multitypetest\model;

use stdClass;

/**
 * This class contains simple case of oneOf.
 */
class Vehicle2 implements \JsonSerializable
{
    /**
     * @var int
     */
    private $numberOfTyres;

    /**
     * @param int $numberOfTyres
     */
    public function __construct($numberOfTyres)
    {
        $this->numberOfTyres = $numberOfTyres;
    }

    /**
     * Returns NumberOfTyres.
     * @return int
     */
    public function getNumberOfTyres()
    {
        return $this->numberOfTyres;
    }

    /**
     * Sets Value.
     * @param int
     *
     * @required
     * @maps numberOfTyres
     */
    public function setNumberOfTyres($numberOfTyres)
    {
        $this->numberOfTyres = $numberOfTyres;
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
        $json['numberOfTyres'] = $this->numberOfTyres;

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}