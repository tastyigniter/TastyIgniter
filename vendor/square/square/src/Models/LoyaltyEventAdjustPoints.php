<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Provides metadata when the event `type` is `ADJUST_POINTS`.
 */
class LoyaltyEventAdjustPoints implements \JsonSerializable
{
    /**
     * @var string|null
     */
    private $loyaltyProgramId;

    /**
     * @var int
     */
    private $points;

    /**
     * @var array
     */
    private $reason = [];

    /**
     * @param int $points
     */
    public function __construct(int $points)
    {
        $this->points = $points;
    }

    /**
     * Returns Loyalty Program Id.
     * The Square-assigned ID of the [loyalty program](entity:LoyaltyProgram).
     */
    public function getLoyaltyProgramId(): ?string
    {
        return $this->loyaltyProgramId;
    }

    /**
     * Sets Loyalty Program Id.
     * The Square-assigned ID of the [loyalty program](entity:LoyaltyProgram).
     *
     * @maps loyalty_program_id
     */
    public function setLoyaltyProgramId(?string $loyaltyProgramId): void
    {
        $this->loyaltyProgramId = $loyaltyProgramId;
    }

    /**
     * Returns Points.
     * The number of points added or removed.
     */
    public function getPoints(): int
    {
        return $this->points;
    }

    /**
     * Sets Points.
     * The number of points added or removed.
     *
     * @required
     * @maps points
     */
    public function setPoints(int $points): void
    {
        $this->points = $points;
    }

    /**
     * Returns Reason.
     * The reason for the adjustment of points.
     */
    public function getReason(): ?string
    {
        if (count($this->reason) == 0) {
            return null;
        }
        return $this->reason['value'];
    }

    /**
     * Sets Reason.
     * The reason for the adjustment of points.
     *
     * @maps reason
     */
    public function setReason(?string $reason): void
    {
        $this->reason['value'] = $reason;
    }

    /**
     * Unsets Reason.
     * The reason for the adjustment of points.
     */
    public function unsetReason(): void
    {
        $this->reason = [];
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
        if (isset($this->loyaltyProgramId)) {
            $json['loyalty_program_id'] = $this->loyaltyProgramId;
        }
        $json['points']                 = $this->points;
        if (!empty($this->reason)) {
            $json['reason']             = $this->reason['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
