<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * A discount to block from applying to a line item. The discount must be
 * identified by either `discount_uid` or `discount_catalog_object_id`, but not both.
 */
class OrderLineItemPricingBlocklistsBlockedDiscount implements \JsonSerializable
{
    /**
     * @var array
     */
    private $uid = [];

    /**
     * @var array
     */
    private $discountUid = [];

    /**
     * @var array
     */
    private $discountCatalogObjectId = [];

    /**
     * Returns Uid.
     * A unique ID of the `BlockedDiscount` within the order.
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
     * A unique ID of the `BlockedDiscount` within the order.
     *
     * @maps uid
     */
    public function setUid(?string $uid): void
    {
        $this->uid['value'] = $uid;
    }

    /**
     * Unsets Uid.
     * A unique ID of the `BlockedDiscount` within the order.
     */
    public function unsetUid(): void
    {
        $this->uid = [];
    }

    /**
     * Returns Discount Uid.
     * The `uid` of the discount that should be blocked. Use this field to block
     * ad hoc discounts. For catalog discounts, use the `discount_catalog_object_id` field.
     */
    public function getDiscountUid(): ?string
    {
        if (count($this->discountUid) == 0) {
            return null;
        }
        return $this->discountUid['value'];
    }

    /**
     * Sets Discount Uid.
     * The `uid` of the discount that should be blocked. Use this field to block
     * ad hoc discounts. For catalog discounts, use the `discount_catalog_object_id` field.
     *
     * @maps discount_uid
     */
    public function setDiscountUid(?string $discountUid): void
    {
        $this->discountUid['value'] = $discountUid;
    }

    /**
     * Unsets Discount Uid.
     * The `uid` of the discount that should be blocked. Use this field to block
     * ad hoc discounts. For catalog discounts, use the `discount_catalog_object_id` field.
     */
    public function unsetDiscountUid(): void
    {
        $this->discountUid = [];
    }

    /**
     * Returns Discount Catalog Object Id.
     * The `catalog_object_id` of the discount that should be blocked.
     * Use this field to block catalog discounts. For ad hoc discounts, use the
     * `discount_uid` field.
     */
    public function getDiscountCatalogObjectId(): ?string
    {
        if (count($this->discountCatalogObjectId) == 0) {
            return null;
        }
        return $this->discountCatalogObjectId['value'];
    }

    /**
     * Sets Discount Catalog Object Id.
     * The `catalog_object_id` of the discount that should be blocked.
     * Use this field to block catalog discounts. For ad hoc discounts, use the
     * `discount_uid` field.
     *
     * @maps discount_catalog_object_id
     */
    public function setDiscountCatalogObjectId(?string $discountCatalogObjectId): void
    {
        $this->discountCatalogObjectId['value'] = $discountCatalogObjectId;
    }

    /**
     * Unsets Discount Catalog Object Id.
     * The `catalog_object_id` of the discount that should be blocked.
     * Use this field to block catalog discounts. For ad hoc discounts, use the
     * `discount_uid` field.
     */
    public function unsetDiscountCatalogObjectId(): void
    {
        $this->discountCatalogObjectId = [];
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
            $json['uid']                        = $this->uid['value'];
        }
        if (!empty($this->discountUid)) {
            $json['discount_uid']               = $this->discountUid['value'];
        }
        if (!empty($this->discountCatalogObjectId)) {
            $json['discount_catalog_object_id'] = $this->discountCatalogObjectId['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
