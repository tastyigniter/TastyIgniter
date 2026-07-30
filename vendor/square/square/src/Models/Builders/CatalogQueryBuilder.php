<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CatalogQuery;
use Square\Models\CatalogQueryExact;
use Square\Models\CatalogQueryItemsForItemOptions;
use Square\Models\CatalogQueryItemsForModifierList;
use Square\Models\CatalogQueryItemsForTax;
use Square\Models\CatalogQueryItemVariationsForItemOptionValues;
use Square\Models\CatalogQueryPrefix;
use Square\Models\CatalogQueryRange;
use Square\Models\CatalogQuerySet;
use Square\Models\CatalogQuerySortedAttribute;
use Square\Models\CatalogQueryText;

/**
 * Builder for model CatalogQuery
 *
 * @see CatalogQuery
 */
class CatalogQueryBuilder
{
    /**
     * @var CatalogQuery
     */
    private $instance;

    private function __construct(CatalogQuery $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new catalog query Builder object.
     */
    public static function init(): self
    {
        return new self(new CatalogQuery());
    }

    /**
     * Sets sorted attribute query field.
     */
    public function sortedAttributeQuery(?CatalogQuerySortedAttribute $value): self
    {
        $this->instance->setSortedAttributeQuery($value);
        return $this;
    }

    /**
     * Sets exact query field.
     */
    public function exactQuery(?CatalogQueryExact $value): self
    {
        $this->instance->setExactQuery($value);
        return $this;
    }

    /**
     * Sets set query field.
     */
    public function setQuery(?CatalogQuerySet $value): self
    {
        $this->instance->setSetQuery($value);
        return $this;
    }

    /**
     * Sets prefix query field.
     */
    public function prefixQuery(?CatalogQueryPrefix $value): self
    {
        $this->instance->setPrefixQuery($value);
        return $this;
    }

    /**
     * Sets range query field.
     */
    public function rangeQuery(?CatalogQueryRange $value): self
    {
        $this->instance->setRangeQuery($value);
        return $this;
    }

    /**
     * Sets text query field.
     */
    public function textQuery(?CatalogQueryText $value): self
    {
        $this->instance->setTextQuery($value);
        return $this;
    }

    /**
     * Sets items for tax query field.
     */
    public function itemsForTaxQuery(?CatalogQueryItemsForTax $value): self
    {
        $this->instance->setItemsForTaxQuery($value);
        return $this;
    }

    /**
     * Sets items for modifier list query field.
     */
    public function itemsForModifierListQuery(?CatalogQueryItemsForModifierList $value): self
    {
        $this->instance->setItemsForModifierListQuery($value);
        return $this;
    }

    /**
     * Sets items for item options query field.
     */
    public function itemsForItemOptionsQuery(?CatalogQueryItemsForItemOptions $value): self
    {
        $this->instance->setItemsForItemOptionsQuery($value);
        return $this;
    }

    /**
     * Sets item variations for item option values query field.
     */
    public function itemVariationsForItemOptionValuesQuery(?CatalogQueryItemVariationsForItemOptionValues $value): self
    {
        $this->instance->setItemVariationsForItemOptionValuesQuery($value);
        return $this;
    }

    /**
     * Initializes a new catalog query object.
     */
    public function build(): CatalogQuery
    {
        return CoreHelper::clone($this->instance);
    }
}
