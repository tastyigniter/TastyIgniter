<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\BatchUpsertCatalogObjectsResponse;

/**
 * Builder for model BatchUpsertCatalogObjectsResponse
 *
 * @see BatchUpsertCatalogObjectsResponse
 */
class BatchUpsertCatalogObjectsResponseBuilder
{
    /**
     * @var BatchUpsertCatalogObjectsResponse
     */
    private $instance;

    private function __construct(BatchUpsertCatalogObjectsResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new batch upsert catalog objects response Builder object.
     */
    public static function init(): self
    {
        return new self(new BatchUpsertCatalogObjectsResponse());
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
     * Sets objects field.
     */
    public function objects(?array $value): self
    {
        $this->instance->setObjects($value);
        return $this;
    }

    /**
     * Sets updated at field.
     */
    public function updatedAt(?string $value): self
    {
        $this->instance->setUpdatedAt($value);
        return $this;
    }

    /**
     * Sets id mappings field.
     */
    public function idMappings(?array $value): self
    {
        $this->instance->setIdMappings($value);
        return $this;
    }

    /**
     * Initializes a new batch upsert catalog objects response object.
     */
    public function build(): BatchUpsertCatalogObjectsResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
