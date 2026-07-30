<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\BatchRetrieveCatalogObjectsRequest;

/**
 * Builder for model BatchRetrieveCatalogObjectsRequest
 *
 * @see BatchRetrieveCatalogObjectsRequest
 */
class BatchRetrieveCatalogObjectsRequestBuilder
{
    /**
     * @var BatchRetrieveCatalogObjectsRequest
     */
    private $instance;

    private function __construct(BatchRetrieveCatalogObjectsRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new batch retrieve catalog objects request Builder object.
     */
    public static function init(array $objectIds): self
    {
        return new self(new BatchRetrieveCatalogObjectsRequest($objectIds));
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
     * Sets include deleted objects field.
     */
    public function includeDeletedObjects(?bool $value): self
    {
        $this->instance->setIncludeDeletedObjects($value);
        return $this;
    }

    /**
     * Unsets include deleted objects field.
     */
    public function unsetIncludeDeletedObjects(): self
    {
        $this->instance->unsetIncludeDeletedObjects();
        return $this;
    }

    /**
     * Initializes a new batch retrieve catalog objects request object.
     */
    public function build(): BatchRetrieveCatalogObjectsRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
