<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Payment include an` itemizations` field that lists the items purchased,
 * along with associated fees, modifiers, and discounts. Each itemization has an
 * `itemization_type` field that indicates which of the following the itemization
 * represents:
 *
 * <ul>
 * <li>An item variation from the merchant's item library</li>
 * <li>A custom monetary amount</li>
 * <li>
 * An action performed on a Square gift card, such as activating or
 * reloading it.
 * </li>
 * </ul>
 *
 * *Note**: itemization information included in a `Payment` object reflects
 * details collected **at the time of the payment**. Details such as the name or
 * price of items might have changed since the payment was processed.
 */
class V1PaymentItemization implements \JsonSerializable
{
    /**
     * @var array
     */
    private $name = [];

    /**
     * @var array
     */
    private $quantity = [];

    /**
     * @var string|null
     */
    private $itemizationType;

    /**
     * @var V1PaymentItemDetail|null
     */
    private $itemDetail;

    /**
     * @var array
     */
    private $notes = [];

    /**
     * @var array
     */
    private $itemVariationName = [];

    /**
     * @var V1Money|null
     */
    private $totalMoney;

    /**
     * @var V1Money|null
     */
    private $singleQuantityMoney;

    /**
     * @var V1Money|null
     */
    private $grossSalesMoney;

    /**
     * @var V1Money|null
     */
    private $discountMoney;

    /**
     * @var V1Money|null
     */
    private $netSalesMoney;

    /**
     * @var array
     */
    private $taxes = [];

    /**
     * @var array
     */
    private $discounts = [];

    /**
     * @var array
     */
    private $modifiers = [];

    /**
     * Returns Name.
     * The item's name.
     */
    public function getName(): ?string
    {
        if (count($this->name) == 0) {
            return null;
        }
        return $this->name['value'];
    }

    /**
     * Sets Name.
     * The item's name.
     *
     * @maps name
     */
    public function setName(?string $name): void
    {
        $this->name['value'] = $name;
    }

    /**
     * Unsets Name.
     * The item's name.
     */
    public function unsetName(): void
    {
        $this->name = [];
    }

    /**
     * Returns Quantity.
     * The quantity of the item purchased. This can be a decimal value.
     */
    public function getQuantity(): ?float
    {
        if (count($this->quantity) == 0) {
            return null;
        }
        return $this->quantity['value'];
    }

    /**
     * Sets Quantity.
     * The quantity of the item purchased. This can be a decimal value.
     *
     * @maps quantity
     */
    public function setQuantity(?float $quantity): void
    {
        $this->quantity['value'] = $quantity;
    }

    /**
     * Unsets Quantity.
     * The quantity of the item purchased. This can be a decimal value.
     */
    public function unsetQuantity(): void
    {
        $this->quantity = [];
    }

    /**
     * Returns Itemization Type.
     */
    public function getItemizationType(): ?string
    {
        return $this->itemizationType;
    }

    /**
     * Sets Itemization Type.
     *
     * @maps itemization_type
     */
    public function setItemizationType(?string $itemizationType): void
    {
        $this->itemizationType = $itemizationType;
    }

    /**
     * Returns Item Detail.
     * V1PaymentItemDetail
     */
    public function getItemDetail(): ?V1PaymentItemDetail
    {
        return $this->itemDetail;
    }

    /**
     * Sets Item Detail.
     * V1PaymentItemDetail
     *
     * @maps item_detail
     */
    public function setItemDetail(?V1PaymentItemDetail $itemDetail): void
    {
        $this->itemDetail = $itemDetail;
    }

    /**
     * Returns Notes.
     * Notes entered by the merchant about the item at the time of payment, if any.
     */
    public function getNotes(): ?string
    {
        if (count($this->notes) == 0) {
            return null;
        }
        return $this->notes['value'];
    }

    /**
     * Sets Notes.
     * Notes entered by the merchant about the item at the time of payment, if any.
     *
     * @maps notes
     */
    public function setNotes(?string $notes): void
    {
        $this->notes['value'] = $notes;
    }

    /**
     * Unsets Notes.
     * Notes entered by the merchant about the item at the time of payment, if any.
     */
    public function unsetNotes(): void
    {
        $this->notes = [];
    }

    /**
     * Returns Item Variation Name.
     * The name of the item variation purchased, if any.
     */
    public function getItemVariationName(): ?string
    {
        if (count($this->itemVariationName) == 0) {
            return null;
        }
        return $this->itemVariationName['value'];
    }

    /**
     * Sets Item Variation Name.
     * The name of the item variation purchased, if any.
     *
     * @maps item_variation_name
     */
    public function setItemVariationName(?string $itemVariationName): void
    {
        $this->itemVariationName['value'] = $itemVariationName;
    }

    /**
     * Unsets Item Variation Name.
     * The name of the item variation purchased, if any.
     */
    public function unsetItemVariationName(): void
    {
        $this->itemVariationName = [];
    }

    /**
     * Returns Total Money.
     */
    public function getTotalMoney(): ?V1Money
    {
        return $this->totalMoney;
    }

    /**
     * Sets Total Money.
     *
     * @maps total_money
     */
    public function setTotalMoney(?V1Money $totalMoney): void
    {
        $this->totalMoney = $totalMoney;
    }

    /**
     * Returns Single Quantity Money.
     */
    public function getSingleQuantityMoney(): ?V1Money
    {
        return $this->singleQuantityMoney;
    }

    /**
     * Sets Single Quantity Money.
     *
     * @maps single_quantity_money
     */
    public function setSingleQuantityMoney(?V1Money $singleQuantityMoney): void
    {
        $this->singleQuantityMoney = $singleQuantityMoney;
    }

    /**
     * Returns Gross Sales Money.
     */
    public function getGrossSalesMoney(): ?V1Money
    {
        return $this->grossSalesMoney;
    }

    /**
     * Sets Gross Sales Money.
     *
     * @maps gross_sales_money
     */
    public function setGrossSalesMoney(?V1Money $grossSalesMoney): void
    {
        $this->grossSalesMoney = $grossSalesMoney;
    }

    /**
     * Returns Discount Money.
     */
    public function getDiscountMoney(): ?V1Money
    {
        return $this->discountMoney;
    }

    /**
     * Sets Discount Money.
     *
     * @maps discount_money
     */
    public function setDiscountMoney(?V1Money $discountMoney): void
    {
        $this->discountMoney = $discountMoney;
    }

    /**
     * Returns Net Sales Money.
     */
    public function getNetSalesMoney(): ?V1Money
    {
        return $this->netSalesMoney;
    }

    /**
     * Sets Net Sales Money.
     *
     * @maps net_sales_money
     */
    public function setNetSalesMoney(?V1Money $netSalesMoney): void
    {
        $this->netSalesMoney = $netSalesMoney;
    }

    /**
     * Returns Taxes.
     * All taxes applied to this itemization.
     *
     * @return V1PaymentTax[]|null
     */
    public function getTaxes(): ?array
    {
        if (count($this->taxes) == 0) {
            return null;
        }
        return $this->taxes['value'];
    }

    /**
     * Sets Taxes.
     * All taxes applied to this itemization.
     *
     * @maps taxes
     *
     * @param V1PaymentTax[]|null $taxes
     */
    public function setTaxes(?array $taxes): void
    {
        $this->taxes['value'] = $taxes;
    }

    /**
     * Unsets Taxes.
     * All taxes applied to this itemization.
     */
    public function unsetTaxes(): void
    {
        $this->taxes = [];
    }

    /**
     * Returns Discounts.
     * All discounts applied to this itemization.
     *
     * @return V1PaymentDiscount[]|null
     */
    public function getDiscounts(): ?array
    {
        if (count($this->discounts) == 0) {
            return null;
        }
        return $this->discounts['value'];
    }

    /**
     * Sets Discounts.
     * All discounts applied to this itemization.
     *
     * @maps discounts
     *
     * @param V1PaymentDiscount[]|null $discounts
     */
    public function setDiscounts(?array $discounts): void
    {
        $this->discounts['value'] = $discounts;
    }

    /**
     * Unsets Discounts.
     * All discounts applied to this itemization.
     */
    public function unsetDiscounts(): void
    {
        $this->discounts = [];
    }

    /**
     * Returns Modifiers.
     * All modifier options applied to this itemization.
     *
     * @return V1PaymentModifier[]|null
     */
    public function getModifiers(): ?array
    {
        if (count($this->modifiers) == 0) {
            return null;
        }
        return $this->modifiers['value'];
    }

    /**
     * Sets Modifiers.
     * All modifier options applied to this itemization.
     *
     * @maps modifiers
     *
     * @param V1PaymentModifier[]|null $modifiers
     */
    public function setModifiers(?array $modifiers): void
    {
        $this->modifiers['value'] = $modifiers;
    }

    /**
     * Unsets Modifiers.
     * All modifier options applied to this itemization.
     */
    public function unsetModifiers(): void
    {
        $this->modifiers = [];
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
        if (!empty($this->name)) {
            $json['name']                  = $this->name['value'];
        }
        if (!empty($this->quantity)) {
            $json['quantity']              = $this->quantity['value'];
        }
        if (isset($this->itemizationType)) {
            $json['itemization_type']      = $this->itemizationType;
        }
        if (isset($this->itemDetail)) {
            $json['item_detail']           = $this->itemDetail;
        }
        if (!empty($this->notes)) {
            $json['notes']                 = $this->notes['value'];
        }
        if (!empty($this->itemVariationName)) {
            $json['item_variation_name']   = $this->itemVariationName['value'];
        }
        if (isset($this->totalMoney)) {
            $json['total_money']           = $this->totalMoney;
        }
        if (isset($this->singleQuantityMoney)) {
            $json['single_quantity_money'] = $this->singleQuantityMoney;
        }
        if (isset($this->grossSalesMoney)) {
            $json['gross_sales_money']     = $this->grossSalesMoney;
        }
        if (isset($this->discountMoney)) {
            $json['discount_money']        = $this->discountMoney;
        }
        if (isset($this->netSalesMoney)) {
            $json['net_sales_money']       = $this->netSalesMoney;
        }
        if (!empty($this->taxes)) {
            $json['taxes']                 = $this->taxes['value'];
        }
        if (!empty($this->discounts)) {
            $json['discounts']             = $this->discounts['value'];
        }
        if (!empty($this->modifiers)) {
            $json['modifiers']             = $this->modifiers['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
