<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Provides metadata when the event `type` is `CREATE_REWARD`.
 */
class LoyaltyEventCreateReward implements \JsonSerializable
{
    /**
     * @var string
     */
    private $loyaltyProgramId;

    /**
     * @var string|null
     */
    private $rewardId;

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
     * The ID of the [loyalty program](entity:LoyaltyProgram).
     */
    public function getLoyaltyProgramId(): string
    {
        return $this->loyaltyProgramId;
    }

    /**
     * Sets Loyalty Program Id.
     * The ID of the [loyalty program](entity:LoyaltyProgram).
     *
     * @required
     * @maps loyalty_program_id
     */
    public function setLoyaltyProgramId(string $loyaltyProgramId): void
    {
        $this->loyaltyProgramId = $loyaltyProgramId;
    }

    /**
     * Returns Reward Id.
     * The Square-assigned ID of the created [loyalty reward](entity:LoyaltyReward).
     * This field is returned only if the event source is `LOYALTY_API`.
     */
    public function getRewardId(): ?string
    {
        return $this->rewardId;
    }

    /**
     * Sets Reward Id.
     * The Square-assigned ID of the created [loyalty reward](entity:LoyaltyReward).
     * This field is returned only if the event source is `LOYALTY_API`.
     *
     * @maps reward_id
     */
    public function setRewardId(?string $rewardId): void
    {
        $this->rewardId = $rewardId;
    }

    /**
     * Returns Points.
     * The loyalty points used to create the reward.
     */
    public function getPoints(): int
    {
        return $this->points;
    }

    /**
     * Sets Points.
     * The loyalty points used to create the reward.
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
        if (isset($this->rewardId)) {
            $json['reward_id']      = $this->rewardId;
        }
        $json['points']             = $this->points;
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
