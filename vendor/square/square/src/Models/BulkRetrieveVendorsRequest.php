<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents an input to a call to [BulkRetrieveVendors]($e/Vendors/BulkRetrieveVendors).
 */
class BulkRetrieveVendorsRequest implements \JsonSerializable
{
    /**
     * @var array
     */
    private $vendorIds = [];

    /**
     * Returns Vendor Ids.
     * IDs of the [Vendor](entity:Vendor) objects to retrieve.
     *
     * @return string[]|null
     */
    public function getVendorIds(): ?array
    {
        if (count($this->vendorIds) == 0) {
            return null;
        }
        return $this->vendorIds['value'];
    }

    /**
     * Sets Vendor Ids.
     * IDs of the [Vendor](entity:Vendor) objects to retrieve.
     *
     * @maps vendor_ids
     *
     * @param string[]|null $vendorIds
     */
    public function setVendorIds(?array $vendorIds): void
    {
        $this->vendorIds['value'] = $vendorIds;
    }

    /**
     * Unsets Vendor Ids.
     * IDs of the [Vendor](entity:Vendor) objects to retrieve.
     */
    public function unsetVendorIds(): void
    {
        $this->vendorIds = [];
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
        if (!empty($this->vendorIds)) {
            $json['vendor_ids'] = $this->vendorIds['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
