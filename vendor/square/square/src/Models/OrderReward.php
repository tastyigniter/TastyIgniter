<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents a reward that can be applied to an order if the necessary
 * reward tier criteria are met. Rewards are created through the Loyalty API.
 */
class OrderReward implements \JsonSerializable
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $rewardTierId;

    /**
     * @param string $id
     * @param string $rewardTierId
     */
    public function __construct(string $id, string $rewardTierId)
    {
        $this->id = $id;
        $this->rewardTierId = $rewardTierId;
    }

    /**
     * Returns Id.
     * The identifier of the reward.
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Sets Id.
     * The identifier of the reward.
     *
     * @required
     * @maps id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * Returns Reward Tier Id.
     * The identifier of the reward tier corresponding to this reward.
     */
    public function getRewardTierId(): string
    {
        return $this->rewardTierId;
    }

    /**
     * Sets Reward Tier Id.
     * The identifier of the reward tier corresponding to this reward.
     *
     * @required
     * @maps reward_tier_id
     */
    public function setRewardTierId(string $rewardTierId): void
    {
        $this->rewardTierId = $rewardTierId;
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
        $json['id']             = $this->id;
        $json['reward_tier_id'] = $this->rewardTierId;
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
