<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents a [CreateGiftCard]($e/GiftCards/CreateGiftCard) request.
 */
class CreateGiftCardRequest implements \JsonSerializable
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
     * @var GiftCard
     */
    private $giftCard;

    /**
     * @param string $idempotencyKey
     * @param string $locationId
     * @param GiftCard $giftCard
     */
    public function __construct(string $idempotencyKey, string $locationId, GiftCard $giftCard)
    {
        $this->idempotencyKey = $idempotencyKey;
        $this->locationId = $locationId;
        $this->giftCard = $giftCard;
    }

    /**
     * Returns Idempotency Key.
     * A unique identifier for this request, used to ensure idempotency. For more information,
     * see [Idempotency](https://developer.squareup.com/docs/build-basics/common-api-patterns/idempotency).
     */
    public function getIdempotencyKey(): string
    {
        return $this->idempotencyKey;
    }

    /**
     * Sets Idempotency Key.
     * A unique identifier for this request, used to ensure idempotency. For more information,
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
     * Returns Location Id.
     * The ID of the [location](entity:Location) where the gift card should be registered for
     * reporting purposes. Gift cards can be redeemed at any of the seller's locations.
     */
    public function getLocationId(): string
    {
        return $this->locationId;
    }

    /**
     * Sets Location Id.
     * The ID of the [location](entity:Location) where the gift card should be registered for
     * reporting purposes. Gift cards can be redeemed at any of the seller's locations.
     *
     * @required
     * @maps location_id
     */
    public function setLocationId(string $locationId): void
    {
        $this->locationId = $locationId;
    }

    /**
     * Returns Gift Card.
     * Represents a Square gift card.
     */
    public function getGiftCard(): GiftCard
    {
        return $this->giftCard;
    }

    /**
     * Sets Gift Card.
     * Represents a Square gift card.
     *
     * @required
     * @maps gift_card
     */
    public function setGiftCard(GiftCard $giftCard): void
    {
        $this->giftCard = $giftCard;
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
        $json['gift_card']       = $this->giftCard;
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
