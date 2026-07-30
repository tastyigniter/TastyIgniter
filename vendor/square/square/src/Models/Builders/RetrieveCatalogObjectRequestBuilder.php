<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\RetrieveCatalogObjectRequest;

/**
 * Builder for model RetrieveCatalogObjectRequest
 *
 * @see RetrieveCatalogObjectRequest
 */
class RetrieveCatalogObjectRequestBuilder
{
    /**
     * @var RetrieveCatalogObjectRequest
     */
    private $instance;

    private function __construct(RetrieveCatalogObjectRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new retrieve catalog object request Builder object.
     */
    public static function init(): self
    {
        return new self(new RetrieveCatalogObjectRequest());
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
     * Unsets include related objects field.
     */
    public function unsetIncludeRelatedObjects(): self
    {
        $this->instance->unsetIncludeRelatedObjects();
        return $this;
    }

    /**
     * Sets catalog version field.
     */
    public function catalogVersion(?int $value): self
    {
        $this->instance->setCatalogVersion($value);
        return $this;
    }

    /**
     * Unsets catalog version field.
     */
    public function unsetCatalogVersion(): self
    {
        $this->instance->unsetCatalogVersion();
        return $this;
    }

    /**
     * Initializes a new retrieve catalog object request object.
     */
    public function build(): RetrieveCatalogObjectRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
