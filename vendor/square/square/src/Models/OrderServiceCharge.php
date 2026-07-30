<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents a service charge applied to an order.
 */
class OrderServiceCharge implements \JsonSerializable
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
    private $percentage = [];

    /**
     * @var Money|null
     */
    private $amountMoney;

    /**
     * @var Money|null
     */
    private $appliedMoney;

    /**
     * @var Money|null
     */
    private $totalMoney;

    /**
     * @var Money|null
     */
    private $totalTaxMoney;

    /**
     * @var string|null
     */
    private $calculationPhase;

    /**
     * @var array
     */
    private $taxable = [];

    /**
     * @var array
     */
    private $appliedTaxes = [];

    /**
     * @var array
     */
    private $metadata = [];

    /**
     * @var string|null
     */
    private $type;

    /**
     * @var string|null
     */
    private $treatmentType;

    /**
     * @var string|null
     */
    private $scope;

    /**
     * Returns Uid.
     * A unique ID that identifies the service charge only within this order.
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
     * A unique ID that identifies the service charge only within this order.
     *
     * @maps uid
     */
    public function setUid(?string $uid): void
    {
        $this->uid['value'] = $uid;
    }

    /**
     * Unsets Uid.
     * A unique ID that identifies the service charge only within this order.
     */
    public function unsetUid(): void
    {
        $this->uid = [];
    }

    /**
     * Returns Name.
     * The name of the service charge.
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
     * The name of the service charge.
     *
     * @maps name
     */
    public function setName(?string $name): void
    {
        $this->name['value'] = $name;
    }

    /**
     * Unsets Name.
     * The name of the service charge.
     */
    public function unsetName(): void
    {
        $this->name = [];
    }

    /**
     * Returns Catalog Object Id.
     * The catalog object ID referencing the service charge [CatalogObject](entity:CatalogObject).
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
     * The catalog object ID referencing the service charge [CatalogObject](entity:CatalogObject).
     *
     * @maps catalog_object_id
     */
    public function setCatalogObjectId(?string $catalogObjectId): void
    {
        $this->catalogObjectId['value'] = $catalogObjectId;
    }

    /**
     * Unsets Catalog Object Id.
     * The catalog object ID referencing the service charge [CatalogObject](entity:CatalogObject).
     */
    public function unsetCatalogObjectId(): void
    {
        $this->catalogObjectId = [];
    }

    /**
     * Returns Catalog Version.
     * The version of the catalog object that this service charge references.
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
     * The version of the catalog object that this service charge references.
     *
     * @maps catalog_version
     */
    public function setCatalogVersion(?int $catalogVersion): void
    {
        $this->catalogVersion['value'] = $catalogVersion;
    }

    /**
     * Unsets Catalog Version.
     * The version of the catalog object that this service charge references.
     */
    public function unsetCatalogVersion(): void
    {
        $this->catalogVersion = [];
    }

    /**
     * Returns Percentage.
     * The service charge percentage as a string representation of a
     * decimal number. For example, `"7.25"` indicates a service charge of 7.25%.
     *
     * Exactly 1 of `percentage` or `amount_money` should be set.
     */
    public function getPercentage(): ?string
    {
        if (count($this->percentage) == 0) {
            return null;
        }
        return $this->percentage['value'];
    }

    /**
     * Sets Percentage.
     * The service charge percentage as a string representation of a
     * decimal number. For example, `"7.25"` indicates a service charge of 7.25%.
     *
     * Exactly 1 of `percentage` or `amount_money` should be set.
     *
     * @maps percentage
     */
    public function setPercentage(?string $percentage): void
    {
        $this->percentage['value'] = $percentage;
    }

    /**
     * Unsets Percentage.
     * The service charge percentage as a string representation of a
     * decimal number. For example, `"7.25"` indicates a service charge of 7.25%.
     *
     * Exactly 1 of `percentage` or `amount_money` should be set.
     */
    public function unsetPercentage(): void
    {
        $this->percentage = [];
    }

    /**
     * Returns Amount Money.
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     */
    public function getAmountMoney(): ?Money
    {
        return $this->amountMoney;
    }

    /**
     * Sets Amount Money.
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     *
     * @maps amount_money
     */
    public function setAmountMoney(?Money $amountMoney): void
    {
        $this->amountMoney = $amountMoney;
    }

    /**
     * Returns Applied Money.
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     */
    public function getAppliedMoney(): ?Money
    {
        return $this->appliedMoney;
    }

    /**
     * Sets Applied Money.
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     *
     * @maps applied_money
     */
    public function setAppliedMoney(?Money $appliedMoney): void
    {
        $this->appliedMoney = $appliedMoney;
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
     * Returns Calculation Phase.
     * Represents a phase in the process of calculating order totals.
     * Service charges are applied after the indicated phase.
     *
     * [Read more about how order totals are calculated.](https://developer.squareup.com/docs/orders-
     * api/how-it-works#how-totals-are-calculated)
     */
    public function getCalculationPhase(): ?string
    {
        return $this->calculationPhase;
    }

    /**
     * Sets Calculation Phase.
     * Represents a phase in the process of calculating order totals.
     * Service charges are applied after the indicated phase.
     *
     * [Read more about how order totals are calculated.](https://developer.squareup.com/docs/orders-
     * api/how-it-works#how-totals-are-calculated)
     *
     * @maps calculation_phase
     */
    public function setCalculationPhase(?string $calculationPhase): void
    {
        $this->calculationPhase = $calculationPhase;
    }

    /**
     * Returns Taxable.
     * Indicates whether the service charge can be taxed. If set to `true`,
     * order-level taxes automatically apply to the service charge. Note that
     * service charges calculated in the `TOTAL_PHASE` cannot be marked as taxable.
     */
    public function getTaxable(): ?bool
    {
        if (count($this->taxable) == 0) {
            return null;
        }
        return $this->taxable['value'];
    }

    /**
     * Sets Taxable.
     * Indicates whether the service charge can be taxed. If set to `true`,
     * order-level taxes automatically apply to the service charge. Note that
     * service charges calculated in the `TOTAL_PHASE` cannot be marked as taxable.
     *
     * @maps taxable
     */
    public function setTaxable(?bool $taxable): void
    {
        $this->taxable['value'] = $taxable;
    }

    /**
     * Unsets Taxable.
     * Indicates whether the service charge can be taxed. If set to `true`,
     * order-level taxes automatically apply to the service charge. Note that
     * service charges calculated in the `TOTAL_PHASE` cannot be marked as taxable.
     */
    public function unsetTaxable(): void
    {
        $this->taxable = [];
    }

    /**
     * Returns Applied Taxes.
     * The list of references to the taxes applied to this service charge. Each
     * `OrderLineItemAppliedTax` has a `tax_uid` that references the `uid` of a top-level
     * `OrderLineItemTax` that is being applied to this service charge. On reads, the amount applied
     * is populated.
     *
     * An `OrderLineItemAppliedTax` is automatically created on every taxable service charge
     * for all `ORDER` scoped taxes that are added to the order. `OrderLineItemAppliedTax` records
     * for `LINE_ITEM` scoped taxes must be added in requests for the tax to apply to any taxable
     * service charge. Taxable service charges have the `taxable` field set to `true` and calculated
     * in the `SUBTOTAL_PHASE`.
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
     * The list of references to the taxes applied to this service charge. Each
     * `OrderLineItemAppliedTax` has a `tax_uid` that references the `uid` of a top-level
     * `OrderLineItemTax` that is being applied to this service charge. On reads, the amount applied
     * is populated.
     *
     * An `OrderLineItemAppliedTax` is automatically created on every taxable service charge
     * for all `ORDER` scoped taxes that are added to the order. `OrderLineItemAppliedTax` records
     * for `LINE_ITEM` scoped taxes must be added in requests for the tax to apply to any taxable
     * service charge. Taxable service charges have the `taxable` field set to `true` and calculated
     * in the `SUBTOTAL_PHASE`.
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
     * The list of references to the taxes applied to this service charge. Each
     * `OrderLineItemAppliedTax` has a `tax_uid` that references the `uid` of a top-level
     * `OrderLineItemTax` that is being applied to this service charge. On reads, the amount applied
     * is populated.
     *
     * An `OrderLineItemAppliedTax` is automatically created on every taxable service charge
     * for all `ORDER` scoped taxes that are added to the order. `OrderLineItemAppliedTax` records
     * for `LINE_ITEM` scoped taxes must be added in requests for the tax to apply to any taxable
     * service charge. Taxable service charges have the `taxable` field set to `true` and calculated
     * in the `SUBTOTAL_PHASE`.
     *
     * To change the amount of a tax, modify the referenced top-level tax.
     */
    public function unsetAppliedTaxes(): void
    {
        $this->appliedTaxes = [];
    }

    /**
     * Returns Metadata.
     * Application-defined data attached to this service charge. Metadata fields are intended
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
     * Application-defined data attached to this service charge. Metadata fields are intended
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
     * Application-defined data attached to this service charge. Metadata fields are intended
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
     * Returns Type.
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * Sets Type.
     *
     * @maps type
     */
    public function setType(?string $type): void
    {
        $this->type = $type;
    }

    /**
     * Returns Treatment Type.
     * Indicates whether the service charge will be treated as a value-holding line item or
     * apportioned toward a line item.
     */
    public function getTreatmentType(): ?string
    {
        return $this->treatmentType;
    }

    /**
     * Sets Treatment Type.
     * Indicates whether the service charge will be treated as a value-holding line item or
     * apportioned toward a line item.
     *
     * @maps treatment_type
     */
    public function setTreatmentType(?string $treatmentType): void
    {
        $this->treatmentType = $treatmentType;
    }

    /**
     * Returns Scope.
     * Indicates whether this is a line-item or order-level apportioned
     * service charge.
     */
    public function getScope(): ?string
    {
        return $this->scope;
    }

    /**
     * Sets Scope.
     * Indicates whether this is a line-item or order-level apportioned
     * service charge.
     *
     * @maps scope
     */
    public function setScope(?string $scope): void
    {
        $this->scope = $scope;
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
            $json['uid']               = $this->uid['value'];
        }
        if (!empty($this->name)) {
            $json['name']              = $this->name['value'];
        }
        if (!empty($this->catalogObjectId)) {
            $json['catalog_object_id'] = $this->catalogObjectId['value'];
        }
        if (!empty($this->catalogVersion)) {
            $json['catalog_version']   = $this->catalogVersion['value'];
        }
        if (!empty($this->percentage)) {
            $json['percentage']        = $this->percentage['value'];
        }
        if (isset($this->amountMoney)) {
            $json['amount_money']      = $this->amountMoney;
        }
        if (isset($this->appliedMoney)) {
            $json['applied_money']     = $this->appliedMoney;
        }
        if (isset($this->totalMoney)) {
            $json['total_money']       = $this->totalMoney;
        }
        if (isset($this->totalTaxMoney)) {
            $json['total_tax_money']   = $this->totalTaxMoney;
        }
        if (isset($this->calculationPhase)) {
            $json['calculation_phase'] = $this->calculationPhase;
        }
        if (!empty($this->taxable)) {
            $json['taxable']           = $this->taxable['value'];
        }
        if (!empty($this->appliedTaxes)) {
            $json['applied_taxes']     = $this->appliedTaxes['value'];
        }
        if (!empty($this->metadata)) {
            $json['metadata']          = $this->metadata['value'];
        }
        if (isset($this->type)) {
            $json['type']              = $this->type;
        }
        if (isset($this->treatmentType)) {
            $json['treatment_type']    = $this->treatmentType;
        }
        if (isset($this->scope)) {
            $json['scope']             = $this->scope;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
