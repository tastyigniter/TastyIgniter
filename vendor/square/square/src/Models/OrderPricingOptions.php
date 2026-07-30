<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Pricing options for an order. The options affect how the order's price is calculated.
 * They can be used, for example, to apply automatic price adjustments that are based on preconfigured
 * [pricing rules]($m/CatalogPricingRule).
 */
class OrderPricingOptions implements \JsonSerializable
{
    /**
     * @var array
     */
    private $autoApplyDiscounts = [];

    /**
     * @var array
     */
    private $autoApplyTaxes = [];

    /**
     * Returns Auto Apply Discounts.
     * The option to determine whether pricing rule-based
     * discounts are automatically applied to an order.
     */
    public function getAutoApplyDiscounts(): ?bool
    {
        if (count($this->autoApplyDiscounts) == 0) {
            return null;
        }
        return $this->autoApplyDiscounts['value'];
    }

    /**
     * Sets Auto Apply Discounts.
     * The option to determine whether pricing rule-based
     * discounts are automatically applied to an order.
     *
     * @maps auto_apply_discounts
     */
    public function setAutoApplyDiscounts(?bool $autoApplyDiscounts): void
    {
        $this->autoApplyDiscounts['value'] = $autoApplyDiscounts;
    }

    /**
     * Unsets Auto Apply Discounts.
     * The option to determine whether pricing rule-based
     * discounts are automatically applied to an order.
     */
    public function unsetAutoApplyDiscounts(): void
    {
        $this->autoApplyDiscounts = [];
    }

    /**
     * Returns Auto Apply Taxes.
     * The option to determine whether rule-based taxes are automatically
     * applied to an order when the criteria of the corresponding rules are met.
     */
    public function getAutoApplyTaxes(): ?bool
    {
        if (count($this->autoApplyTaxes) == 0) {
            return null;
        }
        return $this->autoApplyTaxes['value'];
    }

    /**
     * Sets Auto Apply Taxes.
     * The option to determine whether rule-based taxes are automatically
     * applied to an order when the criteria of the corresponding rules are met.
     *
     * @maps auto_apply_taxes
     */
    public function setAutoApplyTaxes(?bool $autoApplyTaxes): void
    {
        $this->autoApplyTaxes['value'] = $autoApplyTaxes;
    }

    /**
     * Unsets Auto Apply Taxes.
     * The option to determine whether rule-based taxes are automatically
     * applied to an order when the criteria of the corresponding rules are met.
     */
    public function unsetAutoApplyTaxes(): void
    {
        $this->autoApplyTaxes = [];
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
        if (!empty($this->autoApplyDiscounts)) {
            $json['auto_apply_discounts'] = $this->autoApplyDiscounts['value'];
        }
        if (!empty($this->autoApplyTaxes)) {
            $json['auto_apply_taxes']     = $this->autoApplyTaxes['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
