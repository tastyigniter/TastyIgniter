<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * A request to redeem a loyalty reward.
 */
class RedeemLoyaltyRewardRequest implements \JsonSerializable
{
    /**
     * @var string
     */
    private $idempotencyKey;

    /**
     * @var string
     */
    private $locationId;

    /**
     * @param string $idempotencyKey
     * @param string $locationId
     */
    public function __construct(string $idempotencyKey, string $locationId)
    {
        $this->idempotencyKey = $idempotencyKey;
        $this->locationId = $locationId;
    }

    /**
     * Returns Idempotency Key.
     * A unique string that identifies this `RedeemLoyaltyReward` request.
     * Keys can be any valid string, but must be unique for every request.
     */
    public function getIdempotencyKey(): string
    {
        return $this->idempotencyKey;
    }

    /**
     * Sets Idempotency Key.
     * A unique string that identifies this `RedeemLoyaltyReward` request.
     * Keys can be any valid string, but must be unique for every request.
     *
     * @required
     * @maps idempotency_key
     */
    public function setIdempotencyKey(string $idempotencyKey): void
    {
        $this->idempotencyKey = $idempotencyKey;
    }

    /**
     * Returns Location Id.
     * The ID of the [location](entity:Location) where the reward is redeemed.
     */
    public function getLocationId(): string
    {
        return $this->locationId;
    }

    /**
     * Sets Location Id.
     * The ID of the [location](entity:Location) where the reward is redeemed.
     *
     * @required
     * @maps location_id
     */
    public function setLocationId(string $locationId): void
    {
        $this->locationId = $locationId;
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
        $json['idempotency_key'] = $this->idempotencyKey;
        $json['location_id']     = $this->locationId;
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
