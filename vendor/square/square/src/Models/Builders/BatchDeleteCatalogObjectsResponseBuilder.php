<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\BatchDeleteCatalogObjectsResponse;

/**
 * Builder for model BatchDeleteCatalogObjectsResponse
 *
 * @see BatchDeleteCatalogObjectsResponse
 */
class BatchDeleteCatalogObjectsResponseBuilder
{
    /**
     * @var BatchDeleteCatalogObjectsResponse
     */
    private $instance;

    private function __construct(BatchDeleteCatalogObjectsResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new batch delete catalog objects response Builder object.
     */
    public static function init(): self
    {
        return new self(new BatchDeleteCatalogObjectsResponse());
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
     * Sets deleted object ids field.
     */
    public function deletedObjectIds(?array $value): self
    {
        $this->instance->setDeletedObjectIds($value);
        return $this;
    }

    /**
     * Sets deleted at field.
     */
    public function deletedAt(?string $value): self
    {
        $this->instance->setDeletedAt($value);
        return $this;
    }

    /**
     * Initializes a new batch delete catalog objects response object.
     */
    public function build(): BatchDeleteCatalogObjectsResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
