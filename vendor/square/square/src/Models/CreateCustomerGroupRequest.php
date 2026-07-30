<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Defines the body parameters that can be included in a request to the
 * [CreateCustomerGroup]($e/CustomerGroups/CreateCustomerGroup) endpoint.
 */
class CreateCustomerGroupRequest implements \JsonSerializable
{
    /**
     * @var string|null
     */
    private $idempotencyKey;

    /**
     * @var CustomerGroup
     */
    private $group;

    /**
     * @param CustomerGroup $group
     */
    public function __construct(CustomerGroup $group)
    {
        $this->group = $group;
    }

    /**
     * Returns Idempotency Key.
     * The idempotency key for the request. For more information, see [Idempotency](https://developer.
     * squareup.com/docs/build-basics/common-api-patterns/idempotency).
     */
    public function getIdempotencyKey(): ?string
    {
        return $this->idempotencyKey;
    }

    /**
     * Sets Idempotency Key.
     * The idempotency key for the request. For more information, see [Idempotency](https://developer.
     * squareup.com/docs/build-basics/common-api-patterns/idempotency).
     *
     * @maps idempotency_key
     */
    public function setIdempotencyKey(?string $idempotencyKey): void
    {
        $this->idempotencyKey = $idempotencyKey;
    }

    /**
     * Returns Group.
     * Represents a group of customer profiles.
     *
     * Customer groups can be created, be modified, and have their membership defined using
     * the Customers API or within the Customer Directory in the Square Seller Dashboard or Point of Sale.
     */
    public function getGroup(): CustomerGroup
    {
        return $this->group;
    }

    /**
     * Sets Group.
     * Represents a group of customer profiles.
     *
     * Customer groups can be created, be modified, and have their membership defined using
     * the Customers API or within the Customer Directory in the Square Seller Dashboard or Point of Sale.
     *
     * @required
     * @maps group
     */
    public function setGroup(CustomerGroup $group): void
    {
        $this->group = $group;
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
        if (isset($this->idempotencyKey)) {
            $json['idempotency_key'] = $this->idempotencyKey;
        }
        $json['group']               = $this->group;
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
