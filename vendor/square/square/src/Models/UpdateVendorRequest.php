<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents an input to a call to [UpdateVendor]($e/Vendors/UpdateVendor).
 */
class UpdateVendorRequest implements \JsonSerializable
{
    /**
     * @var array
     */
    private $idempotencyKey = [];

    /**
     * @var Vendor
     */
    private $vendor;

    /**
     * @param Vendor $vendor
     */
    public function __construct(Vendor $vendor)
    {
        $this->vendor = $vendor;
    }

    /**
     * Returns Idempotency Key.
     * A client-supplied, universally unique identifier (UUID) for the
     * request.
     *
     * See [Idempotency](https://developer.squareup.com/docs/build-basics/common-api-patterns/idempotency)
     * in the
     * [API Development 101](https://developer.squareup.com/docs/buildbasics) section for more
     * information.
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
     * A client-supplied, universally unique identifier (UUID) for the
     * request.
     *
     * See [Idempotency](https://developer.squareup.com/docs/build-basics/common-api-patterns/idempotency)
     * in the
     * [API Development 101](https://developer.squareup.com/docs/buildbasics) section for more
     * information.
     *
     * @maps idempotency_key
     */
    public function setIdempotencyKey(?string $idempotencyKey): void
    {
        $this->idempotencyKey['value'] = $idempotencyKey;
    }

    /**
     * Unsets Idempotency Key.
     * A client-supplied, universally unique identifier (UUID) for the
     * request.
     *
     * See [Idempotency](https://developer.squareup.com/docs/build-basics/common-api-patterns/idempotency)
     * in the
     * [API Development 101](https://developer.squareup.com/docs/buildbasics) section for more
     * information.
     */
    public function unsetIdempotencyKey(): void
    {
        $this->idempotencyKey = [];
    }

    /**
     * Returns Vendor.
     * Represents a supplier to a seller.
     */
    public function getVendor(): Vendor
    {
        return $this->vendor;
    }

    /**
     * Sets Vendor.
     * Represents a supplier to a seller.
     *
     * @required
     * @maps vendor
     */
    public function setVendor(Vendor $vendor): void
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
        if (!empty($this->idempotencyKey)) {
            $json['idempotency_key'] = $this->idempotencyKey['value'];
        }
        $json['vendor']              = $this->vendor;
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
