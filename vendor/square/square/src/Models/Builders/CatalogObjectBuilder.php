<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CatalogCategory;
use Square\Models\CatalogCustomAttributeDefinition;
use Square\Models\CatalogDiscount;
use Square\Models\CatalogImage;
use Square\Models\CatalogItem;
use Square\Models\CatalogItemOption;
use Square\Models\CatalogItemOptionValue;
use Square\Models\CatalogItemVariation;
use Square\Models\CatalogMeasurementUnit;
use Square\Models\CatalogModifier;
use Square\Models\CatalogModifierList;
use Square\Models\CatalogObject;
use Square\Models\CatalogPricingRule;
use Square\Models\CatalogProductSet;
use Square\Models\CatalogQuickAmountsSettings;
use Square\Models\CatalogSubscriptionPlan;
use Square\Models\CatalogTax;
use Square\Models\CatalogTimePeriod;

/**
 * Builder for model CatalogObject
 *
 * @see CatalogObject
 */
class CatalogObjectBuilder
{
    /**
     * @var CatalogObject
     */
    private $instance;

    private function __construct(CatalogObject $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new catalog object Builder object.
     */
    public static function init(string $type, string $id): self
    {
        return new self(new CatalogObject($type, $id));
    }

    /**
     * Sets updated at field.
     */
    public function updatedAt(?string $value): self
    {
        $this->instance->setUpdatedAt($value);
        return $this;
    }

    /**
     * Sets version field.
     */
    public function version(?int $value): self
    {
        $this->instance->setVersion($value);
        return $this;
    }

    /**
     * Sets is deleted field.
     */
    public function isDeleted(?bool $value): self
    {
        $this->instance->setIsDeleted($value);
        return $this;
    }

    /**
     * Unsets is deleted field.
     */
    public function unsetIsDeleted(): self
    {
        $this->instance->unsetIsDeleted();
        return $this;
    }

    /**
     * Sets custom attribute values field.
     */
    public function customAttributeValues(?array $value): self
    {
        $this->instance->setCustomAttributeValues($value);
        return $this;
    }

    /**
     * Unsets custom attribute values field.
     */
    public function unsetCustomAttributeValues(): self
    {
        $this->instance->unsetCustomAttributeValues();
        return $this;
    }

    /**
     * Sets catalog v 1 ids field.
     */
    public function catalogV1Ids(?array $value): self
    {
        $this->instance->setCatalogV1Ids($value);
        return $this;
    }

    /**
     * Unsets catalog v 1 ids field.
     */
    public function unsetCatalogV1Ids(): self
    {
        $this->instance->unsetCatalogV1Ids();
        return $this;
    }

    /**
     * Sets present at all locations field.
     */
    public function presentAtAllLocations(?bool $value): self
    {
        $this->instance->setPresentAtAllLocations($value);
        return $this;
    }

    /**
     * Unsets present at all locations field.
     */
    public function unsetPresentAtAllLocations(): self
    {
        $this->instance->unsetPresentAtAllLocations();
        return $this;
    }

    /**
     * Sets present at location ids field.
     */
    public function presentAtLocationIds(?array $value): self
    {
        $this->instance->setPresentAtLocationIds($value);
        return $this;
    }

    /**
     * Unsets present at location ids field.
     */
    public function unsetPresentAtLocationIds(): self
    {
        $this->instance->unsetPresentAtLocationIds();
        return $this;
    }

    /**
     * Sets absent at location ids field.
     */
    public function absentAtLocationIds(?array $value): self
    {
        $this->instance->setAbsentAtLocationIds($value);
        return $this;
    }

    /**
     * Unsets absent at location ids field.
     */
    public function unsetAbsentAtLocationIds(): self
    {
        $this->instance->unsetAbsentAtLocationIds();
        return $this;
    }

    /**
     * Sets item data field.
     */
    public function itemData(?CatalogItem $value): self
    {
        $this->instance->setItemData($value);
        return $this;
    }

    /**
     * Sets category data field.
     */
    public function categoryData(?CatalogCategory $value): self
    {
        $this->instance->setCategoryData($value);
        return $this;
    }

    /**
     * Sets item variation data field.
     */
    public function itemVariationData(?CatalogItemVariation $value): self
    {
        $this->instance->setItemVariationData($value);
        return $this;
    }

    /**
     * Sets tax data field.
     */
    public function taxData(?CatalogTax $value): self
    {
        $this->instance->setTaxData($value);
        return $this;
    }

    /**
     * Sets discount data field.
     */
    public function discountData(?CatalogDiscount $value): self
    {
        $this->instance->setDiscountData($value);
        return $this;
    }

    /**
     * Sets modifier list data field.
     */
    public function modifierListData(?CatalogModifierList $value): self
    {
        $this->instance->setModifierListData($value);
        return $this;
    }

    /**
     * Sets modifier data field.
     */
    public function modifierData(?CatalogModifier $value): self
    {
        $this->instance->setModifierData($value);
        return $this;
    }

    /**
     * Sets time period data field.
     */
    public function timePeriodData(?CatalogTimePeriod $value): self
    {
        $this->instance->setTimePeriodData($value);
        return $this;
    }

    /**
     * Sets product set data field.
     */
    public function productSetData(?CatalogProductSet $value): self
    {
        $this->instance->setProductSetData($value);
        return $this;
    }

    /**
     * Sets pricing rule data field.
     */
    public function pricingRuleData(?CatalogPricingRule $value): self
    {
        $this->instance->setPricingRuleData($value);
        return $this;
    }

    /**
     * Sets image data field.
     */
    public function imageData(?CatalogImage $value): self
    {
        $this->instance->setImageData($value);
        return $this;
    }

    /**
     * Sets measurement unit data field.
     */
    public function measurementUnitData(?CatalogMeasurementUnit $value): self
    {
        $this->instance->setMeasurementUnitData($value);
        return $this;
    }

    /**
     * Sets subscription plan data field.
     */
    public function subscriptionPlanData(?CatalogSubscriptionPlan $value): self
    {
        $this->instance->setSubscriptionPlanData($value);
        return $this;
    }

    /**
     * Sets item option data field.
     */
    public function itemOptionData(?CatalogItemOption $value): self
    {
        $this->instance->setItemOptionData($value);
        return $this;
    }

    /**
     * Sets item option value data field.
     */
    public function itemOptionValueData(?CatalogItemOptionValue $value): self
    {
        $this->instance->setItemOptionValueData($value);
        return $this;
    }

    /**
     * Sets custom attribute definition data field.
     */
    public function customAttributeDefinitionData(?CatalogCustomAttributeDefinition $value): self
    {
        $this->instance->setCustomAttributeDefinitionData($value);
        return $this;
    }

    /**
     * Sets quick amounts settings data field.
     */
    public function quickAmountsSettingsData(?CatalogQuickAmountsSettings $value): self
    {
        $this->instance->setQuickAmountsSettingsData($value);
        return $this;
    }

    /**
     * Initializes a new catalog object object.
     */
    public function build(): CatalogObject
    {
        return CoreHelper::clone($this->instance);
    }
}
