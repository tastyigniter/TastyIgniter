<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents the metadata for a `POINTS_MULTIPLIER` type of [loyalty promotion
 * incentive]($m/LoyaltyPromotionIncentive).
 */
class LoyaltyPromotionIncentivePointsMultiplierData implements \JsonSerializable
{
    /**
     * @var int
     */
    private $pointsMultiplier;

    /**
     * @param int $pointsMultiplier
     */
    public function __construct(int $pointsMultiplier)
    {
        $this->pointsMultiplier = $pointsMultiplier;
    }

    /**
     * Returns Points Multiplier.
     * The multiplier used to calculate the number of points earned each time the promotion
     * is triggered. For example, suppose a purchase qualifies for 5 points from the base loyalty program.
     * If the purchase also qualifies for a `POINTS_MULTIPLIER` promotion incentive with a
     * `points_multiplier`
     * of 3, the buyer earns a total of 15 points (5 program points x 3 promotion multiplier = 15 points).
     */
    public function getPointsMultiplier(): int
    {
        return $this->pointsMultiplier;
    }

    /**
     * Sets Points Multiplier.
     * The multiplier used to calculate the number of points earned each time the promotion
     * is triggered. For example, suppose a purchase qualifies for 5 points from the base loyalty program.
     * If the purchase also qualifies for a `POINTS_MULTIPLIER` promotion incentive with a
     * `points_multiplier`
     * of 3, the buyer earns a total of 15 points (5 program points x 3 promotion multiplier = 15 points).
     *
     * @required
     * @maps points_multiplier
     */
    public function setPointsMultiplier(int $pointsMultiplier): void
    {
        $this->pointsMultiplier = $pointsMultiplier;
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
        $json['points_multiplier'] = $this->pointsMultiplier;
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
