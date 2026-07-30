<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Defines the fields that are included in requests to the
 * [CloneOrder]($e/Orders/CloneOrder) endpoint.
 */
class CloneOrderRequest implements \JsonSerializable
{
    /**
     * @var string
     */
    private $orderId;

    /**
     * @var int|null
     */
    private $version;

    /**
     * @var array
     */
    private $idempotencyKey = [];

    /**
     * @param string $orderId
     */
    public function __construct(string $orderId)
    {
        $this->orderId = $orderId;
    }

    /**
     * Returns Order Id.
     * The ID of the order to clone.
     */
    public function getOrderId(): string
    {
        return $this->orderId;
    }

    /**
     * Sets Order Id.
     * The ID of the order to clone.
     *
     * @required
     * @maps order_id
     */
    public function setOrderId(string $orderId): void
    {
        $this->orderId = $orderId;
    }

    /**
     * Returns Version.
     * An optional order version for concurrency protection.
     *
     * If a version is provided, it must match the latest stored version of the order to clone.
     * If a version is not provided, the API clones the latest version.
     */
    public function getVersion(): ?int
    {
        return $this->version;
    }

    /**
     * Sets Version.
     * An optional order version for concurrency protection.
     *
     * If a version is provided, it must match the latest stored version of the order to clone.
     * If a version is not provided, the API clones the latest version.
     *
     * @maps version
     */
    public function setVersion(?int $version): void
    {
        $this->version = $version;
    }

    /**
     * Returns Idempotency Key.
     * A value you specify that uniquely identifies this clone request.
     *
     * If you are unsure whether a particular order was cloned successfully,
     * you can reattempt the call with the same idempotency key without
     * worrying about creating duplicate cloned orders.
     * The originally cloned order is returned.
     *
     * For more information, see [Idempotency](https://developer.squareup.
     * com/docs/basics/api101/idempotency).
     */
    public function getIdempotencyKey(): ?string
    {
        if (count($this->idempotencyKey) == 0) {
            return null;
        }
        return $this->idempotencyKey['value'];
    }

    /**
     * Sets Idempotency Key.
     * A value you specify that uniquely identifies this clone request.
     *
     * If you are unsure whether a particular order was cloned successfully,
     * you can reattempt the call with the same idempotency key without
     * worrying about creating duplicate cloned orders.
     * The originally cloned order is returned.
     *
     * For more information, see [Idempotency](https://developer.squareup.
     * com/docs/basics/api101/idempotency).
     *
     * @maps idempotency_key
     */
    public function setIdempotencyKey(?string $idempotencyKey): void
    {
        $this->idempotencyKey['value'] = $idempotencyKey;
    }

    /**
     * Unsets Idempotency Key.
     * A value you specify that uniquely identifies this clone request.
     *
     * If you are unsure whether a particular order was cloned successfully,
     * you can reattempt the call with the same idempotency key without
     * worrying about creating duplicate cloned orders.
     * The originally cloned order is returned.
     *
     * For more information, see [Idempotency](https://developer.squareup.
     * com/docs/basics/api101/idempotency).
     */
    public function unsetIdempotencyKey(): void
    {
        $this->idempotencyKey = [];
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
        $json['order_id']            = $this->orderId;
        if (isset($this->version)) {
            $json['version']         = $this->version;
        }
        if (!empty($this->idempotencyKey)) {
            $json['idempotency_key'] = $this->idempotencyKey['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
