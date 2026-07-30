<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents a [CalculateLoyaltyPoints]($e/Loyalty/CalculateLoyaltyPoints) response.
 */
class CalculateLoyaltyPointsResponse implements \JsonSerializable
{
    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * @var int|null
     */
    private $points;

    /**
     * @var int|null
     */
    private $promotionPoints;

    /**
     * Returns Errors.
     * Any errors that occurred during the request.
     *
     * @return Error[]|null
     */
    public function getErrors(): ?array
    {
        return $this->errors;
    }

    /**
     * Sets Errors.
     * Any errors that occurred during the request.
     *
     * @maps errors
     *
     * @param Error[]|null $errors
     */
    public function setErrors(?array $errors): void
    {
        $this->errors = $errors;
    }

    /**
     * Returns Points.
     * The number of points that the buyer can earn from the base loyalty program.
     */
    public function getPoints(): ?int
    {
        return $this->points;
    }

    /**
     * Sets Points.
     * The number of points that the buyer can earn from the base loyalty program.
     *
     * @maps points
     */
    public function setPoints(?int $points): void
    {
        $this->points = $points;
    }

    /**
     * Returns Promotion Points.
     * The number of points that the buyer can earn from a loyalty promotion. To be eligible
     * to earn promotion points, the purchase must first qualify for program points. When `order_id`
     * is not provided in the request, this value is always 0.
     */
    public function getPromotionPoints(): ?int
    {
        return $this->promotionPoints;
    }

    /**
     * Sets Promotion Points.
     * The number of points that the buyer can earn from a loyalty promotion. To be eligible
     * to earn promotion points, the purchase must first qualify for program points. When `order_id`
     * is not provided in the request, this value is always 0.
     *
     * @maps promotion_points
     */
    public function setPromotionPoints(?int $promotionPoints): void
    {
        $this->promotionPoints = $promotionPoints;
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
        if (isset($this->errors)) {
            $json['errors']           = $this->errors;
        }
        if (isset($this->points)) {
            $json['points']           = $this->points;
        }
        if (isset($this->promotionPoints)) {
            $json['promotion_points'] = $this->promotionPoints;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
