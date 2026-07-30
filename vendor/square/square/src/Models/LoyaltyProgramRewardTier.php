<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents a reward tier in a loyalty program. A reward tier defines how buyers can redeem points
 * for a reward, such as the number of points required and the value and scope of the discount. A
 * loyalty program can offer multiple reward tiers.
 */
class LoyaltyProgramRewardTier implements \JsonSerializable
{
    /**
     * @var string|null
     */
    private $id;

    /**
     * @var int
     */
    private $points;

    /**
     * @var string|null
     */
    private $name;

    /**
     * @var LoyaltyProgramRewardDefinition|null
     */
    private $definition;

    /**
     * @var string|null
     */
    private $createdAt;

    /**
     * @var CatalogObjectReference
     */
    private $pricingRuleReference;

    /**
     * @param int $points
     * @param CatalogObjectReference $pricingRuleReference
     */
    public function __construct(int $points, CatalogObjectReference $pricingRuleReference)
    {
        $this->points = $points;
        $this->pricingRuleReference = $pricingRuleReference;
    }

    /**
     * Returns Id.
     * The Square-assigned ID of the reward tier.
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Sets Id.
     * The Square-assigned ID of the reward tier.
     *
     * @maps id
     */
    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    /**
     * Returns Points.
     * The points exchanged for the reward tier.
     */
    public function getPoints(): int
    {
        return $this->points;
    }

    /**
     * Sets Points.
     * The points exchanged for the reward tier.
     *
     * @required
     * @maps points
     */
    public function setPoints(int $points): void
    {
        $this->points = $points;
    }

    /**
     * Returns Name.
     * The name of the reward tier.
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Sets Name.
     * The name of the reward tier.
     *
     * @maps name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * Returns Definition.
     * Provides details about the reward tier discount. DEPRECATED at version 2020-12-16. Discount details
     * are now defined using a catalog pricing rule and other catalog objects. For more information, see
     * [Getting discount details for a reward tier](https://developer.squareup.com/docs/loyalty-api/loyalty-
     * rewards#get-discount-details).
     */
    public function getDefinition(): ?LoyaltyProgramRewardDefinition
    {
        return $this->definition;
    }

    /**
     * Sets Definition.
     * Provides details about the reward tier discount. DEPRECATED at version 2020-12-16. Discount details
     * are now defined using a catalog pricing rule and other catalog objects. For more information, see
     * [Getting discount details for a reward tier](https://developer.squareup.com/docs/loyalty-api/loyalty-
     * rewards#get-discount-details).
     *
     * @maps definition
     */
    public function setDefinition(?LoyaltyProgramRewardDefinition $definition): void
    {
        $this->definition = $definition;
    }

    /**
     * Returns Created At.
     * The timestamp when the reward tier was created, in RFC 3339 format.
     */
    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    /**
     * Sets Created At.
     * The timestamp when the reward tier was created, in RFC 3339 format.
     *
     * @maps created_at
     */
    public function setCreatedAt(?string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Returns Pricing Rule Reference.
     * A reference to a Catalog object at a specific version. In general this is
     * used as an entry point into a graph of catalog objects, where the objects exist
     * at a specific version.
     */
    public function getPricingRuleReference(): CatalogObjectReference
    {
        return $this->pricingRuleReference;
    }

    /**
     * Sets Pricing Rule Reference.
     * A reference to a Catalog object at a specific version. In general this is
     * used as an entry point into a graph of catalog objects, where the objects exist
     * at a specific version.
     *
     * @required
     * @maps pricing_rule_reference
     */
    public function setPricingRuleReference(CatalogObjectReference $pricingRuleReference): void
    {
        $this->pricingRuleReference = $pricingRuleReference;
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
        if (isset($this->id)) {
            $json['id']                 = $this->id;
        }
        $json['points']                 = $this->points;
        if (isset($this->name)) {
            $json['name']               = $this->name;
        }
        if (isset($this->definition)) {
            $json['definition']         = $this->definition;
        }
        if (isset($this->createdAt)) {
            $json['created_at']         = $this->createdAt;
        }
        $json['pricing_rule_reference'] = $this->pricingRuleReference;
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
