<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CatalogInfoResponseLimits;

/**
 * Builder for model CatalogInfoResponseLimits
 *
 * @see CatalogInfoResponseLimits
 */
class CatalogInfoResponseLimitsBuilder
{
    /**
     * @var CatalogInfoResponseLimits
     */
    private $instance;

    private function __construct(CatalogInfoResponseLimits $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new catalog info response limits Builder object.
     */
    public static function init(): self
    {
        return new self(new CatalogInfoResponseLimits());
    }

    /**
     * Sets batch upsert max objects per batch field.
     */
    public function batchUpsertMaxObjectsPerBatch(?int $value): self
    {
        $this->instance->setBatchUpsertMaxObjectsPerBatch($value);
        return $this;
    }

    /**
     * Unsets batch upsert max objects per batch field.
     */
    public function unsetBatchUpsertMaxObjectsPerBatch(): self
    {
        $this->instance->unsetBatchUpsertMaxObjectsPerBatch();
        return $this;
    }

    /**
     * Sets batch upsert max total objects field.
     */
    public function batchUpsertMaxTotalObjects(?int $value): self
    {
        $this->instance->setBatchUpsertMaxTotalObjects($value);
        return $this;
    }

    /**
     * Unsets batch upsert max total objects field.
     */
    public function unsetBatchUpsertMaxTotalObjects(): self
    {
        $this->instance->unsetBatchUpsertMaxTotalObjects();
        return $this;
    }

    /**
     * Sets batch retrieve max object ids field.
     */
    public function batchRetrieveMaxObjectIds(?int $value): self
    {
        $this->instance->setBatchRetrieveMaxObjectIds($value);
        return $this;
    }

    /**
     * Unsets batch retrieve max object ids field.
     */
    public function unsetBatchRetrieveMaxObjectIds(): self
    {
        $this->instance->unsetBatchRetrieveMaxObjectIds();
        return $this;
    }

    /**
     * Sets search max page limit field.
     */
    public function searchMaxPageLimit(?int $value): self
    {
        $this->instance->setSearchMaxPageLimit($value);
        return $this;
    }

    /**
     * Unsets search max page limit field.
     */
    public function unsetSearchMaxPageLimit(): self
    {
        $this->instance->unsetSearchMaxPageLimit();
        return $this;
    }

    /**
     * Sets batch delete max object ids field.
     */
    public function batchDeleteMaxObjectIds(?int $value): self
    {
        $this->instance->setBatchDeleteMaxObjectIds($value);
        return $this;
    }

    /**
     * Unsets batch delete max object ids field.
     */
    public function unsetBatchDeleteMaxObjectIds(): self
    {
        $this->instance->unsetBatchDeleteMaxObjectIds();
        return $this;
    }

    /**
     * Sets update item taxes max item ids field.
     */
    public function updateItemTaxesMaxItemIds(?int $value): self
    {
        $this->instance->setUpdateItemTaxesMaxItemIds($value);
        return $this;
    }

    /**
     * Unsets update item taxes max item ids field.
     */
    public function unsetUpdateItemTaxesMaxItemIds(): self
    {
        $this->instance->unsetUpdateItemTaxesMaxItemIds();
        return $this;
    }

    /**
     * Sets update item taxes max taxes to enable field.
     */
    public function updateItemTaxesMaxTaxesToEnable(?int $value): self
    {
        $this->instance->setUpdateItemTaxesMaxTaxesToEnable($value);
        return $this;
    }

    /**
     * Unsets update item taxes max taxes to enable field.
     */
    public function unsetUpdateItemTaxesMaxTaxesToEnable(): self
    {
        $this->instance->unsetUpdateItemTaxesMaxTaxesToEnable();
        return $this;
    }

    /**
     * Sets update item taxes max taxes to disable field.
     */
    public function updateItemTaxesMaxTaxesToDisable(?int $value): self
    {
        $this->instance->setUpdateItemTaxesMaxTaxesToDisable($value);
        return $this;
    }

    /**
     * Unsets update item taxes max taxes to disable field.
     */
    public function unsetUpdateItemTaxesMaxTaxesToDisable(): self
    {
        $this->instance->unsetUpdateItemTaxesMaxTaxesToDisable();
        return $this;
    }

    /**
     * Sets update item modifier lists max item ids field.
     */
    public function updateItemModifierListsMaxItemIds(?int $value): self
    {
        $this->instance->setUpdateItemModifierListsMaxItemIds($value);
        return $this;
    }

    /**
     * Unsets update item modifier lists max item ids field.
     */
    public function unsetUpdateItemModifierListsMaxItemIds(): self
    {
        $this->instance->unsetUpdateItemModifierListsMaxItemIds();
        return $this;
    }

    /**
     * Sets update item modifier lists max modifier lists to enable field.
     */
    public function updateItemModifierListsMaxModifierListsToEnable(?int $value): self
    {
        $this->instance->setUpdateItemModifierListsMaxModifierListsToEnable($value);
        return $this;
    }

    /**
     * Unsets update item modifier lists max modifier lists to enable field.
     */
    public function unsetUpdateItemModifierListsMaxModifierListsToEnable(): self
    {
        $this->instance->unsetUpdateItemModifierListsMaxModifierListsToEnable();
        return $this;
    }

    /**
     * Sets update item modifier lists max modifier lists to disable field.
     */
    public function updateItemModifierListsMaxModifierListsToDisable(?int $value): self
    {
        $this->instance->setUpdateItemModifierListsMaxModifierListsToDisable($value);
        return $this;
    }

    /**
     * Unsets update item modifier lists max modifier lists to disable field.
     */
    public function unsetUpdateItemModifierListsMaxModifierListsToDisable(): self
    {
        $this->instance->unsetUpdateItemModifierListsMaxModifierListsToDisable();
        return $this;
    }

    /**
     * Initializes a new catalog info response limits object.
     */
    public function build(): CatalogInfoResponseLimits
    {
        return CoreHelper::clone($this->instance);
    }
}
