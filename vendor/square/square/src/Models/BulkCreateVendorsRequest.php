<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents an input to a call to [BulkCreateVendors]($e/Vendors/BulkCreateVendors).
 */
class BulkCreateVendorsRequest implements \JsonSerializable
{
    /**
     * @var array<string,Vendor>
     */
    private $vendors;

    /**
     * @param array<string,Vendor> $vendors
     */
    public function __construct(array $vendors)
    {
        $this->vendors = $vendors;
    }

    /**
     * Returns Vendors.
     * Specifies a set of new [Vendor](entity:Vendor) objects as represented by a collection of idempotency-
     * key/`Vendor`-object pairs.
     *
     * @return array<string,Vendor>
     */
    public function getVendors(): array
    {
        return $this->vendors;
    }

    /**
     * Sets Vendors.
     * Specifies a set of new [Vendor](entity:Vendor) objects as represented by a collection of idempotency-
     * key/`Vendor`-object pairs.
     *
     * @required
     * @maps vendors
     *
     * @param array<string,Vendor> $vendors
     */
    public function setVendors(array $vendors): void
    {
        $this->vendors = $vendors;
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
        $json['vendors'] = $this->vendors;
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
