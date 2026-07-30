<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Describes when the loyalty program expires.
 */
class LoyaltyProgramExpirationPolicy implements \JsonSerializable
{
    /**
     * @var string
     */
    private $expirationDuration;

    /**
     * @param string $expirationDuration
     */
    public function __construct(string $expirationDuration)
    {
        $this->expirationDuration = $expirationDuration;
    }

    /**
     * Returns Expiration Duration.
     * The number of months before points expire, in `P[n]M` RFC 3339 duration format. For example, a value
     * of `P12M` represents a duration of 12 months.
     * Points are valid through the last day of the month in which they are scheduled to expire. For
     * example, with a  `P12M` duration, points earned on July 6, 2020 expire on August 1, 2021.
     */
    public function getExpirationDuration(): string
    {
        return $this->expirationDuration;
    }

    /**
     * Sets Expiration Duration.
     * The number of months before points expire, in `P[n]M` RFC 3339 duration format. For example, a value
     * of `P12M` represents a duration of 12 months.
     * Points are valid through the last day of the month in which they are scheduled to expire. For
     * example, with a  `P12M` duration, points earned on July 6, 2020 expire on August 1, 2021.
     *
     * @required
     * @maps expiration_duration
     */
    public function setExpirationDuration(string $expirationDuration): void
    {
        $this->expirationDuration = $expirationDuration;
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
        $json['expiration_duration'] = $this->expirationDuration;
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
