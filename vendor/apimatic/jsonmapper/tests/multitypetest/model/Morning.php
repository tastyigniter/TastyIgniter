<?php

namespace multitypetest\model;

use stdClass;

/**
 * Course morning session
 *
 * @discriminator sessionType
 * @discriminatorType Morning
 */
class Morning implements \JsonSerializable
{
    /**
     * @var string
     */
    private $startsAt;

    /**
     * @var string
     */
    private $endsAt;

    /**
     * @var string|null
     */
    private $sessionType;

    /**
     * @param string $startsAt
     * @param string $endsAt
     */
    public function __construct($startsAt, $endsAt)
    {
        $this->startsAt = $startsAt;
        $this->endsAt = $endsAt;
    }

    /**
     * Returns Starts At.
     *
     * Session start time
     */
    public function getStartsAt()
    {
        return $this->startsAt;
    }

    /**
     * Sets Starts At.
     *
     * Session start time
     *
     * @required
     * @maps startsAt
     */
    public function setStartsAt($startsAt)
    {
        $this->startsAt = $startsAt;
    }

    /**
     * Returns Ends At.
     *
     * Session end time
     */
    public function getEndsAt()
    {
        return $this->endsAt;
    }

    /**
     * Sets Ends At.
     *
     * Session end time
     *
     * @required
     * @maps endsAt
     */
    public function setEndsAt($endsAt)
    {
        $this->endsAt = $endsAt;
    }

    /**
     * Returns Session Type.
     */
    public function getSessionType()
    {
        return $this->sessionType;
    }

    /**
     * Sets Session Type.
     *
     * @maps sessionType
     */
    public function setSessionType($sessionType)
    {
        $this->sessionType = $sessionType;
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
        $json['startsAt']      = $this->startsAt;
        $json['endsAt']        = $this->endsAt;
        $json['sessionType']   = $this->sessionType;

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
