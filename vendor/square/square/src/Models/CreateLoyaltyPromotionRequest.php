<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents a [CreateLoyaltyPromotion]($e/Loyalty/CreateLoyaltyPromotion) request.
 */
class CreateLoyaltyPromotionRequest implements \JsonSerializable
{
    /**
     * @var LoyaltyPromotion
     */
    private $loyaltyPromotion;

    /**
     * @var string
     */
    private $idempotencyKey;

    /**
     * @param LoyaltyPromotion $loyaltyPromotion
     * @param string $idempotencyKey
     */
    public function __construct(LoyaltyPromotion $loyaltyPromotion, string $idempotencyKey)
    {
        $this->loyaltyPromotion = $loyaltyPromotion;
        $this->idempotencyKey = $idempotencyKey;
    }

    /**
     * Returns Loyalty Promotion.
     * Represents a promotion for a [loyalty program]($m/LoyaltyProgram). Loyalty promotions enable buyers
     * to earn extra points on top of those earned from the base program.
     *
     * A loyalty program can have a maximum of 10 loyalty promotions with an `ACTIVE` or `SCHEDULED` status.
     */
    public function getLoyaltyPromotion(): LoyaltyPromotion
    {
        return $this->loyaltyPromotion;
    }

    /**
     * Sets Loyalty Promotion.
     * Represents a promotion for a [loyalty program]($m/LoyaltyProgram). Loyalty promotions enable buyers
     * to earn extra points on top of those earned from the base program.
     *
     * A loyalty program can have a maximum of 10 loyalty promotions with an `ACTIVE` or `SCHEDULED` status.
     *
     * @required
     * @maps loyalty_promotion
     */
    public function setLoyaltyPromotion(LoyaltyPromotion $loyaltyPromotion): void
    {
        $this->loyaltyPromotion = $loyaltyPromotion;
    }

    /**
     * Returns Idempotency Key.
     * A unique identifier for this request, which is used to ensure idempotency. For more information,
     * see [Idempotency](https://developer.squareup.com/docs/build-basics/common-api-patterns/idempotency).
     */
    public function getIdempotencyKey(): string
    {
        return $this->idempotencyKey;
    }

    /**
     * Sets Idempotency Key.
     * A unique identifier for this request, which is used to ensure idempotency. For more information,
     * see [Idempotency](https://developer.squareup.com/docs/build-basics/common-api-patterns/idempotency).
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
        $json['loyalty_promotion'] = $this->loyaltyPromotion;
        $json['idempotency_key']   = $this->idempotencyKey;
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
