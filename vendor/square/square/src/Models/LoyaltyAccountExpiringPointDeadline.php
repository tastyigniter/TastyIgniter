<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents a set of points for a loyalty account that are scheduled to expire on a specific date.
 */
class LoyaltyAccountExpiringPointDeadline implements \JsonSerializable
{
    /**
     * @var int
     */
    private $points;

    /**
     * @var string
     */
    private $expiresAt;

    /**
     * @param int $points
     * @param string $expiresAt
     */
    public function __construct(int $points, string $expiresAt)
    {
        $this->points = $points;
        $this->expiresAt = $expiresAt;
    }

    /**
     * Returns Points.
     * The number of points scheduled to expire at the `expires_at` timestamp.
     */
    public function getPoints(): int
    {
        return $this->points;
    }

    /**
     * Sets Points.
     * The number of points scheduled to expire at the `expires_at` timestamp.
     *
     * @required
     * @maps points
     */
    public function setPoints(int $points): void
    {
        $this->points = $points;
    }

    /**
     * Returns Expires At.
     * The timestamp of when the points are scheduled to expire, in RFC 3339 format.
     */
    public function getExpiresAt(): string
    {
        return $this->expiresAt;
    }

    /**
     * Sets Expires At.
     * The timestamp of when the points are scheduled to expire, in RFC 3339 format.
     *
     * @required
     * @maps expires_at
     */
    public function setExpiresAt(string $expiresAt): void
    {
        $this->expiresAt = $expiresAt;
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
        $json['points']     = $this->points;
        $json['expires_at'] = $this->expiresAt;
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
