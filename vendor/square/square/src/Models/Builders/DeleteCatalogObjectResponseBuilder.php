<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\DeleteCatalogObjectResponse;

/**
 * Builder for model DeleteCatalogObjectResponse
 *
 * @see DeleteCatalogObjectResponse
 */
class DeleteCatalogObjectResponseBuilder
{
    /**
     * @var DeleteCatalogObjectResponse
     */
    private $instance;

    private function __construct(DeleteCatalogObjectResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new delete catalog object response Builder object.
     */
    public static function init(): self
    {
        return new self(new DeleteCatalogObjectResponse());
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
     * Initializes a new delete catalog object response object.
     */
    public function build(): DeleteCatalogObjectResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
