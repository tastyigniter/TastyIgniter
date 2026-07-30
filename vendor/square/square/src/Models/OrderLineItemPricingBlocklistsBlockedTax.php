<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * A tax to block from applying to a line item. The tax must be
 * identified by either `tax_uid` or `tax_catalog_object_id`, but not both.
 */
class OrderLineItemPricingBlocklistsBlockedTax implements \JsonSerializable
{
    /**
     * @var array
     */
    private $uid = [];

    /**
     * @var array
     */
    private $taxUid = [];

    /**
     * @var array
     */
    private $taxCatalogObjectId = [];

    /**
     * Returns Uid.
     * A unique ID of the `BlockedTax` within the order.
     */
    public function getUid(): ?string
    {
        if (count($this->uid) == 0) {
            return null;
        }
        return $this->uid['value'];
    }

    /**
     * Sets Uid.
     * A unique ID of the `BlockedTax` within the order.
     *
     * @maps uid
     */
    public function setUid(?string $uid): void
    {
        $this->uid['value'] = $uid;
    }

    /**
     * Unsets Uid.
     * A unique ID of the `BlockedTax` within the order.
     */
    public function unsetUid(): void
    {
        $this->uid = [];
    }

    /**
     * Returns Tax Uid.
     * The `uid` of the tax that should be blocked. Use this field to block
     * ad hoc taxes. For catalog, taxes use the `tax_catalog_object_id` field.
     */
    public function getTaxUid(): ?string
    {
        if (count($this->taxUid) == 0) {
            return null;
        }
        return $this->taxUid['value'];
    }

    /**
     * Sets Tax Uid.
     * The `uid` of the tax that should be blocked. Use this field to block
     * ad hoc taxes. For catalog, taxes use the `tax_catalog_object_id` field.
     *
     * @maps tax_uid
     */
    public function setTaxUid(?string $taxUid): void
    {
        $this->taxUid['value'] = $taxUid;
    }

    /**
     * Unsets Tax Uid.
     * The `uid` of the tax that should be blocked. Use this field to block
     * ad hoc taxes. For catalog, taxes use the `tax_catalog_object_id` field.
     */
    public function unsetTaxUid(): void
    {
        $this->taxUid = [];
    }

    /**
     * Returns Tax Catalog Object Id.
     * The `catalog_object_id` of the tax that should be blocked.
     * Use this field to block catalog taxes. For ad hoc taxes, use the
     * `tax_uid` field.
     */
    public function getTaxCatalogObjectId(): ?string
    {
        if (count($this->taxCatalogObjectId) == 0) {
            return null;
        }
        return $this->taxCatalogObjectId['value'];
    }

    /**
     * Sets Tax Catalog Object Id.
     * The `catalog_object_id` of the tax that should be blocked.
     * Use this field to block catalog taxes. For ad hoc taxes, use the
     * `tax_uid` field.
     *
     * @maps tax_catalog_object_id
     */
    public function setTaxCatalogObjectId(?string $taxCatalogObjectId): void
    {
        $this->taxCatalogObjectId['value'] = $taxCatalogObjectId;
    }

    /**
     * Unsets Tax Catalog Object Id.
     * The `catalog_object_id` of the tax that should be blocked.
     * Use this field to block catalog taxes. For ad hoc taxes, use the
     * `tax_uid` field.
     */
    public function unsetTaxCatalogObjectId(): void
    {
        $this->taxCatalogObjectId = [];
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
        if (!empty($this->uid)) {
            $json['uid']                   = $this->uid['value'];
        }
        if (!empty($this->taxUid)) {
            $json['tax_uid']               = $this->taxUid['value'];
        }
        if (!empty($this->taxCatalogObjectId)) {
            $json['tax_catalog_object_id'] = $this->taxCatalogObjectId['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
