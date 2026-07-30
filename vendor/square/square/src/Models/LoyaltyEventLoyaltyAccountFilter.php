<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Filter events by loyalty account.
 */
class LoyaltyEventLoyaltyAccountFilter implements \JsonSerializable
{
    /**
     * @var string
     */
    private $loyaltyAccountId;

    /**
     * @param string $loyaltyAccountId
     */
    public function __construct(string $loyaltyAccountId)
    {
        $this->loyaltyAccountId = $loyaltyAccountId;
    }

    /**
     * Returns Loyalty Account Id.
     * The ID of the [loyalty account](entity:LoyaltyAccount) associated with loyalty events.
     */
    public function getLoyaltyAccountId(): string
    {
        return $this->loyaltyAccountId;
    }

    /**
     * Sets Loyalty Account Id.
     * The ID of the [loyalty account](entity:LoyaltyAccount) associated with loyalty events.
     *
     * @required
     * @maps loyalty_account_id
     */
    public function setLoyaltyAccountId(string $loyaltyAccountId): void
    {
        $this->loyaltyAccountId = $loyaltyAccountId;
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
        $json['loyalty_account_id'] = $this->loyaltyAccountId;
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
