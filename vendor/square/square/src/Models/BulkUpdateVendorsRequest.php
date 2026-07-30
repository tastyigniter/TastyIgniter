<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents an input to a call to [BulkUpdateVendors]($e/Vendors/BulkUpdateVendors).
 */
class BulkUpdateVendorsRequest implements \JsonSerializable
{
    /**
     * @var array<string,UpdateVendorRequest>
     */
    private $vendors;

    /**
     * @param array<string,UpdateVendorRequest> $vendors
     */
    public function __construct(array $vendors)
    {
        $this->vendors = $vendors;
    }

    /**
     * Returns Vendors.
     * A set of [UpdateVendorRequest](entity:UpdateVendorRequest) objects encapsulating to-be-updated
     * [Vendor](entity:Vendor)
     * objects. The set is represented by  a collection of `Vendor`-ID/`UpdateVendorRequest`-object pairs.
     *
     * @return array<string,UpdateVendorRequest>
     */
    public function getVendors(): array
    {
        return $this->vendors;
    }

    /**
     * Sets Vendors.
     * A set of [UpdateVendorRequest](entity:UpdateVendorRequest) objects encapsulating to-be-updated
     * [Vendor](entity:Vendor)
     * objects. The set is represented by  a collection of `Vendor`-ID/`UpdateVendorRequest`-object pairs.
     *
     * @required
     * @maps vendors
     *
     * @param array<string,UpdateVendorRequest> $vendors
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
