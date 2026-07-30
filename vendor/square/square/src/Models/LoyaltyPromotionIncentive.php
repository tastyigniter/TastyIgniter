<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents how points for a [loyalty promotion]($m/LoyaltyPromotion) are calculated,
 * either by multiplying the points earned from the base program or by adding a specified number
 * of points to the points earned from the base program.
 */
class LoyaltyPromotionIncentive implements \JsonSerializable
{
    /**
     * @var string
     */
    private $type;

    /**
     * @var LoyaltyPromotionIncentivePointsMultiplierData|null
     */
    private $pointsMultiplierData;

    /**
     * @var LoyaltyPromotionIncentivePointsAdditionData|null
     */
    private $pointsAdditionData;

    /**
     * @param string $type
     */
    public function __construct(string $type)
    {
        $this->type = $type;
    }

    /**
     * Returns Type.
     * Indicates the type of points incentive for a [loyalty promotion]($m/LoyaltyPromotion),
     * which is used to determine how buyers can earn points from the promotion.
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Sets Type.
     * Indicates the type of points incentive for a [loyalty promotion]($m/LoyaltyPromotion),
     * which is used to determine how buyers can earn points from the promotion.
     *
     * @required
     * @maps type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * Returns Points Multiplier Data.
     * Represents the metadata for a `POINTS_MULTIPLIER` type of [loyalty promotion
     * incentive]($m/LoyaltyPromotionIncentive).
     */
    public function getPointsMultiplierData(): ?LoyaltyPromotionIncentivePointsMultiplierData
    {
        return $this->pointsMultiplierData;
    }

    /**
     * Sets Points Multiplier Data.
     * Represents the metadata for a `POINTS_MULTIPLIER` type of [loyalty promotion
     * incentive]($m/LoyaltyPromotionIncentive).
     *
     * @maps points_multiplier_data
     */
    public function setPointsMultiplierData(?LoyaltyPromotionIncentivePointsMultiplierData $pointsMultiplierData): void
    {
        $this->pointsMultiplierData = $pointsMultiplierData;
    }

    /**
     * Returns Points Addition Data.
     * Represents the metadata for a `POINTS_ADDITION` type of [loyalty promotion
     * incentive]($m/LoyaltyPromotionIncentive).
     */
    public function getPointsAdditionData(): ?LoyaltyPromotionIncentivePointsAdditionData
    {
        return $this->pointsAdditionData;
    }

    /**
     * Sets Points Addition Data.
     * Represents the metadata for a `POINTS_ADDITION` type of [loyalty promotion
     * incentive]($m/LoyaltyPromotionIncentive).
     *
     * @maps points_addition_data
     */
    public function setPointsAdditionData(?LoyaltyPromotionIncentivePointsAdditionData $pointsAdditionData): void
    {
        $this->pointsAdditionData = $pointsAdditionData;
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
        $json['type']                       = $this->type;
        if (isset($this->pointsMultiplierData)) {
            $json['points_multiplier_data'] = $this->pointsMultiplierData;
        }
        if (isset($this->pointsAdditionData)) {
            $json['points_addition_data']   = $this->pointsAdditionData;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
