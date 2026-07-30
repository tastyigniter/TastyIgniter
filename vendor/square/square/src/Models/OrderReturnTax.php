<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents a tax being returned that applies to one or more return line items in an order.
 *
 * Fixed-amount, order-scoped taxes are distributed across all non-zero return line item totals.
 * The amount distributed to each return line item is relative to that item’s contribution to the
 * order subtotal.
 */
class OrderReturnTax implements \JsonSerializable
{
    /**
     * @var array
     */
    private $uid = [];

    /**
     * @var array
     */
    private $sourceTaxUid = [];

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
    private $name = [];

    /**
     * @var string|null
     */
    private $type;

    /**
     * @var array
     */
    private $percentage = [];

    /**
     * @var Money|null
     */
    private $appliedMoney;

    /**
     * @var string|null
     */
    private $scope;

    /**
     * Returns Uid.
     * A unique ID that identifies the returned tax only within this order.
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
     * A unique ID that identifies the returned tax only within this order.
     *
     * @maps uid
     */
    public function setUid(?string $uid): void
    {
        $this->uid['value'] = $uid;
    }

    /**
     * Unsets Uid.
     * A unique ID that identifies the returned tax only within this order.
     */
    public function unsetUid(): void
    {
        $this->uid = [];
    }

    /**
     * Returns Source Tax Uid.
     * The tax `uid` from the order that contains the original tax charge.
     */
    public function getSourceTaxUid(): ?string
    {
        if (count($this->sourceTaxUid) == 0) {
            return null;
        }
        return $this->sourceTaxUid['value'];
    }

    /**
     * Sets Source Tax Uid.
     * The tax `uid` from the order that contains the original tax charge.
     *
     * @maps source_tax_uid
     */
    public function setSourceTaxUid(?string $sourceTaxUid): void
    {
        $this->sourceTaxUid['value'] = $sourceTaxUid;
    }

    /**
     * Unsets Source Tax Uid.
     * The tax `uid` from the order that contains the original tax charge.
     */
    public function unsetSourceTaxUid(): void
    {
        $this->sourceTaxUid = [];
    }

    /**
     * Returns Catalog Object Id.
     * The catalog object ID referencing [CatalogTax](entity:CatalogTax).
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
     * The catalog object ID referencing [CatalogTax](entity:CatalogTax).
     *
     * @maps catalog_object_id
     */
    public function setCatalogObjectId(?string $catalogObjectId): void
    {
        $this->catalogObjectId['value'] = $catalogObjectId;
    }

    /**
     * Unsets Catalog Object Id.
     * The catalog object ID referencing [CatalogTax](entity:CatalogTax).
     */
    public function unsetCatalogObjectId(): void
    {
        $this->catalogObjectId = [];
    }

    /**
     * Returns Catalog Version.
     * The version of the catalog object that this tax references.
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
     * The version of the catalog object that this tax references.
     *
     * @maps catalog_version
     */
    public function setCatalogVersion(?int $catalogVersion): void
    {
        $this->catalogVersion['value'] = $catalogVersion;
    }

    /**
     * Unsets Catalog Version.
     * The version of the catalog object that this tax references.
     */
    public function unsetCatalogVersion(): void
    {
        $this->catalogVersion = [];
    }

    /**
     * Returns Name.
     * The tax's name.
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
     * The tax's name.
     *
     * @maps name
     */
    public function setName(?string $name): void
    {
        $this->name['value'] = $name;
    }

    /**
     * Unsets Name.
     * The tax's name.
     */
    public function unsetName(): void
    {
        $this->name = [];
    }

    /**
     * Returns Type.
     * Indicates how the tax is applied to the associated line item or order.
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * Sets Type.
     * Indicates how the tax is applied to the associated line item or order.
     *
     * @maps type
     */
    public function setType(?string $type): void
    {
        $this->type = $type;
    }

    /**
     * Returns Percentage.
     * The percentage of the tax, as a string representation of a decimal number.
     * For example, a value of `"7.25"` corresponds to a percentage of 7.25%.
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
     * The percentage of the tax, as a string representation of a decimal number.
     * For example, a value of `"7.25"` corresponds to a percentage of 7.25%.
     *
     * @maps percentage
     */
    public function setPercentage(?string $percentage): void
    {
        $this->percentage['value'] = $percentage;
    }

    /**
     * Unsets Percentage.
     * The percentage of the tax, as a string representation of a decimal number.
     * For example, a value of `"7.25"` corresponds to a percentage of 7.25%.
     */
    public function unsetPercentage(): void
    {
        $this->percentage = [];
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
     * Returns Scope.
     * Indicates whether this is a line-item or order-level tax.
     */
    public function getScope(): ?string
    {
        return $this->scope;
    }

    /**
     * Sets Scope.
     * Indicates whether this is a line-item or order-level tax.
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
        if (!empty($this->sourceTaxUid)) {
            $json['source_tax_uid']    = $this->sourceTaxUid['value'];
        }
        if (!empty($this->catalogObjectId)) {
            $json['catalog_object_id'] = $this->catalogObjectId['value'];
        }
        if (!empty($this->catalogVersion)) {
            $json['catalog_version']   = $this->catalogVersion['value'];
        }
        if (!empty($this->name)) {
            $json['name']              = $this->name['value'];
        }
        if (isset($this->type)) {
            $json['type']              = $this->type;
        }
        if (!empty($this->percentage)) {
            $json['percentage']        = $this->percentage['value'];
        }
        if (isset($this->appliedMoney)) {
            $json['applied_money']     = $this->appliedMoney;
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
