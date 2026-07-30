<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * A request to create a new loyalty account.
 */
class CreateLoyaltyAccountRequest implements \JsonSerializable
{
    /**
     * @var LoyaltyAccount
     */
    private $loyaltyAccount;

    /**
     * @var string
     */
    private $idempotencyKey;

    /**
     * @param LoyaltyAccount $loyaltyAccount
     * @param string $idempotencyKey
     */
    public function __construct(LoyaltyAccount $loyaltyAccount, string $idempotencyKey)
    {
        $this->loyaltyAccount = $loyaltyAccount;
        $this->idempotencyKey = $idempotencyKey;
    }

    /**
     * Returns Loyalty Account.
     * Describes a loyalty account in a [loyalty program]($m/LoyaltyProgram). For more information, see
     * [Create and Retrieve Loyalty Accounts](https://developer.squareup.com/docs/loyalty-api/loyalty-
     * accounts).
     */
    public function getLoyaltyAccount(): LoyaltyAccount
    {
        return $this->loyaltyAccount;
    }

    /**
     * Sets Loyalty Account.
     * Describes a loyalty account in a [loyalty program]($m/LoyaltyProgram). For more information, see
     * [Create and Retrieve Loyalty Accounts](https://developer.squareup.com/docs/loyalty-api/loyalty-
     * accounts).
     *
     * @required
     * @maps loyalty_account
     */
    public function setLoyaltyAccount(LoyaltyAccount $loyaltyAccount): void
    {
        $this->loyaltyAccount = $loyaltyAccount;
    }

    /**
     * Returns Idempotency Key.
     * A unique string that identifies this `CreateLoyaltyAccount` request.
     * Keys can be any valid string, but must be unique for every request.
     */
    public function getIdempotencyKey(): string
    {
        return $this->idempotencyKey;
    }

    /**
     * Sets Idempotency Key.
     * A unique string that identifies this `CreateLoyaltyAccount` request.
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
        $json['loyalty_account'] = $this->loyaltyAccount;
        $json['idempotency_key'] = $this->idempotencyKey;
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
