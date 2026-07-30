<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents a line item in an order. Each line item describes a different
 * product to purchase, with its own quantity and price details.
 */
class OrderLineItem implements \JsonSerializable
{
    /**
     * @var array
     */
    private $uid = [];

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
    private $metadata = [];

    /**
     * @var array
     */
    private $modifiers = [];

    /**
     * @var array
     */
    private $appliedTaxes = [];

    /**
     * @var array
     */
    private $appliedDiscounts = [];

    /**
     * @var array
     */
    private $appliedServiceCharges = [];

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
    private $grossSalesMoney;

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
     * @var OrderLineItemPricingBlocklists|null
     */
    private $pricingBlocklists;

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
     * A unique ID that identifies the line item only within this order.
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
     * A unique ID that identifies the line item only within this order.
     *
     * @maps uid
     */
    public function setUid(?string $uid): void
    {
        $this->uid['value'] = $uid;
    }

    /**
     * Unsets Uid.
     * A unique ID that identifies the line item only within this order.
     */
    public function unsetUid(): void
    {
        $this->uid = [];
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
     * The quantity purchased, formatted as a decimal number.
     * For example, `"3"`.
     *
     * Line items with a quantity of `"0"` are automatically removed
     * when paying for or otherwise completing the order.
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
     * The quantity purchased, formatted as a decimal number.
     * For example, `"3"`.
     *
     * Line items with a quantity of `"0"` are automatically removed
     * when paying for or otherwise completing the order.
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
     * The note of the line item.
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
     * The note of the line item.
     *
     * @maps note
     */
    public function setNote(?string $note): void
    {
        $this->note['value'] = $note;
    }

    /**
     * Unsets Note.
     * The note of the line item.
     */
    public function unsetNote(): void
    {
        $this->note = [];
    }

    /**
     * Returns Catalog Object Id.
     * The [CatalogItemVariation](entity:CatalogItemVariation) ID applied to this line item.
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
     * The [CatalogItemVariation](entity:CatalogItemVariation) ID applied to this line item.
     *
     * @maps catalog_object_id
     */
    public function setCatalogObjectId(?string $catalogObjectId): void
    {
        $this->catalogObjectId['value'] = $catalogObjectId;
    }

    /**
     * Unsets Catalog Object Id.
     * The [CatalogItemVariation](entity:CatalogItemVariation) ID applied to this line item.
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
     * The name of the variation applied to this line item.
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
     * The name of the variation applied to this line item.
     *
     * @maps variation_name
     */
    public function setVariationName(?string $variationName): void
    {
        $this->variationName['value'] = $variationName;
    }

    /**
     * Unsets Variation Name.
     * The name of the variation applied to this line item.
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
     * Returns Metadata.
     * Application-defined data attached to this line item. Metadata fields are intended
     * to store descriptive references or associations with an entity in another system or store brief
     * information about the object. Square does not process this field; it only stores and returns it
     * in relevant API calls. Do not use metadata to store any sensitive information (such as personally
     * identifiable information or card details).
     *
     * Keys written by applications must be 60 characters or less and must be in the character set
     * `[a-zA-Z0-9_-]`. Entries can also include metadata generated by Square. These keys are prefixed
     * with a namespace, separated from the key with a ':' character.
     *
     * Values have a maximum length of 255 characters.
     *
     * An application can have up to 10 entries per metadata field.
     *
     * Entries written by applications are private and can only be read or modified by the same
     * application.
     *
     * For more information, see [Metadata](https://developer.squareup.com/docs/build-basics/metadata).
     *
     * @return array<string,string>|null
     */
    public function getMetadata(): ?array
    {
        if (count($this->metadata) == 0) {
            return null;
        }
        return $this->metadata['value'];
    }

    /**
     * Sets Metadata.
     * Application-defined data attached to this line item. Metadata fields are intended
     * to store descriptive references or associations with an entity in another system or store brief
     * information about the object. Square does not process this field; it only stores and returns it
     * in relevant API calls. Do not use metadata to store any sensitive information (such as personally
     * identifiable information or card details).
     *
     * Keys written by applications must be 60 characters or less and must be in the character set
     * `[a-zA-Z0-9_-]`. Entries can also include metadata generated by Square. These keys are prefixed
     * with a namespace, separated from the key with a ':' character.
     *
     * Values have a maximum length of 255 characters.
     *
     * An application can have up to 10 entries per metadata field.
     *
     * Entries written by applications are private and can only be read or modified by the same
     * application.
     *
     * For more information, see [Metadata](https://developer.squareup.com/docs/build-basics/metadata).
     *
     * @maps metadata
     *
     * @param array<string,string>|null $metadata
     */
    public function setMetadata(?array $metadata): void
    {
        $this->metadata['value'] = $metadata;
    }

    /**
     * Unsets Metadata.
     * Application-defined data attached to this line item. Metadata fields are intended
     * to store descriptive references or associations with an entity in another system or store brief
     * information about the object. Square does not process this field; it only stores and returns it
     * in relevant API calls. Do not use metadata to store any sensitive information (such as personally
     * identifiable information or card details).
     *
     * Keys written by applications must be 60 characters or less and must be in the character set
     * `[a-zA-Z0-9_-]`. Entries can also include metadata generated by Square. These keys are prefixed
     * with a namespace, separated from the key with a ':' character.
     *
     * Values have a maximum length of 255 characters.
     *
     * An application can have up to 10 entries per metadata field.
     *
     * Entries written by applications are private and can only be read or modified by the same
     * application.
     *
     * For more information, see [Metadata](https://developer.squareup.com/docs/build-basics/metadata).
     */
    public function unsetMetadata(): void
    {
        $this->metadata = [];
    }

    /**
     * Returns Modifiers.
     * The [CatalogModifier](entity:CatalogModifier)s applied to this line item.
     *
     * @return OrderLineItemModifier[]|null
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
     * The [CatalogModifier](entity:CatalogModifier)s applied to this line item.
     *
     * @maps modifiers
     *
     * @param OrderLineItemModifier[]|null $modifiers
     */
    public function setModifiers(?array $modifiers): void
    {
        $this->modifiers['value'] = $modifiers;
    }

    /**
     * Unsets Modifiers.
     * The [CatalogModifier](entity:CatalogModifier)s applied to this line item.
     */
    public function unsetModifiers(): void
    {
        $this->modifiers = [];
    }

    /**
     * Returns Applied Taxes.
     * The list of references to taxes applied to this line item. Each
     * `OrderLineItemAppliedTax` has a `tax_uid` that references the `uid` of a
     * top-level `OrderLineItemTax` applied to the line item. On reads, the
     * amount applied is populated.
     *
     * An `OrderLineItemAppliedTax` is automatically created on every line
     * item for all `ORDER` scoped taxes added to the order. `OrderLineItemAppliedTax`
     * records for `LINE_ITEM` scoped taxes must be added in requests for the tax
     * to apply to any line items.
     *
     * To change the amount of a tax, modify the referenced top-level tax.
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
     * The list of references to taxes applied to this line item. Each
     * `OrderLineItemAppliedTax` has a `tax_uid` that references the `uid` of a
     * top-level `OrderLineItemTax` applied to the line item. On reads, the
     * amount applied is populated.
     *
     * An `OrderLineItemAppliedTax` is automatically created on every line
     * item for all `ORDER` scoped taxes added to the order. `OrderLineItemAppliedTax`
     * records for `LINE_ITEM` scoped taxes must be added in requests for the tax
     * to apply to any line items.
     *
     * To change the amount of a tax, modify the referenced top-level tax.
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
     * The list of references to taxes applied to this line item. Each
     * `OrderLineItemAppliedTax` has a `tax_uid` that references the `uid` of a
     * top-level `OrderLineItemTax` applied to the line item. On reads, the
     * amount applied is populated.
     *
     * An `OrderLineItemAppliedTax` is automatically created on every line
     * item for all `ORDER` scoped taxes added to the order. `OrderLineItemAppliedTax`
     * records for `LINE_ITEM` scoped taxes must be added in requests for the tax
     * to apply to any line items.
     *
     * To change the amount of a tax, modify the referenced top-level tax.
     */
    public function unsetAppliedTaxes(): void
    {
        $this->appliedTaxes = [];
    }

    /**
     * Returns Applied Discounts.
     * The list of references to discounts applied to this line item. Each
     * `OrderLineItemAppliedDiscount` has a `discount_uid` that references the `uid` of a top-level
     * `OrderLineItemDiscounts` applied to the line item. On reads, the amount
     * applied is populated.
     *
     * An `OrderLineItemAppliedDiscount` is automatically created on every line item for all
     * `ORDER` scoped discounts that are added to the order. `OrderLineItemAppliedDiscount` records
     * for `LINE_ITEM` scoped discounts must be added in requests for the discount to apply to any
     * line items.
     *
     * To change the amount of a discount, modify the referenced top-level discount.
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
     * The list of references to discounts applied to this line item. Each
     * `OrderLineItemAppliedDiscount` has a `discount_uid` that references the `uid` of a top-level
     * `OrderLineItemDiscounts` applied to the line item. On reads, the amount
     * applied is populated.
     *
     * An `OrderLineItemAppliedDiscount` is automatically created on every line item for all
     * `ORDER` scoped discounts that are added to the order. `OrderLineItemAppliedDiscount` records
     * for `LINE_ITEM` scoped discounts must be added in requests for the discount to apply to any
     * line items.
     *
     * To change the amount of a discount, modify the referenced top-level discount.
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
     * The list of references to discounts applied to this line item. Each
     * `OrderLineItemAppliedDiscount` has a `discount_uid` that references the `uid` of a top-level
     * `OrderLineItemDiscounts` applied to the line item. On reads, the amount
     * applied is populated.
     *
     * An `OrderLineItemAppliedDiscount` is automatically created on every line item for all
     * `ORDER` scoped discounts that are added to the order. `OrderLineItemAppliedDiscount` records
     * for `LINE_ITEM` scoped discounts must be added in requests for the discount to apply to any
     * line items.
     *
     * To change the amount of a discount, modify the referenced top-level discount.
     */
    public function unsetAppliedDiscounts(): void
    {
        $this->appliedDiscounts = [];
    }

    /**
     * Returns Applied Service Charges.
     * The list of references to service charges applied to this line item. Each
     * `OrderLineItemAppliedServiceCharge` has a `service_charge_id` that references the `uid` of a
     * top-level `OrderServiceCharge` applied to the line item. On reads, the amount applied is
     * populated.
     *
     * To change the amount of a service charge, modify the referenced top-level service charge.
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
     * The list of references to service charges applied to this line item. Each
     * `OrderLineItemAppliedServiceCharge` has a `service_charge_id` that references the `uid` of a
     * top-level `OrderServiceCharge` applied to the line item. On reads, the amount applied is
     * populated.
     *
     * To change the amount of a service charge, modify the referenced top-level service charge.
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
     * The list of references to service charges applied to this line item. Each
     * `OrderLineItemAppliedServiceCharge` has a `service_charge_id` that references the `uid` of a
     * top-level `OrderServiceCharge` applied to the line item. On reads, the amount applied is
     * populated.
     *
     * To change the amount of a service charge, modify the referenced top-level service charge.
     */
    public function unsetAppliedServiceCharges(): void
    {
        $this->appliedServiceCharges = [];
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
     * Returns Gross Sales Money.
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     */
    public function getGrossSalesMoney(): ?Money
    {
        return $this->grossSalesMoney;
    }

    /**
     * Sets Gross Sales Money.
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     *
     * @maps gross_sales_money
     */
    public function setGrossSalesMoney(?Money $grossSalesMoney): void
    {
        $this->grossSalesMoney = $grossSalesMoney;
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
     * Returns Pricing Blocklists.
     * Describes pricing adjustments that are blocked from automatic
     * application to a line item. For more information, see
     * [Apply Taxes and Discounts](https://developer.squareup.com/docs/orders-api/apply-taxes-and-
     * discounts).
     */
    public function getPricingBlocklists(): ?OrderLineItemPricingBlocklists
    {
        return $this->pricingBlocklists;
    }

    /**
     * Sets Pricing Blocklists.
     * Describes pricing adjustments that are blocked from automatic
     * application to a line item. For more information, see
     * [Apply Taxes and Discounts](https://developer.squareup.com/docs/orders-api/apply-taxes-and-
     * discounts).
     *
     * @maps pricing_blocklists
     */
    public function setPricingBlocklists(?OrderLineItemPricingBlocklists $pricingBlocklists): void
    {
        $this->pricingBlocklists = $pricingBlocklists;
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
        if (!empty($this->metadata)) {
            $json['metadata']                    = $this->metadata['value'];
        }
        if (!empty($this->modifiers)) {
            $json['modifiers']                   = $this->modifiers['value'];
        }
        if (!empty($this->appliedTaxes)) {
            $json['applied_taxes']               = $this->appliedTaxes['value'];
        }
        if (!empty($this->appliedDiscounts)) {
            $json['applied_discounts']           = $this->appliedDiscounts['value'];
        }
        if (!empty($this->appliedServiceCharges)) {
            $json['applied_service_charges']     = $this->appliedServiceCharges['value'];
        }
        if (isset($this->basePriceMoney)) {
            $json['base_price_money']            = $this->basePriceMoney;
        }
        if (isset($this->variationTotalPriceMoney)) {
            $json['variation_total_price_money'] = $this->variationTotalPriceMoney;
        }
        if (isset($this->grossSalesMoney)) {
            $json['gross_sales_money']           = $this->grossSalesMoney;
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
        if (isset($this->pricingBlocklists)) {
            $json['pricing_blocklists']          = $this->pricingBlocklists;
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
