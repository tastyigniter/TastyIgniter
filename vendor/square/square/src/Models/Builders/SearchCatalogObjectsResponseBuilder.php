<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\SearchCatalogObjectsResponse;

/**
 * Builder for model SearchCatalogObjectsResponse
 *
 * @see SearchCatalogObjectsResponse
 */
class SearchCatalogObjectsResponseBuilder
{
    /**
     * @var SearchCatalogObjectsResponse
     */
    private $instance;

    private function __construct(SearchCatalogObjectsResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new search catalog objects response Builder object.
     */
    public static function init(): self
    {
        return new self(new SearchCatalogObjectsResponse());
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
     * Sets cursor field.
     */
    public function cursor(?string $value): self
    {
        $this->instance->setCursor($value);
        return $this;
    }

    /**
     * Sets objects field.
     */
    public function objects(?array $value): self
    {
        $this->instance->setObjects($value);
        return $this;
    }

    /**
     * Sets related objects field.
     */
    public function relatedObjects(?array $value): self
    {
        $this->instance->setRelatedObjects($value);
        return $this;
    }

    /**
     * Sets latest time field.
     */
    public function latestTime(?string $value): self
    {
        $this->instance->setLatestTime($value);
        return $this;
    }

    /**
     * Initializes a new search catalog objects response object.
     */
    public function build(): SearchCatalogObjectsResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
