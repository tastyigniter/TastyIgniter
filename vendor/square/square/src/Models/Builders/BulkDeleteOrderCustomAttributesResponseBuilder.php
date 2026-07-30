<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\BulkDeleteOrderCustomAttributesResponse;

/**
 * Builder for model BulkDeleteOrderCustomAttributesResponse
 *
 * @see BulkDeleteOrderCustomAttributesResponse
 */
class BulkDeleteOrderCustomAttributesResponseBuilder
{
    /**
     * @var BulkDeleteOrderCustomAttributesResponse
     */
    private $instance;

    private function __construct(BulkDeleteOrderCustomAttributesResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new bulk delete order custom attributes response Builder object.
     */
    public static function init(array $values): self
    {
        return new self(new BulkDeleteOrderCustomAttributesResponse($values));
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
     * Initializes a new bulk delete order custom attributes response object.
     */
    public function build(): BulkDeleteOrderCustomAttributesResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
