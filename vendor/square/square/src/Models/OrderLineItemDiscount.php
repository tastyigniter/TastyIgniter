<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents a discount that applies to one or more line items in an
 * order.
 *
 * Fixed-amount, order-scoped discounts are distributed across all non-zero line item totals.
 * The amount distributed to each line item is relative to the
 * amount contributed by the item to the order subtotal.
 */
class OrderLineItemDiscount implements \JsonSerializable
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
     * @var Money|null
     */
    private $amountMoney;

    /**
     * @var Money|null
     */
    private $appliedMoney;

    /**
     * @var array
     */
    private $metadata = [];

    /**
     * @var string|null
     */
    private $scope;

    /**
     * @var string[]|null
     */
    private $rewardIds;

    /**
     * @var string|null
     */
    private $pricingRuleId;

    /**
     * Returns Uid.
     * A unique ID that identifies the discount only within this order.
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
     * A unique ID that identifies the discount only within this order.
     *
     * @maps uid
     */
    public function setUid(?string $uid): void
    {
        $this->uid['value'] = $uid;
    }

    /**
     * Unsets Uid.
     * A unique ID that identifies the discount only within this order.
     */
    public function unsetUid(): void
    {
        $this->uid = [];
    }

    /**
     * Returns Catalog Object Id.
     * The catalog object ID referencing [CatalogDiscount](entity:CatalogDiscount).
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
     * The catalog object ID referencing [CatalogDiscount](entity:CatalogDiscount).
     *
     * @maps catalog_object_id
     */
    public function setCatalogObjectId(?string $catalogObjectId): void
    {
        $this->catalogObjectId['value'] = $catalogObjectId;
    }

    /**
     * Unsets Catalog Object Id.
     * The catalog object ID referencing [CatalogDiscount](entity:CatalogDiscount).
     */
    public function unsetCatalogObjectId(): void
    {
        $this->catalogObjectId = [];
    }

    /**
     * Returns Catalog Version.
     * The version of the catalog object that this discount references.
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
     * The version of the catalog object that this discount references.
     *
     * @maps catalog_version
     */
    public function setCatalogVersion(?int $catalogVersion): void
    {
        $this->catalogVersion['value'] = $catalogVersion;
    }

    /**
     * Unsets Catalog Version.
     * The version of the catalog object that this discount references.
     */
    public function unsetCatalogVersion(): void
    {
        $this->catalogVersion = [];
    }

    /**
     * Returns Name.
     * The discount's name.
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
     * The discount's name.
     *
     * @maps name
     */
    public function setName(?string $name): void
    {
        $this->name['value'] = $name;
    }

    /**
     * Unsets Name.
     * The discount's name.
     */
    public function unsetName(): void
    {
        $this->name = [];
    }

    /**
     * Returns Type.
     * Indicates how the discount is applied to the associated line item or order.
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * Sets Type.
     * Indicates how the discount is applied to the associated line item or order.
     *
     * @maps type
     */
    public function setType(?string $type): void
    {
        $this->type = $type;
    }

    /**
     * Returns Percentage.
     * The percentage of the discount, as a string representation of a decimal number.
     * A value of `7.25` corresponds to a percentage of 7.25%.
     *
     * `percentage` is not set for amount-based discounts.
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
     * The percentage of the discount, as a string representation of a decimal number.
     * A value of `7.25` corresponds to a percentage of 7.25%.
     *
     * `percentage` is not set for amount-based discounts.
     *
     * @maps percentage
     */
    public function setPercentage(?string $percentage): void
    {
        $this->percentage['value'] = $percentage;
    }

    /**
     * Unsets Percentage.
     * The percentage of the discount, as a string representation of a decimal number.
     * A value of `7.25` corresponds to a percentage of 7.25%.
     *
     * `percentage` is not set for amount-based discounts.
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
     * Returns Metadata.
     * Application-defined data attached to this discount. Metadata fields are intended
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
     * Application-defined data attached to this discount. Metadata fields are intended
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
     * Application-defined data attached to this discount. Metadata fields are intended
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
     * Returns Scope.
     * Indicates whether this is a line-item or order-level discount.
     */
    public function getScope(): ?string
    {
        return $this->scope;
    }

    /**
     * Sets Scope.
     * Indicates whether this is a line-item or order-level discount.
     *
     * @maps scope
     */
    public function setScope(?string $scope): void
    {
        $this->scope = $scope;
    }

    /**
     * Returns Reward Ids.
     * The reward IDs corresponding to this discount. The application and
     * specification of discounts that have `reward_ids` are completely controlled by the backing
     * criteria corresponding to the reward tiers of the rewards that are added to the order
     * through the Loyalty API. To manually unapply discounts that are the result of added rewards,
     * the rewards must be removed from the order through the Loyalty API.
     *
     * @return string[]|null
     */
    public function getRewardIds(): ?array
    {
        return $this->rewardIds;
    }

    /**
     * Sets Reward Ids.
     * The reward IDs corresponding to this discount. The application and
     * specification of discounts that have `reward_ids` are completely controlled by the backing
     * criteria corresponding to the reward tiers of the rewards that are added to the order
     * through the Loyalty API. To manually unapply discounts that are the result of added rewards,
     * the rewards must be removed from the order through the Loyalty API.
     *
     * @maps reward_ids
     *
     * @param string[]|null $rewardIds
     */
    public function setRewardIds(?array $rewardIds): void
    {
        $this->rewardIds = $rewardIds;
    }

    /**
     * Returns Pricing Rule Id.
     * The object ID of a [pricing rule](entity:CatalogPricingRule) to be applied
     * automatically to this discount. The specification and application of the discounts, to
     * which a `pricing_rule_id` is assigned, are completely controlled by the corresponding
     * pricing rule.
     */
    public function getPricingRuleId(): ?string
    {
        return $this->pricingRuleId;
    }

    /**
     * Sets Pricing Rule Id.
     * The object ID of a [pricing rule](entity:CatalogPricingRule) to be applied
     * automatically to this discount. The specification and application of the discounts, to
     * which a `pricing_rule_id` is assigned, are completely controlled by the corresponding
     * pricing rule.
     *
     * @maps pricing_rule_id
     */
    public function setPricingRuleId(?string $pricingRuleId): void
    {
        $this->pricingRuleId = $pricingRuleId;
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
        if (isset($this->amountMoney)) {
            $json['amount_money']      = $this->amountMoney;
        }
        if (isset($this->appliedMoney)) {
            $json['applied_money']     = $this->appliedMoney;
        }
        if (!empty($this->metadata)) {
            $json['metadata']          = $this->metadata['value'];
        }
        if (isset($this->scope)) {
            $json['scope']             = $this->scope;
        }
        if (isset($this->rewardIds)) {
            $json['reward_ids']        = $this->rewardIds;
        }
        if (isset($this->pricingRuleId)) {
            $json['pricing_rule_id']   = $this->pricingRuleId;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
