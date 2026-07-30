<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * A request to unlink a customer from a gift card.
 */
class UnlinkCustomerFromGiftCardRequest implements \JsonSerializable
{
    /**
     * @var string
     */
    private $customerId;

    /**
     * @param string $customerId
     */
    public function __construct(string $customerId)
    {
        $this->customerId = $customerId;
    }

    /**
     * Returns Customer Id.
     * The ID of the customer to unlink from the gift card.
     */
    public function getCustomerId(): string
    {
        return $this->customerId;
    }

    /**
     * Sets Customer Id.
     * The ID of the customer to unlink from the gift card.
     *
     * @required
     * @maps customer_id
     */
    public function setCustomerId(string $customerId): void
    {
        $this->customerId = $customerId;
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
        $json['customer_id'] = $this->customerId;
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
