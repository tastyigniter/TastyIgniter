<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\SearchCatalogItemsRequest;

/**
 * Builder for model SearchCatalogItemsRequest
 *
 * @see SearchCatalogItemsRequest
 */
class SearchCatalogItemsRequestBuilder
{
    /**
     * @var SearchCatalogItemsRequest
     */
    private $instance;

    private function __construct(SearchCatalogItemsRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new search catalog items request Builder object.
     */
    public static function init(): self
    {
        return new self(new SearchCatalogItemsRequest());
    }

    /**
     * Sets text filter field.
     */
    public function textFilter(?string $value): self
    {
        $this->instance->setTextFilter($value);
        return $this;
    }

    /**
     * Sets category ids field.
     */
    public function categoryIds(?array $value): self
    {
        $this->instance->setCategoryIds($value);
        return $this;
    }

    /**
     * Sets stock levels field.
     */
    public function stockLevels(?array $value): self
    {
        $this->instance->setStockLevels($value);
        return $this;
    }

    /**
     * Sets enabled location ids field.
     */
    public function enabledLocationIds(?array $value): self
    {
        $this->instance->setEnabledLocationIds($value);
        return $this;
    }

    /**
     * Sets cursor field.
     */
    public function cursor(?string $value): self
    {
        $this->instance->setCursor($value);
        return $this;
    }

    /**
     * Sets limit field.
     */
    public function limit(?int $value): self
    {
        $this->instance->setLimit($value);
        return $this;
    }

    /**
     * Sets sort order field.
     */
    public function sortOrder(?string $value): self
    {
        $this->instance->setSortOrder($value);
        return $this;
    }

    /**
     * Sets product types field.
     */
    public function productTypes(?array $value): self
    {
        $this->instance->setProductTypes($value);
        return $this;
    }

    /**
     * Sets custom attribute filters field.
     */
    public function customAttributeFilters(?array $value): self
    {
        $this->instance->setCustomAttributeFilters($value);
        return $this;
    }

    /**
     * Initializes a new search catalog items request object.
     */
    public function build(): SearchCatalogItemsRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
