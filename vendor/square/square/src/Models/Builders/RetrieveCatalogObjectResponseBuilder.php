<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CatalogObject;
use Square\Models\RetrieveCatalogObjectResponse;

/**
 * Builder for model RetrieveCatalogObjectResponse
 *
 * @see RetrieveCatalogObjectResponse
 */
class RetrieveCatalogObjectResponseBuilder
{
    /**
     * @var RetrieveCatalogObjectResponse
     */
    private $instance;

    private function __construct(RetrieveCatalogObjectResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new retrieve catalog object response Builder object.
     */
    public static function init(): self
    {
        return new self(new RetrieveCatalogObjectResponse());
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
     * Sets object field.
     */
    public function object(?CatalogObject $value): self
    {
        $this->instance->setObject($value);
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
     * Initializes a new retrieve catalog object response object.
     */
    public function build(): RetrieveCatalogObjectResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
