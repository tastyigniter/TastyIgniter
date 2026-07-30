<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CatalogObject;
use Square\Models\CreateCatalogImageResponse;

/**
 * Builder for model CreateCatalogImageResponse
 *
 * @see CreateCatalogImageResponse
 */
class CreateCatalogImageResponseBuilder
{
    /**
     * @var CreateCatalogImageResponse
     */
    private $instance;

    private function __construct(CreateCatalogImageResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new create catalog image response Builder object.
     */
    public static function init(): self
    {
        return new self(new CreateCatalogImageResponse());
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
     * Sets image field.
     */
    public function image(?CatalogObject $value): self
    {
        $this->instance->setImage($value);
        return $this;
    }

    /**
     * Initializes a new create catalog image response object.
     */
    public function build(): CreateCatalogImageResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
