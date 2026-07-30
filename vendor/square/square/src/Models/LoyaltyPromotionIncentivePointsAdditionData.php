<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents the metadata for a `POINTS_ADDITION` type of [loyalty promotion
 * incentive]($m/LoyaltyPromotionIncentive).
 */
class LoyaltyPromotionIncentivePointsAdditionData implements \JsonSerializable
{
    /**
     * @var int
     */
    private $pointsAddition;

    /**
     * @param int $pointsAddition
     */
    public function __construct(int $pointsAddition)
    {
        $this->pointsAddition = $pointsAddition;
    }

    /**
     * Returns Points Addition.
     * The number of additional points to earn each time the promotion is triggered. For example,
     * suppose a purchase qualifies for 5 points from the base loyalty program. If the purchase also
     * qualifies for a `POINTS_ADDITION` promotion incentive with a `points_addition` of 3, the buyer
     * earns a total of 8 points (5 program points + 3 promotion points = 8 points).
     */
    public function getPointsAddition(): int
    {
        return $this->pointsAddition;
    }

    /**
     * Sets Points Addition.
     * The number of additional points to earn each time the promotion is triggered. For example,
     * suppose a purchase qualifies for 5 points from the base loyalty program. If the purchase also
     * qualifies for a `POINTS_ADDITION` promotion incentive with a `points_addition` of 3, the buyer
     * earns a total of 8 points (5 program points + 3 promotion points = 8 points).
     *
     * @required
     * @maps points_addition
     */
    public function setPointsAddition(int $pointsAddition): void
    {
        $this->pointsAddition = $pointsAddition;
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
        $json['points_addition'] = $this->pointsAddition;
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
