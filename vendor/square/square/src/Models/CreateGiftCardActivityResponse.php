<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * A response that contains a `GiftCardActivity` that was created.
 * The response might contain a set of `Error` objects if the request resulted in errors.
 */
class CreateGiftCardActivityResponse implements \JsonSerializable
{
    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * @var GiftCardActivity|null
     */
    private $giftCardActivity;

    /**
     * Returns Errors.
     * Any errors that occurred during the request.
     *
     * @return Error[]|null
     */
    public function getErrors(): ?array
    {
        return $this->errors;
    }

    /**
     * Sets Errors.
     * Any errors that occurred during the request.
     *
     * @maps errors
     *
     * @param Error[]|null $errors
     */
    public function setErrors(?array $errors): void
    {
        $this->errors = $errors;
    }

    /**
     * Returns Gift Card Activity.
     * Represents an action performed on a [gift card]($m/GiftCard) that affects its state or balance.
     * A gift card activity contains information about a specific activity type. For example, a `REDEEM`
     * activity
     * includes a `redeem_activity_details` field that contains information about the redemption.
     */
    public function getGiftCardActivity(): ?GiftCardActivity
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
     * @maps gift_card_activity
     */
    public function setGiftCardActivity(?GiftCardActivity $giftCardActivity): void
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
        if (isset($this->errors)) {
            $json['errors']             = $this->errors;
        }
        if (isset($this->giftCardActivity)) {
            $json['gift_card_activity'] = $this->giftCardActivity;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
