<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents the number of times a buyer can earn points during a [loyalty
 * promotion]($m/LoyaltyPromotion).
 * If this field is not set, buyers can trigger the promotion an unlimited number of times to earn
 * points during
 * the time that the promotion is available.
 *
 * A purchase that is disqualified from earning points because of this limit might qualify for another
 * active promotion.
 */
class LoyaltyPromotionTriggerLimit implements \JsonSerializable
{
    /**
     * @var int
     */
    private $times;

    /**
     * @var string|null
     */
    private $interval;

    /**
     * @param int $times
     */
    public function __construct(int $times)
    {
        $this->times = $times;
    }

    /**
     * Returns Times.
     * The maximum number of times a buyer can trigger the promotion during the specified `interval`.
     */
    public function getTimes(): int
    {
        return $this->times;
    }

    /**
     * Sets Times.
     * The maximum number of times a buyer can trigger the promotion during the specified `interval`.
     *
     * @required
     * @maps times
     */
    public function setTimes(int $times): void
    {
        $this->times = $times;
    }

    /**
     * Returns Interval.
     * Indicates the time period that the [trigger limit]($m/LoyaltyPromotionTriggerLimit) applies to,
     * which is used to determine the number of times a buyer can earn points for a [loyalty
     * promotion]($m/LoyaltyPromotion).
     */
    public function getInterval(): ?string
    {
        return $this->interval;
    }

    /**
     * Sets Interval.
     * Indicates the time period that the [trigger limit]($m/LoyaltyPromotionTriggerLimit) applies to,
     * which is used to determine the number of times a buyer can earn points for a [loyalty
     * promotion]($m/LoyaltyPromotion).
     *
     * @maps interval
     */
    public function setInterval(?string $interval): void
    {
        $this->interval = $interval;
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
        $json['times']        = $this->times;
        if (isset($this->interval)) {
            $json['interval'] = $this->interval;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
