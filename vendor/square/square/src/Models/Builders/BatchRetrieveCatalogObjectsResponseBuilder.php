<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\BatchRetrieveCatalogObjectsResponse;

/**
 * Builder for model BatchRetrieveCatalogObjectsResponse
 *
 * @see BatchRetrieveCatalogObjectsResponse
 */
class BatchRetrieveCatalogObjectsResponseBuilder
{
    /**
     * @var BatchRetrieveCatalogObjectsResponse
     */
    private $instance;

    private function __construct(BatchRetrieveCatalogObjectsResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new batch retrieve catalog objects response Builder object.
     */
    public static function init(): self
    {
        return new self(new BatchRetrieveCatalogObjectsResponse());
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
     * Sets related objects field.
     */
    public function relatedObjects(?array $value): self
    {
        $this->instance->setRelatedObjects($value);
        return $this;
    }

    /**
     * Initializes a new batch retrieve catalog objects response object.
     */
    public function build(): BatchRetrieveCatalogObjectsResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
