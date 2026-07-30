<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\BulkDeleteLocationCustomAttributesResponse;

/**
 * Builder for model BulkDeleteLocationCustomAttributesResponse
 *
 * @see BulkDeleteLocationCustomAttributesResponse
 */
class BulkDeleteLocationCustomAttributesResponseBuilder
{
    /**
     * @var BulkDeleteLocationCustomAttributesResponse
     */
    private $instance;

    private function __construct(BulkDeleteLocationCustomAttributesResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new bulk delete location custom attributes response Builder object.
     */
    public static function init(array $values): self
    {
        return new self(new BulkDeleteLocationCustomAttributesResponse($values));
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
     * Initializes a new bulk delete location custom attributes response object.
     */
    public function build(): BulkDeleteLocationCustomAttributesResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
