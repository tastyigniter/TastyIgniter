<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * A request to create a gift card activity.
 */
class CreateGiftCardActivityRequest implements \JsonSerializable
{
    /**
     * @var string
     */
    private $idempotencyKey;

    /**
     * @var GiftCardActivity
     */
    private $giftCardActivity;

    /**
     * @param string $idempotencyKey
     * @param GiftCardActivity $giftCardActivity
     */
    public function __construct(string $idempotencyKey, GiftCardActivity $giftCardActivity)
    {
        $this->idempotencyKey = $idempotencyKey;
        $this->giftCardActivity = $giftCardActivity;
    }

    /**
     * Returns Idempotency Key.
     * A unique string that identifies the `CreateGiftCardActivity` request.
     */
    public function getIdempotencyKey(): string
    {
        return $this->idempotencyKey;
    }

    /**
     * Sets Idempotency Key.
     * A unique string that identifies the `CreateGiftCardActivity` request.
     *
     * @required
     * @maps idempotency_key
     */
    public function setIdempotencyKey(string $idempotencyKey): void
    {
        $this->idempotencyKey = $idempotencyKey;
    }

    /**
     * Returns Gift Card Activity.
     * Represents an action performed on a [gift card]($m/GiftCard) that affects its state or balance.
     * A gift card activity contains information about a specific activity type. For example, a `REDEEM`
     * activity
     * includes a `redeem_activity_details` field that contains information about the redemption.
     */
    public function getGiftCardActivity(): GiftCardActivity
    {
        return $this->giftCardActivity;
    }

    /**
     * Sets Gift Card Activity.
     * Represents an action performed on a [gift card]($m/GiftCard) that affects its state or balance.
     * A gift card activity contains information about a specific activity type. For example, a `REDEEM`
     * activity
     * includes a `redeem_activity_details` field that contains information about the redemption.
     *
     * @required
     * @maps gift_card_activity
     */
    public function setGiftCardActivity(GiftCardActivity $giftCardActivity): void
    {
        $this->giftCardActivity = $giftCardActivity;
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
        $json['idempotency_key']    = $this->idempotencyKey;
        $json['gift_card_activity'] = $this->giftCardActivity;
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
