<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Sets the day of the week and hour of the day that a business starts a
 * workweek. This is used to calculate overtime pay.
 */
class WorkweekConfig implements \JsonSerializable
{
    /**
     * @var string|null
     */
    private $id;

    /**
     * @var string
     */
    private $startOfWeek;

    /**
     * @var string
     */
    private $startOfDayLocalTime;

    /**
     * @var int|null
     */
    private $version;

    /**
     * @var string|null
     */
    private $createdAt;

    /**
     * @var string|null
     */
    private $updatedAt;

    /**
     * @param string $startOfWeek
     * @param string $startOfDayLocalTime
     */
    public function __construct(string $startOfWeek, string $startOfDayLocalTime)
    {
        $this->startOfWeek = $startOfWeek;
        $this->startOfDayLocalTime = $startOfDayLocalTime;
    }

    /**
     * Returns Id.
     * The UUID for this object.
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Sets Id.
     * The UUID for this object.
     *
     * @maps id
     */
    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    /**
     * Returns Start of Week.
     * The days of the week.
     */
    public function getStartOfWeek(): string
    {
        return $this->startOfWeek;
    }

    /**
     * Sets Start of Week.
     * The days of the week.
     *
     * @required
     * @maps start_of_week
     */
    public function setStartOfWeek(string $startOfWeek): void
    {
        $this->startOfWeek = $startOfWeek;
    }

    /**
     * Returns Start of Day Local Time.
     * The local time at which a business week starts. Represented as a
     * string in `HH:MM` format (`HH:MM:SS` is also accepted, but seconds are
     * truncated).
     */
    public function getStartOfDayLocalTime(): string
    {
        return $this->startOfDayLocalTime;
    }

    /**
     * Sets Start of Day Local Time.
     * The local time at which a business week starts. Represented as a
     * string in `HH:MM` format (`HH:MM:SS` is also accepted, but seconds are
     * truncated).
     *
     * @required
     * @maps start_of_day_local_time
     */
    public function setStartOfDayLocalTime(string $startOfDayLocalTime): void
    {
        $this->startOfDayLocalTime = $startOfDayLocalTime;
    }

    /**
     * Returns Version.
     * Used for resolving concurrency issues. The request fails if the version
     * provided does not match the server version at the time of the request. If not provided,
     * Square executes a blind write; potentially overwriting data from another
     * write.
     */
    public function getVersion(): ?int
    {
        return $this->version;
    }

    /**
     * Sets Version.
     * Used for resolving concurrency issues. The request fails if the version
     * provided does not match the server version at the time of the request. If not provided,
     * Square executes a blind write; potentially overwriting data from another
     * write.
     *
     * @maps version
     */
    public function setVersion(?int $version): void
    {
        $this->version = $version;
    }

    /**
     * Returns Created At.
     * A read-only timestamp in RFC 3339 format; presented in UTC.
     */
    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    /**
     * Sets Created At.
     * A read-only timestamp in RFC 3339 format; presented in UTC.
     *
     * @maps created_at
     */
    public function setCreatedAt(?string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Returns Updated At.
     * A read-only timestamp in RFC 3339 format; presented in UTC.
     */
    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    /**
     * Sets Updated At.
     * A read-only timestamp in RFC 3339 format; presented in UTC.
     *
     * @maps updated_at
     */
    public function setUpdatedAt(?string $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * Encode this object to JSON
     *
     * @param bool $asArrayWhenEmpty Whether to serialize this model as an array whenever no fields
     *        are set. (default: false)
     *
     * @return array|stdClass
     */
    #[\ReturnTypeWillChange] // @phan-suppress-current-line PhanUndeclaredClassAttribute for (php < 8.1)
    public function jsonSerialize(bool $asArrayWhenEmpty = false)
    {
        $json = [];
        if (isset($this->id)) {
            $json['id']                  = $this->id;
        }
        $json['start_of_week']           = $this->startOfWeek;
        $json['start_of_day_local_time'] = $this->startOfDayLocalTime;
        if (isset($this->version)) {
            $json['version']             = $this->version;
        }
        if (isset($this->createdAt)) {
            $json['created_at']          = $this->createdAt;
        }
        if (isset($this->updatedAt)) {
            $json['updated_at']          = $this->updatedAt;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
