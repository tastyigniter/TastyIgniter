<?php

namespace multitypetest\model;

use stdClass;

/**
 * This class contains simple case of oneOf.
 */
class Vehicle implements \JsonSerializable
{
    /**
     * @var string
     */
    private $numberOfTyres;

    /**
     * @param string $numberOfTyres
     */
    public function __construct($numberOfTyres)
    {
        $this->numberOfTyres = $numberOfTyres;
    }

    /**
     * Returns NumberOfTyres.
     * @return string
     */
    public function getNumberOfTyres()
    {
        return $this->numberOfTyres;
    }

    /**
     * Sets Value.
     * @param string
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
