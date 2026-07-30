<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents the service charge applied to the original order.
 */
class OrderReturnServiceCharge implements \JsonSerializable
{
    /**
     * @var array
     */
    private $uid = [];

    /**
     * @var array
     */
    private $sourceServiceChargeUid = [];

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
     * @var string|null
     */
    private $treatmentType;

    /**
     * @var string|null
     */
    private $scope;

    /**
     * Returns Uid.
     * A unique ID that identifies the return service charge only within this order.
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
     * A unique ID that identifies the return service charge only within this order.
     *
     * @maps uid
     */
    public function setUid(?string $uid): void
    {
        $this->uid['value'] = $uid;
    }

    /**
     * Unsets Uid.
     * A unique ID that identifies the return service charge only within this order.
     */
    public function unsetUid(): void
    {
        $this->uid = [];
    }

    /**
     * Returns Source Service Charge Uid.
     * The service charge `uid` from the order containing the original
     * service charge. `source_service_charge_uid` is `null` for
     * unlinked returns.
     */
    public function getSourceServiceChargeUid(): ?string
    {
        if (count($this->sourceServiceChargeUid) == 0) {
            return null;
        }
        return $this->sourceServiceChargeUid['value'];
    }

    /**
     * Sets Source Service Charge Uid.
     * The service charge `uid` from the order containing the original
     * service charge. `source_service_charge_uid` is `null` for
     * unlinked returns.
     *
     * @maps source_service_charge_uid
     */
    public function setSourceServiceChargeUid(?string $sourceServiceChargeUid): void
    {
        $this->sourceServiceChargeUid['value'] = $sourceServiceChargeUid;
    }

    /**
     * Unsets Source Service Charge Uid.
     * The service charge `uid` from the order containing the original
     * service charge. `source_service_charge_uid` is `null` for
     * unlinked returns.
     */
    public function unsetSourceServiceChargeUid(): void
    {
        $this->sourceServiceChargeUid = [];
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
     * The catalog object ID of the associated [OrderServiceCharge](entity:OrderServiceCharge).
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
     * The catalog object ID of the associated [OrderServiceCharge](entity:OrderServiceCharge).
     *
     * @maps catalog_object_id
     */
    public function setCatalogObjectId(?string $catalogObjectId): void
    {
        $this->catalogObjectId['value'] = $catalogObjectId;
    }

    /**
     * Unsets Catalog Object Id.
     * The catalog object ID of the associated [OrderServiceCharge](entity:OrderServiceCharge).
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
     * The percentage of the service charge, as a string representation of
     * a decimal number. For example, a value of `"7.25"` corresponds to a
     * percentage of 7.25%.
     *
     * Either `percentage` or `amount_money` should be set, but not both.
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
     * The percentage of the service charge, as a string representation of
     * a decimal number. For example, a value of `"7.25"` corresponds to a
     * percentage of 7.25%.
     *
     * Either `percentage` or `amount_money` should be set, but not both.
     *
     * @maps percentage
     */
    public function setPercentage(?string $percentage): void
    {
        $this->percentage['value'] = $percentage;
    }

    /**
     * Unsets Percentage.
     * The percentage of the service charge, as a string representation of
     * a decimal number. For example, a value of `"7.25"` corresponds to a
     * percentage of 7.25%.
     *
     * Either `percentage` or `amount_money` should be set, but not both.
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
     * Indicates whether the surcharge can be taxed. Service charges
     * calculated in the `TOTAL_PHASE` cannot be marked as taxable.
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
     * Indicates whether the surcharge can be taxed. Service charges
     * calculated in the `TOTAL_PHASE` cannot be marked as taxable.
     *
     * @maps taxable
     */
    public function setTaxable(?bool $taxable): void
    {
        $this->taxable['value'] = $taxable;
    }

    /**
     * Unsets Taxable.
     * Indicates whether the surcharge can be taxed. Service charges
     * calculated in the `TOTAL_PHASE` cannot be marked as taxable.
     */
    public function unsetTaxable(): void
    {
        $this->taxable = [];
    }

    /**
     * Returns Applied Taxes.
     * The list of references to `OrderReturnTax` entities applied to the
     * `OrderReturnServiceCharge`. Each `OrderLineItemAppliedTax` has a `tax_uid`
     * that references the `uid` of a top-level `OrderReturnTax` that is being
     * applied to the `OrderReturnServiceCharge`. On reads, the applied amount is
     * populated.
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
     * The list of references to `OrderReturnTax` entities applied to the
     * `OrderReturnServiceCharge`. Each `OrderLineItemAppliedTax` has a `tax_uid`
     * that references the `uid` of a top-level `OrderReturnTax` that is being
     * applied to the `OrderReturnServiceCharge`. On reads, the applied amount is
     * populated.
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
     * The list of references to `OrderReturnTax` entities applied to the
     * `OrderReturnServiceCharge`. Each `OrderLineItemAppliedTax` has a `tax_uid`
     * that references the `uid` of a top-level `OrderReturnTax` that is being
     * applied to the `OrderReturnServiceCharge`. On reads, the applied amount is
     * populated.
     */
    public function unsetAppliedTaxes(): void
    {
        $this->appliedTaxes = [];
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
            $json['uid']                       = $this->uid['value'];
        }
        if (!empty($this->sourceServiceChargeUid)) {
            $json['source_service_charge_uid'] = $this->sourceServiceChargeUid['value'];
        }
        if (!empty($this->name)) {
            $json['name']                      = $this->name['value'];
        }
        if (!empty($this->catalogObjectId)) {
            $json['catalog_object_id']         = $this->catalogObjectId['value'];
        }
        if (!empty($this->catalogVersion)) {
            $json['catalog_version']           = $this->catalogVersion['value'];
        }
        if (!empty($this->percentage)) {
            $json['percentage']                = $this->percentage['value'];
        }
        if (isset($this->amountMoney)) {
            $json['amount_money']              = $this->amountMoney;
        }
        if (isset($this->appliedMoney)) {
            $json['applied_money']             = $this->appliedMoney;
        }
        if (isset($this->totalMoney)) {
            $json['total_money']               = $this->totalMoney;
        }
        if (isset($this->totalTaxMoney)) {
            $json['total_tax_money']           = $this->totalTaxMoney;
        }
        if (isset($this->calculationPhase)) {
            $json['calculation_phase']         = $this->calculationPhase;
        }
        if (!empty($this->taxable)) {
            $json['taxable']                   = $this->taxable['value'];
        }
        if (!empty($this->appliedTaxes)) {
            $json['applied_taxes']             = $this->appliedTaxes['value'];
        }
        if (isset($this->treatmentType)) {
            $json['treatment_type']            = $this->treatmentType;
        }
        if (isset($this->scope)) {
            $json['scope']                     = $this->scope;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
