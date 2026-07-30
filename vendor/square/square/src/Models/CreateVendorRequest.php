<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents an input to a call to [CreateVendor]($e/Vendors/CreateVendor).
 */
class CreateVendorRequest implements \JsonSerializable
{
    /**
     * @var string
     */
    private $idempotencyKey;

    /**
     * @var Vendor|null
     */
    private $vendor;

    /**
     * @param string $idempotencyKey
     */
    public function __construct(string $idempotencyKey)
    {
        $this->idempotencyKey = $idempotencyKey;
    }

    /**
     * Returns Idempotency Key.
     * A client-supplied, universally unique identifier (UUID) to make this [CreateVendor](api-endpoint:
     * Vendors-CreateVendor) call idempotent.
     *
     * See [Idempotency](https://developer.squareup.com/docs/build-basics/common-api-patterns/idempotency)
     * in the
     * [API Development 101](https://developer.squareup.com/docs/buildbasics) section for more
     * information.
     */
    public function getIdempotencyKey(): string
    {
        return $this->idempotencyKey;
    }

    /**
     * Sets Idempotency Key.
     * A client-supplied, universally unique identifier (UUID) to make this [CreateVendor](api-endpoint:
     * Vendors-CreateVendor) call idempotent.
     *
     * See [Idempotency](https://developer.squareup.com/docs/build-basics/common-api-patterns/idempotency)
     * in the
     * [API Development 101](https://developer.squareup.com/docs/buildbasics) section for more
     * information.
     *
     * @required
     * @maps idempotency_key
     */
    public function setIdempotencyKey(string $idempotencyKey): void
    {
        $this->idempotencyKey = $idempotencyKey;
    }

    /**
     * Returns Vendor.
     * Represents a supplier to a seller.
     */
    public function getVendor(): ?Vendor
    {
        return $this->vendor;
    }

    /**
     * Sets Vendor.
     * Represents a supplier to a seller.
     *
     * @maps vendor
     */
    public function setVendor(?Vendor $vendor): void
    {
        $this->vendor = $vendor;
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
        if (isset($this->vendor)) {
            $json['vendor']      = $this->vendor;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
