<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CatalogObject;
use Square\Models\CreateCatalogImageRequest;

/**
 * Builder for model CreateCatalogImageRequest
 *
 * @see CreateCatalogImageRequest
 */
class CreateCatalogImageRequestBuilder
{
    /**
     * @var CreateCatalogImageRequest
     */
    private $instance;

    private function __construct(CreateCatalogImageRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new create catalog image request Builder object.
     */
    public static function init(string $idempotencyKey, CatalogObject $image): self
    {
        return new self(new CreateCatalogImageRequest($idempotencyKey, $image));
    }

    /**
     * Sets object id field.
     */
    public function objectId(?string $value): self
    {
        $this->instance->setObjectId($value);
        return $this;
    }

    /**
     * Sets is primary field.
     */
    public function isPrimary(?bool $value): self
    {
        $this->instance->setIsPrimary($value);
        return $this;
    }

    /**
     * Initializes a new create catalog image request object.
     */
    public function build(): CreateCatalogImageRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
