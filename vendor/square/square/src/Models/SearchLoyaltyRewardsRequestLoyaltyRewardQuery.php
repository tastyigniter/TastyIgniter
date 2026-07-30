<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * The set of search requirements.
 */
class SearchLoyaltyRewardsRequestLoyaltyRewardQuery implements \JsonSerializable
{
    /**
     * @var string
     */
    private $loyaltyAccountId;

    /**
     * @var string|null
     */
    private $status;

    /**
     * @param string $loyaltyAccountId
     */
    public function __construct(string $loyaltyAccountId)
    {
        $this->loyaltyAccountId = $loyaltyAccountId;
    }

    /**
     * Returns Loyalty Account Id.
     * The ID of the [loyalty account](entity:LoyaltyAccount) to which the loyalty reward belongs.
     */
    public function getLoyaltyAccountId(): string
    {
        return $this->loyaltyAccountId;
    }

    /**
     * Sets Loyalty Account Id.
     * The ID of the [loyalty account](entity:LoyaltyAccount) to which the loyalty reward belongs.
     *
     * @required
     * @maps loyalty_account_id
     */
    public function setLoyaltyAccountId(string $loyaltyAccountId): void
    {
        $this->loyaltyAccountId = $loyaltyAccountId;
    }

    /**
     * Returns Status.
     * The status of the loyalty reward.
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * Sets Status.
     * The status of the loyalty reward.
     *
     * @maps status
     */
    public function setStatus(?string $status): void
    {
        $this->status = $status;
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
        if (isset($this->status)) {
            $json['status']         = $this->status;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
