<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Provides metadata when the event `type` is `EXPIRE_POINTS`.
 */
class LoyaltyEventExpirePoints implements \JsonSerializable
{
    /**
     * @var string
     */
    private $loyaltyProgramId;

    /**
     * @var int
     */
    private $points;

    /**
     * @param string $loyaltyProgramId
     * @param int $points
     */
    public function __construct(string $loyaltyProgramId, int $points)
    {
        $this->loyaltyProgramId = $loyaltyProgramId;
        $this->points = $points;
    }

    /**
     * Returns Loyalty Program Id.
     * The Square-assigned ID of the [loyalty program](entity:LoyaltyProgram).
     */
    public function getLoyaltyProgramId(): string
    {
        return $this->loyaltyProgramId;
    }

    /**
     * Sets Loyalty Program Id.
     * The Square-assigned ID of the [loyalty program](entity:LoyaltyProgram).
     *
     * @required
     * @maps loyalty_program_id
     */
    public function setLoyaltyProgramId(string $loyaltyProgramId): void
    {
        $this->loyaltyProgramId = $loyaltyProgramId;
    }

    /**
     * Returns Points.
     * The number of points expired.
     */
    public function getPoints(): int
    {
        return $this->points;
    }

    /**
     * Sets Points.
     * The number of points expired.
     *
     * @required
     * @maps points
     */
    public function setPoints(int $points): void
    {
        $this->points = $points;
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
        $json['loyalty_program_id'] = $this->loyaltyProgramId;
        $json['points']             = $this->points;
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
