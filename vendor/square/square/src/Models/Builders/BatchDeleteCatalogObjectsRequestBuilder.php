<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\BatchDeleteCatalogObjectsRequest;

/**
 * Builder for model BatchDeleteCatalogObjectsRequest
 *
 * @see BatchDeleteCatalogObjectsRequest
 */
class BatchDeleteCatalogObjectsRequestBuilder
{
    /**
     * @var BatchDeleteCatalogObjectsRequest
     */
    private $instance;

    private function __construct(BatchDeleteCatalogObjectsRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new batch delete catalog objects request Builder object.
     */
    public static function init(): self
    {
        return new self(new BatchDeleteCatalogObjectsRequest());
    }

    /**
     * Sets object ids field.
     */
    public function objectIds(?array $value): self
    {
        $this->instance->setObjectIds($value);
        return $this;
    }

    /**
     * Unsets object ids field.
     */
    public function unsetObjectIds(): self
    {
        $this->instance->unsetObjectIds();
        return $this;
    }

    /**
     * Initializes a new batch delete catalog objects request object.
     */
    public function build(): BatchDeleteCatalogObjectsRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
