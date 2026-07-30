<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * A response that contains the linked `GiftCard` object. If the request resulted in errors,
 * the response contains a set of `Error` objects.
 */
class LinkCustomerToGiftCardResponse implements \JsonSerializable
{
    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * @var GiftCard|null
     */
    private $giftCard;

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
     * Returns Gift Card.
     * Represents a Square gift card.
     */
    public function getGiftCard(): ?GiftCard
    {
        return $this->giftCard;
    }

    /**
     * Sets Gift Card.
     * Represents a Square gift card.
     *
     * @maps gift_card
     */
    public function setGiftCard(?GiftCard $giftCard): void
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
        if (isset($this->errors)) {
            $json['errors']    = $this->errors;
        }
        if (isset($this->giftCard)) {
            $json['gift_card'] = $this->giftCard;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
