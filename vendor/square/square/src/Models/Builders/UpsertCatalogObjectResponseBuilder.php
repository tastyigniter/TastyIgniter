<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CatalogObject;
use Square\Models\UpsertCatalogObjectResponse;

/**
 * Builder for model UpsertCatalogObjectResponse
 *
 * @see UpsertCatalogObjectResponse
 */
class UpsertCatalogObjectResponseBuilder
{
    /**
     * @var UpsertCatalogObjectResponse
     */
    private $instance;

    private function __construct(UpsertCatalogObjectResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new upsert catalog object response Builder object.
     */
    public static function init(): self
    {
        return new self(new UpsertCatalogObjectResponse());
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
     * Sets catalog object field.
     */
    public function catalogObject(?CatalogObject $value): self
    {
        $this->instance->setCatalogObject($value);
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
     * Initializes a new upsert catalog object response object.
     */
    public function build(): UpsertCatalogObjectResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
