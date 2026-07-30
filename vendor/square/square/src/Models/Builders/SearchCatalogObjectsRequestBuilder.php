<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CatalogQuery;
use Square\Models\SearchCatalogObjectsRequest;

/**
 * Builder for model SearchCatalogObjectsRequest
 *
 * @see SearchCatalogObjectsRequest
 */
class SearchCatalogObjectsRequestBuilder
{
    /**
     * @var SearchCatalogObjectsRequest
     */
    private $instance;

    private function __construct(SearchCatalogObjectsRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new search catalog objects request Builder object.
     */
    public static function init(): self
    {
        return new self(new SearchCatalogObjectsRequest());
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
     * Sets object types field.
     */
    public function objectTypes(?array $value): self
    {
        $this->instance->setObjectTypes($value);
        return $this;
    }

    /**
     * Sets include deleted objects field.
     */
    public function includeDeletedObjects(?bool $value): self
    {
        $this->instance->setIncludeDeletedObjects($value);
        return $this;
    }

    /**
     * Sets include related objects field.
     */
    public function includeRelatedObjects(?bool $value): self
    {
        $this->instance->setIncludeRelatedObjects($value);
        return $this;
    }

    /**
     * Sets begin time field.
     */
    public function beginTime(?string $value): self
    {
        $this->instance->setBeginTime($value);
        return $this;
    }

    /**
     * Sets query field.
     */
    public function query(?CatalogQuery $value): self
    {
        $this->instance->setQuery($value);
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
     * Initializes a new search catalog objects request object.
     */
    public function build(): SearchCatalogObjectsRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
