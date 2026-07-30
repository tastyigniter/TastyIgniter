<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\SearchCatalogItemsResponse;

/**
 * Builder for model SearchCatalogItemsResponse
 *
 * @see SearchCatalogItemsResponse
 */
class SearchCatalogItemsResponseBuilder
{
    /**
     * @var SearchCatalogItemsResponse
     */
    private $instance;

    private function __construct(SearchCatalogItemsResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new search catalog items response Builder object.
     */
    public static function init(): self
    {
        return new self(new SearchCatalogItemsResponse());
    }

    /**
     * Sets errors field.
     */
    public function errors(?array $value): self
    {
        $this->instance->setErrors($value);
        return $this;
    }

    /**
     * Sets items field.
     */
    public function items(?array $value): self
    {
        $this->instance->setItems($value);
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
     * Sets matched variation ids field.
     */
    public function matchedVariationIds(?array $value): self
    {
        $this->instance->setMatchedVariationIds($value);
        return $this;
    }

    /**
     * Initializes a new search catalog items response object.
     */
    public function build(): SearchCatalogItemsResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
