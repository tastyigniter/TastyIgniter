<?php

namespace multitypetest\model;

use stdClass;

/**
 * This class contains simple case of oneOf.
 */
class Atom implements \JsonSerializable
{
    /**
     * @var int
     */
    private $numberOfElectrons;

    /**
     * @var int
     */
    private $numberOfProtons;

    /**
     * @param int $numberOfElectrons
     */
    public function __construct($numberOfElectrons)
    {
        $this->numberOfElectrons = $numberOfElectrons;
    }

    /**
     * Returns NumberOfElectrons.
     * @return int
     */
    public function getNumberOfElectrons()
    {
        return $this->numberOfElectrons;
    }

    /**
     * Sets Value.
     * @param int
     *
     * @required
     * @maps $numberOfElectrons
     */
    public function setNumberOfElectrons($numberOfElectrons)
    {
        $this->numberOfElectrons = $numberOfElectrons;
    }

    /**
     * Returns NumberOfProtons.
     * @return int
     */
    public function getNumberOfProtons()
    {
        return $this->numberOfProtons;
    }

    /**
     * Sets Value.
     * @param int
     *
     * @required
     * @maps $numberOfProtons
     */
    public function setNumberOfProtons($numberOfProtons)
    {
        $this->numberOfProtons = $numberOfProtons;
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
        $json['numberOfElectrons'] = $this->numberOfElectrons;
        $json['numberOfProtons'] = $this->numberOfProtons;

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
