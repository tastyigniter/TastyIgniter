<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents the naming used for loyalty points.
 */
class LoyaltyProgramTerminology implements \JsonSerializable
{
    /**
     * @var string
     */
    private $one;

    /**
     * @var string
     */
    private $other;

    /**
     * @param string $one
     * @param string $other
     */
    public function __construct(string $one, string $other)
    {
        $this->one = $one;
        $this->other = $other;
    }

    /**
     * Returns One.
     * A singular unit for a point (for example, 1 point is called 1 star).
     */
    public function getOne(): string
    {
        return $this->one;
    }

    /**
     * Sets One.
     * A singular unit for a point (for example, 1 point is called 1 star).
     *
     * @required
     * @maps one
     */
    public function setOne(string $one): void
    {
        $this->one = $one;
    }

    /**
     * Returns Other.
     * A plural unit for point (for example, 10 points is called 10 stars).
     */
    public function getOther(): string
    {
        return $this->other;
    }

    /**
     * Sets Other.
     * A plural unit for point (for example, 10 points is called 10 stars).
     *
     * @required
     * @maps other
     */
    public function setOther(string $other): void
    {
        $this->other = $other;
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
        $json['one']   = $this->one;
        $json['other'] = $this->other;
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
