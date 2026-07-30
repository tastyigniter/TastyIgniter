<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Describes pricing adjustments that are blocked from automatic
 * application to a line item. For more information, see
 * [Apply Taxes and Discounts](https://developer.squareup.com/docs/orders-api/apply-taxes-and-
 * discounts).
 */
class OrderLineItemPricingBlocklists implements \JsonSerializable
{
    /**
     * @var array
     */
    private $blockedDiscounts = [];

    /**
     * @var array
     */
    private $blockedTaxes = [];

    /**
     * Returns Blocked Discounts.
     * A list of discounts blocked from applying to the line item.
     * Discounts can be blocked by the `discount_uid` (for ad hoc discounts) or
     * the `discount_catalog_object_id` (for catalog discounts).
     *
     * @return OrderLineItemPricingBlocklistsBlockedDiscount[]|null
     */
    public function getBlockedDiscounts(): ?array
    {
        if (count($this->blockedDiscounts) == 0) {
            return null;
        }
        return $this->blockedDiscounts['value'];
    }

    /**
     * Sets Blocked Discounts.
     * A list of discounts blocked from applying to the line item.
     * Discounts can be blocked by the `discount_uid` (for ad hoc discounts) or
     * the `discount_catalog_object_id` (for catalog discounts).
     *
     * @maps blocked_discounts
     *
     * @param OrderLineItemPricingBlocklistsBlockedDiscount[]|null $blockedDiscounts
     */
    public function setBlockedDiscounts(?array $blockedDiscounts): void
    {
        $this->blockedDiscounts['value'] = $blockedDiscounts;
    }

    /**
     * Unsets Blocked Discounts.
     * A list of discounts blocked from applying to the line item.
     * Discounts can be blocked by the `discount_uid` (for ad hoc discounts) or
     * the `discount_catalog_object_id` (for catalog discounts).
     */
    public function unsetBlockedDiscounts(): void
    {
        $this->blockedDiscounts = [];
    }

    /**
     * Returns Blocked Taxes.
     * A list of taxes blocked from applying to the line item.
     * Taxes can be blocked by the `tax_uid` (for ad hoc taxes) or
     * the `tax_catalog_object_id` (for catalog taxes).
     *
     * @return OrderLineItemPricingBlocklistsBlockedTax[]|null
     */
    public function getBlockedTaxes(): ?array
    {
        if (count($this->blockedTaxes) == 0) {
            return null;
        }
        return $this->blockedTaxes['value'];
    }

    /**
     * Sets Blocked Taxes.
     * A list of taxes blocked from applying to the line item.
     * Taxes can be blocked by the `tax_uid` (for ad hoc taxes) or
     * the `tax_catalog_object_id` (for catalog taxes).
     *
     * @maps blocked_taxes
     *
     * @param OrderLineItemPricingBlocklistsBlockedTax[]|null $blockedTaxes
     */
    public function setBlockedTaxes(?array $blockedTaxes): void
    {
        $this->blockedTaxes['value'] = $blockedTaxes;
    }

    /**
     * Unsets Blocked Taxes.
     * A list of taxes blocked from applying to the line item.
     * Taxes can be blocked by the `tax_uid` (for ad hoc taxes) or
     * the `tax_catalog_object_id` (for catalog taxes).
     */
    public function unsetBlockedTaxes(): void
    {
        $this->blockedTaxes = [];
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
        if (!empty($this->blockedDiscounts)) {
            $json['blocked_discounts'] = $this->blockedDiscounts['value'];
        }
        if (!empty($this->blockedTaxes)) {
            $json['blocked_taxes']     = $this->blockedTaxes['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
