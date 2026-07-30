<?php

namespace multitypetest\model;

use stdClass;

/**
 * Lion Class
 */
class Lion implements \JsonSerializable
{
    /**
     * @var bool
     */
    private $run;

    /**
     * @var string|null
     */
    private $type;

    /**
     * @param bool $run
     */
    public function __construct($run)
    {
        $this->run = $run;
    }

    /**
     * Returns Run.
     */
    public function getRun()
    {
        return $this->run;
    }

    /**
     * Sets Starts At.
     *
     * Session start time
     *
     * @required
     * @maps run
     */
    public function setRun($run)
    {
        $this->run = $run;
    }

    /**
     * Returns Session Type.
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Sets Session Type.
     *
     * @maps type
     */
    public function setType($type)
    {
        $this->type = $type;
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
        $json['run']    = $this->run;
        $json['type']      = $this->type;

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
