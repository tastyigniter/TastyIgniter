<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\BulkDeleteLocationCustomAttributesRequestLocationCustomAttributeDeleteRequest;

/**
 * Builder for model BulkDeleteLocationCustomAttributesRequestLocationCustomAttributeDeleteRequest
 *
 * @see BulkDeleteLocationCustomAttributesRequestLocationCustomAttributeDeleteRequest
 */
class BulkDeleteLocationCustomAttributesRequestLocationCustomAttributeDeleteRequestBuilder
{
    /**
     * @var BulkDeleteLocationCustomAttributesRequestLocationCustomAttributeDeleteRequest
     */
    private $instance;

    private function __construct(
        BulkDeleteLocationCustomAttributesRequestLocationCustomAttributeDeleteRequest $instance
    ) {
        $this->instance = $instance;
    }

    /**
     * Initializes a new bulk delete location custom attributes request location custom attribute delete
     * request Builder object.
     */
    public static function init(): self
    {
        return new self(new BulkDeleteLocationCustomAttributesRequestLocationCustomAttributeDeleteRequest());
    }

    /**
     * Sets key field.
     */
    public function key(?string $value): self
    {
        $this->instance->setKey($value);
        return $this;
    }

    /**
     * Initializes a new bulk delete location custom attributes request location custom attribute delete
     * request object.
     */
    public function build(): BulkDeleteLocationCustomAttributesRequestLocationCustomAttributeDeleteRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
