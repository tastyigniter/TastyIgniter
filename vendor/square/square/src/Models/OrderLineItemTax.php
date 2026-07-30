<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents a tax that applies to one or more line item in the order.
 *
 * Fixed-amount, order-scoped taxes are distributed across all non-zero line item totals.
 * The amount distributed to each line item is relative to the amount the item
 * contributes to the order subtotal.
 */
class OrderLineItemTax implements \JsonSerializable
{
    /**
     * @var array
     */
    private $uid = [];

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
     * @var array
     */
    private $metadata = [];

    /**
     * @var Money|null
     */
    private $appliedMoney;

    /**
     * @var string|null
     */
    private $scope;

    /**
     * @var bool|null
     */
    private $autoApplied;

    /**
     * Returns Uid.
     * A unique ID that identifies the tax only within this order.
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
     * A unique ID that identifies the tax only within this order.
     *
     * @maps uid
     */
    public function setUid(?string $uid): void
    {
        $this->uid['value'] = $uid;
    }

    /**
     * Unsets Uid.
     * A unique ID that identifies the tax only within this order.
     */
    public function unsetUid(): void
    {
        $this->uid = [];
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
     * The percentage of the tax, as a string representation of a decimal
     * number. For example, a value of `"7.25"` corresponds to a percentage of
     * 7.25%.
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
     * The percentage of the tax, as a string representation of a decimal
     * number. For example, a value of `"7.25"` corresponds to a percentage of
     * 7.25%.
     *
     * @maps percentage
     */
    public function setPercentage(?string $percentage): void
    {
        $this->percentage['value'] = $percentage;
    }

    /**
     * Unsets Percentage.
     * The percentage of the tax, as a string representation of a decimal
     * number. For example, a value of `"7.25"` corresponds to a percentage of
     * 7.25%.
     */
    public function unsetPercentage(): void
    {
        $this->percentage = [];
    }

    /**
     * Returns Metadata.
     * Application-defined data attached to this tax. Metadata fields are intended
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
     * Application-defined data attached to this tax. Metadata fields are intended
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
     * Application-defined data attached to this tax. Metadata fields are intended
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
     * Returns Auto Applied.
     * Determines whether the tax was automatically applied to the order based on
     * the catalog configuration. For an example, see
     * [Automatically Apply Taxes to an Order](https://developer.squareup.com/docs/orders-api/apply-taxes-
     * and-discounts/auto-apply-taxes).
     */
    public function getAutoApplied(): ?bool
    {
        return $this->autoApplied;
    }

    /**
     * Sets Auto Applied.
     * Determines whether the tax was automatically applied to the order based on
     * the catalog configuration. For an example, see
     * [Automatically Apply Taxes to an Order](https://developer.squareup.com/docs/orders-api/apply-taxes-
     * and-discounts/auto-apply-taxes).
     *
     * @maps auto_applied
     */
    public function setAutoApplied(?bool $autoApplied): void
    {
        $this->autoApplied = $autoApplied;
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
        if (!empty($this->metadata)) {
            $json['metadata']          = $this->metadata['value'];
        }
        if (isset($this->appliedMoney)) {
            $json['applied_money']     = $this->appliedMoney;
        }
        if (isset($this->scope)) {
            $json['scope']             = $this->scope;
        }
        if (isset($this->autoApplied)) {
            $json['auto_applied']      = $this->autoApplied;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
