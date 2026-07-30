<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents a transaction processed with Square, either with the
 * Connect API or with Square Point of Sale.
 *
 * The `tenders` field of this object lists all methods of payment used to pay in
 * the transaction.
 */
class Transaction implements \JsonSerializable
{
    /**
     * @var string|null
     */
    private $id;

    /**
     * @var array
     */
    private $locationId = [];

    /**
     * @var string|null
     */
    private $createdAt;

    /**
     * @var array
     */
    private $tenders = [];

    /**
     * @var array
     */
    private $refunds = [];

    /**
     * @var array
     */
    private $referenceId = [];

    /**
     * @var string|null
     */
    private $product;

    /**
     * @var array
     */
    private $clientId = [];

    /**
     * @var Address|null
     */
    private $shippingAddress;

    /**
     * @var array
     */
    private $orderId = [];

    /**
     * Returns Id.
     * The transaction's unique ID, issued by Square payments servers.
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Sets Id.
     * The transaction's unique ID, issued by Square payments servers.
     *
     * @maps id
     */
    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    /**
     * Returns Location Id.
     * The ID of the transaction's associated location.
     */
    public function getLocationId(): ?string
    {
        if (count($this->locationId) == 0) {
            return null;
        }
        return $this->locationId['value'];
    }

    /**
     * Sets Location Id.
     * The ID of the transaction's associated location.
     *
     * @maps location_id
     */
    public function setLocationId(?string $locationId): void
    {
        $this->locationId['value'] = $locationId;
    }

    /**
     * Unsets Location Id.
     * The ID of the transaction's associated location.
     */
    public function unsetLocationId(): void
    {
        $this->locationId = [];
    }

    /**
     * Returns Created At.
     * The timestamp for when the transaction was created, in RFC 3339 format.
     */
    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    /**
     * Sets Created At.
     * The timestamp for when the transaction was created, in RFC 3339 format.
     *
     * @maps created_at
     */
    public function setCreatedAt(?string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Returns Tenders.
     * The tenders used to pay in the transaction.
     *
     * @return Tender[]|null
     */
    public function getTenders(): ?array
    {
        if (count($this->tenders) == 0) {
            return null;
        }
        return $this->tenders['value'];
    }

    /**
     * Sets Tenders.
     * The tenders used to pay in the transaction.
     *
     * @maps tenders
     *
     * @param Tender[]|null $tenders
     */
    public function setTenders(?array $tenders): void
    {
        $this->tenders['value'] = $tenders;
    }

    /**
     * Unsets Tenders.
     * The tenders used to pay in the transaction.
     */
    public function unsetTenders(): void
    {
        $this->tenders = [];
    }

    /**
     * Returns Refunds.
     * Refunds that have been applied to any tender in the transaction.
     *
     * @return Refund[]|null
     */
    public function getRefunds(): ?array
    {
        if (count($this->refunds) == 0) {
            return null;
        }
        return $this->refunds['value'];
    }

    /**
     * Sets Refunds.
     * Refunds that have been applied to any tender in the transaction.
     *
     * @maps refunds
     *
     * @param Refund[]|null $refunds
     */
    public function setRefunds(?array $refunds): void
    {
        $this->refunds['value'] = $refunds;
    }

    /**
     * Unsets Refunds.
     * Refunds that have been applied to any tender in the transaction.
     */
    public function unsetRefunds(): void
    {
        $this->refunds = [];
    }

    /**
     * Returns Reference Id.
     * If the transaction was created with the [Charge](api-endpoint:Transactions-Charge)
     * endpoint, this value is the same as the value provided for the `reference_id`
     * parameter in the request to that endpoint. Otherwise, it is not set.
     */
    public function getReferenceId(): ?string
    {
        if (count($this->referenceId) == 0) {
            return null;
        }
        return $this->referenceId['value'];
    }

    /**
     * Sets Reference Id.
     * If the transaction was created with the [Charge](api-endpoint:Transactions-Charge)
     * endpoint, this value is the same as the value provided for the `reference_id`
     * parameter in the request to that endpoint. Otherwise, it is not set.
     *
     * @maps reference_id
     */
    public function setReferenceId(?string $referenceId): void
    {
        $this->referenceId['value'] = $referenceId;
    }

    /**
     * Unsets Reference Id.
     * If the transaction was created with the [Charge](api-endpoint:Transactions-Charge)
     * endpoint, this value is the same as the value provided for the `reference_id`
     * parameter in the request to that endpoint. Otherwise, it is not set.
     */
    public function unsetReferenceId(): void
    {
        $this->referenceId = [];
    }

    /**
     * Returns Product.
     * Indicates the Square product used to process a transaction.
     */
    public function getProduct(): ?string
    {
        return $this->product;
    }

    /**
     * Sets Product.
     * Indicates the Square product used to process a transaction.
     *
     * @maps product
     */
    public function setProduct(?string $product): void
    {
        $this->product = $product;
    }

    /**
     * Returns Client Id.
     * If the transaction was created in the Square Point of Sale app, this value
     * is the ID generated for the transaction by Square Point of Sale.
     *
     * This ID has no relationship to the transaction's canonical `id`, which is
     * generated by Square's backend servers. This value is generated for bookkeeping
     * purposes, in case the transaction cannot immediately be completed (for example,
     * if the transaction is processed in offline mode).
     *
     * It is not currently possible with the Connect API to perform a transaction
     * lookup by this value.
     */
    public function getClientId(): ?string
    {
        if (count($this->clientId) == 0) {
            return null;
        }
        return $this->clientId['value'];
    }

    /**
     * Sets Client Id.
     * If the transaction was created in the Square Point of Sale app, this value
     * is the ID generated for the transaction by Square Point of Sale.
     *
     * This ID has no relationship to the transaction's canonical `id`, which is
     * generated by Square's backend servers. This value is generated for bookkeeping
     * purposes, in case the transaction cannot immediately be completed (for example,
     * if the transaction is processed in offline mode).
     *
     * It is not currently possible with the Connect API to perform a transaction
     * lookup by this value.
     *
     * @maps client_id
     */
    public function setClientId(?string $clientId): void
    {
        $this->clientId['value'] = $clientId;
    }

    /**
     * Unsets Client Id.
     * If the transaction was created in the Square Point of Sale app, this value
     * is the ID generated for the transaction by Square Point of Sale.
     *
     * This ID has no relationship to the transaction's canonical `id`, which is
     * generated by Square's backend servers. This value is generated for bookkeeping
     * purposes, in case the transaction cannot immediately be completed (for example,
     * if the transaction is processed in offline mode).
     *
     * It is not currently possible with the Connect API to perform a transaction
     * lookup by this value.
     */
    public function unsetClientId(): void
    {
        $this->clientId = [];
    }

    /**
     * Returns Shipping Address.
     * Represents a postal address in a country.
     * For more information, see [Working with Addresses](https://developer.squareup.com/docs/build-
     * basics/working-with-addresses).
     */
    public function getShippingAddress(): ?Address
    {
        return $this->shippingAddress;
    }

    /**
     * Sets Shipping Address.
     * Represents a postal address in a country.
     * For more information, see [Working with Addresses](https://developer.squareup.com/docs/build-
     * basics/working-with-addresses).
     *
     * @maps shipping_address
     */
    public function setShippingAddress(?Address $shippingAddress): void
    {
        $this->shippingAddress = $shippingAddress;
    }

    /**
     * Returns Order Id.
     * The order_id is an identifier for the order associated with this transaction, if any.
     */
    public function getOrderId(): ?string
    {
        if (count($this->orderId) == 0) {
            return null;
        }
        return $this->orderId['value'];
    }

    /**
     * Sets Order Id.
     * The order_id is an identifier for the order associated with this transaction, if any.
     *
     * @maps order_id
     */
    public function setOrderId(?string $orderId): void
    {
        $this->orderId['value'] = $orderId;
    }

    /**
     * Unsets Order Id.
     * The order_id is an identifier for the order associated with this transaction, if any.
     */
    public function unsetOrderId(): void
    {
        $this->orderId = [];
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
        if (isset($this->id)) {
            $json['id']               = $this->id;
        }
        if (!empty($this->locationId)) {
            $json['location_id']      = $this->locationId['value'];
        }
        if (isset($this->createdAt)) {
            $json['created_at']       = $this->createdAt;
        }
        if (!empty($this->tenders)) {
            $json['tenders']          = $this->tenders['value'];
        }
        if (!empty($this->refunds)) {
            $json['refunds']          = $this->refunds['value'];
        }
        if (!empty($this->referenceId)) {
            $json['reference_id']     = $this->referenceId['value'];
        }
        if (isset($this->product)) {
            $json['product']          = $this->product;
        }
        if (!empty($this->clientId)) {
            $json['client_id']        = $this->clientId['value'];
        }
        if (isset($this->shippingAddress)) {
            $json['shipping_address'] = $this->shippingAddress;
        }
        if (!empty($this->orderId)) {
            $json['order_id']         = $this->orderId['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
