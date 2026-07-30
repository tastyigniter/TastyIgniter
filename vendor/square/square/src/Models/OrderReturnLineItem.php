<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * The line item being returned in an order.
 */
class OrderReturnLineItem implements \JsonSerializable
{
    /**
     * @var array
     */
    private $uid = [];

    /**
     * @var array
     */
    private $sourceLineItemUid = [];

    /**
     * @var array
     */
    private $name = [];

    /**
     * @var string
     */
    private $quantity;

    /**
     * @var OrderQuantityUnit|null
     */
    private $quantityUnit;

    /**
     * @var array
     */
    private $note = [];

    /**
     * @var array
     */
    private $catalogObjectId = [];

    /**
     * @var array
     */
    private $catalogVersion = [];

    /**
     * @var array
     */
    private $variationName = [];

    /**
     * @var string|null
     */
    private $itemType;

    /**
     * @var array
     */
    private $returnModifiers = [];

    /**
     * @var array
     */
    private $appliedTaxes = [];

    /**
     * @var array
     */
    private $appliedDiscounts = [];

    /**
     * @var Money|null
     */
    private $basePriceMoney;

    /**
     * @var Money|null
     */
    private $variationTotalPriceMoney;

    /**
     * @var Money|null
     */
    private $grossReturnMoney;

    /**
     * @var Money|null
     */
    private $totalTaxMoney;

    /**
     * @var Money|null
     */
    private $totalDiscountMoney;

    /**
     * @var Money|null
     */
    private $totalMoney;

    /**
     * @var array
     */
    private $appliedServiceCharges = [];

    /**
     * @var Money|null
     */
    private $totalServiceChargeMoney;

    /**
     * @param string $quantity
     */
    public function __construct(string $quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * Returns Uid.
     * A unique ID for this return line-item entry.
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
     * A unique ID for this return line-item entry.
     *
     * @maps uid
     */
    public function setUid(?string $uid): void
    {
        $this->uid['value'] = $uid;
    }

    /**
     * Unsets Uid.
     * A unique ID for this return line-item entry.
     */
    public function unsetUid(): void
    {
        $this->uid = [];
    }

    /**
     * Returns Source Line Item Uid.
     * The `uid` of the line item in the original sale order.
     */
    public function getSourceLineItemUid(): ?string
    {
        if (count($this->sourceLineItemUid) == 0) {
            return null;
        }
        return $this->sourceLineItemUid['value'];
    }

    /**
     * Sets Source Line Item Uid.
     * The `uid` of the line item in the original sale order.
     *
     * @maps source_line_item_uid
     */
    public function setSourceLineItemUid(?string $sourceLineItemUid): void
    {
        $this->sourceLineItemUid['value'] = $sourceLineItemUid;
    }

    /**
     * Unsets Source Line Item Uid.
     * The `uid` of the line item in the original sale order.
     */
    public function unsetSourceLineItemUid(): void
    {
        $this->sourceLineItemUid = [];
    }

    /**
     * Returns Name.
     * The name of the line item.
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
     * The name of the line item.
     *
     * @maps name
     */
    public function setName(?string $name): void
    {
        $this->name['value'] = $name;
    }

    /**
     * Unsets Name.
     * The name of the line item.
     */
    public function unsetName(): void
    {
        $this->name = [];
    }

    /**
     * Returns Quantity.
     * The quantity returned, formatted as a decimal number.
     * For example, `"3"`.
     *
     * Line items with a `quantity_unit` can have non-integer quantities.
     * For example, `"1.70000"`.
     */
    public function getQuantity(): string
    {
        return $this->quantity;
    }

    /**
     * Sets Quantity.
     * The quantity returned, formatted as a decimal number.
     * For example, `"3"`.
     *
     * Line items with a `quantity_unit` can have non-integer quantities.
     * For example, `"1.70000"`.
     *
     * @required
     * @maps quantity
     */
    public function setQuantity(string $quantity): void
    {
        $this->quantity = $quantity;
    }

    /**
     * Returns Quantity Unit.
     * Contains the measurement unit for a quantity and a precision that
     * specifies the number of digits after the decimal point for decimal quantities.
     */
    public function getQuantityUnit(): ?OrderQuantityUnit
    {
        return $this->quantityUnit;
    }

    /**
     * Sets Quantity Unit.
     * Contains the measurement unit for a quantity and a precision that
     * specifies the number of digits after the decimal point for decimal quantities.
     *
     * @maps quantity_unit
     */
    public function setQuantityUnit(?OrderQuantityUnit $quantityUnit): void
    {
        $this->quantityUnit = $quantityUnit;
    }

    /**
     * Returns Note.
     * The note of the return line item.
     */
    public function getNote(): ?string
    {
        if (count($this->note) == 0) {
            return null;
        }
        return $this->note['value'];
    }

    /**
     * Sets Note.
     * The note of the return line item.
     *
     * @maps note
     */
    public function setNote(?string $note): void
    {
        $this->note['value'] = $note;
    }

    /**
     * Unsets Note.
     * The note of the return line item.
     */
    public function unsetNote(): void
    {
        $this->note = [];
    }

    /**
     * Returns Catalog Object Id.
     * The [CatalogItemVariation](entity:CatalogItemVariation) ID applied to this return line item.
     */
    public function getCatalogObjectId(): ?string
    {
        if (count($this->catalogObjectId) == 0) {
            return null;
        }
        return $this->catalogObjectId['value'];
    }

    /**
     * Sets Catalog Object Id.
     * The [CatalogItemVariation](entity:CatalogItemVariation) ID applied to this return line item.
     *
     * @maps catalog_object_id
     */
    public function setCatalogObjectId(?string $catalogObjectId): void
    {
        $this->catalogObjectId['value'] = $catalogObjectId;
    }

    /**
     * Unsets Catalog Object Id.
     * The [CatalogItemVariation](entity:CatalogItemVariation) ID applied to this return line item.
     */
    public function unsetCatalogObjectId(): void
    {
        $this->catalogObjectId = [];
    }

    /**
     * Returns Catalog Version.
     * The version of the catalog object that this line item references.
     */
    public function getCatalogVersion(): ?int
    {
        if (count($this->catalogVersion) == 0) {
            return null;
        }
        return $this->catalogVersion['value'];
    }

    /**
     * Sets Catalog Version.
     * The version of the catalog object that this line item references.
     *
     * @maps catalog_version
     */
    public function setCatalogVersion(?int $catalogVersion): void
    {
        $this->catalogVersion['value'] = $catalogVersion;
    }

    /**
     * Unsets Catalog Version.
     * The version of the catalog object that this line item references.
     */
    public function unsetCatalogVersion(): void
    {
        $this->catalogVersion = [];
    }

    /**
     * Returns Variation Name.
     * The name of the variation applied to this return line item.
     */
    public function getVariationName(): ?string
    {
        if (count($this->variationName) == 0) {
            return null;
        }
        return $this->variationName['value'];
    }

    /**
     * Sets Variation Name.
     * The name of the variation applied to this return line item.
     *
     * @maps variation_name
     */
    public function setVariationName(?string $variationName): void
    {
        $this->variationName['value'] = $variationName;
    }

    /**
     * Unsets Variation Name.
     * The name of the variation applied to this return line item.
     */
    public function unsetVariationName(): void
    {
        $this->variationName = [];
    }

    /**
     * Returns Item Type.
     * Represents the line item type.
     */
    public function getItemType(): ?string
    {
        return $this->itemType;
    }

    /**
     * Sets Item Type.
     * Represents the line item type.
     *
     * @maps item_type
     */
    public function setItemType(?string $itemType): void
    {
        $this->itemType = $itemType;
    }

    /**
     * Returns Return Modifiers.
     * The [CatalogModifier](entity:CatalogModifier)s applied to this line item.
     *
     * @return OrderReturnLineItemModifier[]|null
     */
    public function getReturnModifiers(): ?array
    {
        if (count($this->returnModifiers) == 0) {
            return null;
        }
        return $this->returnModifiers['value'];
    }

    /**
     * Sets Return Modifiers.
     * The [CatalogModifier](entity:CatalogModifier)s applied to this line item.
     *
     * @maps return_modifiers
     *
     * @param OrderReturnLineItemModifier[]|null $returnModifiers
     */
    public function setReturnModifiers(?array $returnModifiers): void
    {
        $this->returnModifiers['value'] = $returnModifiers;
    }

    /**
     * Unsets Return Modifiers.
     * The [CatalogModifier](entity:CatalogModifier)s applied to this line item.
     */
    public function unsetReturnModifiers(): void
    {
        $this->returnModifiers = [];
    }

    /**
     * Returns Applied Taxes.
     * The list of references to `OrderReturnTax` entities applied to the return line item. Each
     * `OrderLineItemAppliedTax` has a `tax_uid` that references the `uid` of a top-level
     * `OrderReturnTax` applied to the return line item. On reads, the applied amount
     * is populated.
     *
     * @return OrderLineItemAppliedTax[]|null
     */
    public function getAppliedTaxes(): ?array
    {
        if (count($this->appliedTaxes) == 0) {
            return null;
        }
        return $this->appliedTaxes['value'];
    }

    /**
     * Sets Applied Taxes.
     * The list of references to `OrderReturnTax` entities applied to the return line item. Each
     * `OrderLineItemAppliedTax` has a `tax_uid` that references the `uid` of a top-level
     * `OrderReturnTax` applied to the return line item. On reads, the applied amount
     * is populated.
     *
     * @maps applied_taxes
     *
     * @param OrderLineItemAppliedTax[]|null $appliedTaxes
     */
    public function setAppliedTaxes(?array $appliedTaxes): void
    {
        $this->appliedTaxes['value'] = $appliedTaxes;
    }

    /**
     * Unsets Applied Taxes.
     * The list of references to `OrderReturnTax` entities applied to the return line item. Each
     * `OrderLineItemAppliedTax` has a `tax_uid` that references the `uid` of a top-level
     * `OrderReturnTax` applied to the return line item. On reads, the applied amount
     * is populated.
     */
    public function unsetAppliedTaxes(): void
    {
        $this->appliedTaxes = [];
    }

    /**
     * Returns Applied Discounts.
     * The list of references to `OrderReturnDiscount` entities applied to the return line item. Each
     * `OrderLineItemAppliedDiscount` has a `discount_uid` that references the `uid` of a top-level
     * `OrderReturnDiscount` applied to the return line item. On reads, the applied amount
     * is populated.
     *
     * @return OrderLineItemAppliedDiscount[]|null
     */
    public function getAppliedDiscounts(): ?array
    {
        if (count($this->appliedDiscounts) == 0) {
            return null;
        }
        return $this->appliedDiscounts['value'];
    }

    /**
     * Sets Applied Discounts.
     * The list of references to `OrderReturnDiscount` entities applied to the return line item. Each
     * `OrderLineItemAppliedDiscount` has a `discount_uid` that references the `uid` of a top-level
     * `OrderReturnDiscount` applied to the return line item. On reads, the applied amount
     * is populated.
     *
     * @maps applied_discounts
     *
     * @param OrderLineItemAppliedDiscount[]|null $appliedDiscounts
     */
    public function setAppliedDiscounts(?array $appliedDiscounts): void
    {
        $this->appliedDiscounts['value'] = $appliedDiscounts;
    }

    /**
     * Unsets Applied Discounts.
     * The list of references to `OrderReturnDiscount` entities applied to the return line item. Each
     * `OrderLineItemAppliedDiscount` has a `discount_uid` that references the `uid` of a top-level
     * `OrderReturnDiscount` applied to the return line item. On reads, the applied amount
     * is populated.
     */
    public function unsetAppliedDiscounts(): void
    {
        $this->appliedDiscounts = [];
    }

    /**
     * Returns Base Price Money.
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     */
    public function getBasePriceMoney(): ?Money
    {
        return $this->basePriceMoney;
    }

    /**
     * Sets Base Price Money.
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     *
     * @maps base_price_money
     */
    public function setBasePriceMoney(?Money $basePriceMoney): void
    {
        $this->basePriceMoney = $basePriceMoney;
    }

    /**
     * Returns Variation Total Price Money.
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     */
    public function getVariationTotalPriceMoney(): ?Money
    {
        return $this->variationTotalPriceMoney;
    }

    /**
     * Sets Variation Total Price Money.
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     *
     * @maps variation_total_price_money
     */
    public function setVariationTotalPriceMoney(?Money $variationTotalPriceMoney): void
    {
        $this->variationTotalPriceMoney = $variationTotalPriceMoney;
    }

    /**
     * Returns Gross Return Money.
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     */
    public function getGrossReturnMoney(): ?Money
    {
        return $this->grossReturnMoney;
    }

    /**
     * Sets Gross Return Money.
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     *
     * @maps gross_return_money
     */
    public function setGrossReturnMoney(?Money $grossReturnMoney): void
    {
        $this->grossReturnMoney = $grossReturnMoney;
    }

    /**
     * Returns Total Tax Money.
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     */
    public function getTotalTaxMoney(): ?Money
    {
        return $this->totalTaxMoney;
    }

    /**
     * Sets Total Tax Money.
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     *
     * @maps total_tax_money
     */
    public function setTotalTaxMoney(?Money $totalTaxMoney): void
    {
        $this->totalTaxMoney = $totalTaxMoney;
    }

    /**
     * Returns Total Discount Money.
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     */
    public function getTotalDiscountMoney(): ?Money
    {
        return $this->totalDiscountMoney;
    }

    /**
     * Sets Total Discount Money.
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     *
     * @maps total_discount_money
     */
    public function setTotalDiscountMoney(?Money $totalDiscountMoney): void
    {
        $this->totalDiscountMoney = $totalDiscountMoney;
    }

    /**
     * Returns Total Money.
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     */
    public function getTotalMoney(): ?Money
    {
        return $this->totalMoney;
    }

    /**
     * Sets Total Money.
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     *
     * @maps total_money
     */
    public function setTotalMoney(?Money $totalMoney): void
    {
        $this->totalMoney = $totalMoney;
    }

    /**
     * Returns Applied Service Charges.
     * The list of references to `OrderReturnServiceCharge` entities applied to the return
     * line item. Each `OrderLineItemAppliedServiceCharge` has a `service_charge_uid` that
     * references the `uid` of a top-level `OrderReturnServiceCharge` applied to the return line
     * item. On reads, the applied amount is populated.
     *
     * @return OrderLineItemAppliedServiceCharge[]|null
     */
    public function getAppliedServiceCharges(): ?array
    {
        if (count($this->appliedServiceCharges) == 0) {
            return null;
        }
        return $this->appliedServiceCharges['value'];
    }

    /**
     * Sets Applied Service Charges.
     * The list of references to `OrderReturnServiceCharge` entities applied to the return
     * line item. Each `OrderLineItemAppliedServiceCharge` has a `service_charge_uid` that
     * references the `uid` of a top-level `OrderReturnServiceCharge` applied to the return line
     * item. On reads, the applied amount is populated.
     *
     * @maps applied_service_charges
     *
     * @param OrderLineItemAppliedServiceCharge[]|null $appliedServiceCharges
     */
    public function setAppliedServiceCharges(?array $appliedServiceCharges): void
    {
        $this->appliedServiceCharges['value'] = $appliedServiceCharges;
    }

    /**
     * Unsets Applied Service Charges.
     * The list of references to `OrderReturnServiceCharge` entities applied to the return
     * line item. Each `OrderLineItemAppliedServiceCharge` has a `service_charge_uid` that
     * references the `uid` of a top-level `OrderReturnServiceCharge` applied to the return line
     * item. On reads, the applied amount is populated.
     */
    public function unsetAppliedServiceCharges(): void
    {
        $this->appliedServiceCharges = [];
    }

    /**
     * Returns Total Service Charge Money.
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     */
    public function getTotalServiceChargeMoney(): ?Money
    {
        return $this->totalServiceChargeMoney;
    }

    /**
     * Sets Total Service Charge Money.
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     *
     * @maps total_service_charge_money
     */
    public function setTotalServiceChargeMoney(?Money $totalServiceChargeMoney): void
    {
        $this->totalServiceChargeMoney = $totalServiceChargeMoney;
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
            $json['uid']                         = $this->uid['value'];
        }
        if (!empty($this->sourceLineItemUid)) {
            $json['source_line_item_uid']        = $this->sourceLineItemUid['value'];
        }
        if (!empty($this->name)) {
            $json['name']                        = $this->name['value'];
        }
        $json['quantity']                        = $this->quantity;
        if (isset($this->quantityUnit)) {
            $json['quantity_unit']               = $this->quantityUnit;
        }
        if (!empty($this->note)) {
            $json['note']                        = $this->note['value'];
        }
        if (!empty($this->catalogObjectId)) {
            $json['catalog_object_id']           = $this->catalogObjectId['value'];
        }
        if (!empty($this->catalogVersion)) {
            $json['catalog_version']             = $this->catalogVersion['value'];
        }
        if (!empty($this->variationName)) {
            $json['variation_name']              = $this->variationName['value'];
        }
        if (isset($this->itemType)) {
            $json['item_type']                   = $this->itemType;
        }
        if (!empty($this->returnModifiers)) {
            $json['return_modifiers']            = $this->returnModifiers['value'];
        }
        if (!empty($this->appliedTaxes)) {
            $json['applied_taxes']               = $this->appliedTaxes['value'];
        }
        if (!empty($this->appliedDiscounts)) {
            $json['applied_discounts']           = $this->appliedDiscounts['value'];
        }
        if (isset($this->basePriceMoney)) {
            $json['base_price_money']            = $this->basePriceMoney;
        }
        if (isset($this->variationTotalPriceMoney)) {
            $json['variation_total_price_money'] = $this->variationTotalPriceMoney;
        }
        if (isset($this->grossReturnMoney)) {
            $json['gross_return_money']          = $this->grossReturnMoney;
        }
        if (isset($this->totalTaxMoney)) {
            $json['total_tax_money']             = $this->totalTaxMoney;
        }
        if (isset($this->totalDiscountMoney)) {
            $json['total_discount_money']        = $this->totalDiscountMoney;
        }
        if (isset($this->totalMoney)) {
            $json['total_money']                 = $this->totalMoney;
        }
        if (!empty($this->appliedServiceCharges)) {
            $json['applied_service_charges']     = $this->appliedServiceCharges['value'];
        }
        if (isset($this->totalServiceChargeMoney)) {
            $json['total_service_charge_money']  = $this->totalServiceChargeMoney;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
