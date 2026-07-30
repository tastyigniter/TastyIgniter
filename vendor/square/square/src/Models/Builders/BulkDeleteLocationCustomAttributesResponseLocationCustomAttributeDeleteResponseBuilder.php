<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\BulkDeleteLocationCustomAttributesResponseLocationCustomAttributeDeleteResponse;

/**
 * Builder for model BulkDeleteLocationCustomAttributesResponseLocationCustomAttributeDeleteResponse
 *
 * @see BulkDeleteLocationCustomAttributesResponseLocationCustomAttributeDeleteResponse
 */
class BulkDeleteLocationCustomAttributesResponseLocationCustomAttributeDeleteResponseBuilder
{
    /**
     * @var BulkDeleteLocationCustomAttributesResponseLocationCustomAttributeDeleteResponse
     */
    private $instance;

    private function __construct(
        BulkDeleteLocationCustomAttributesResponseLocationCustomAttributeDeleteResponse $instance
    ) {
        $this->instance = $instance;
    }

    /**
     * Initializes a new bulk delete location custom attributes response location custom attribute delete
     * response Builder object.
     */
    public static function init(): self
    {
        return new self(new BulkDeleteLocationCustomAttributesResponseLocationCustomAttributeDeleteResponse());
    }

    /**
     * Sets location id field.
     */
    public function locationId(?string $value): self
    {
        $this->instance->setLocationId($value);
        return $this;
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
     * Initializes a new bulk delete location custom attributes response location custom attribute delete
     * response object.
     */
    public function build(): BulkDeleteLocationCustomAttributesResponseLocationCustomAttributeDeleteResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
