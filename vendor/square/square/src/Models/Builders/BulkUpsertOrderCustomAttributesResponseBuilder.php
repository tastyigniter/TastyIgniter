<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\BulkUpsertOrderCustomAttributesResponse;

/**
 * Builder for model BulkUpsertOrderCustomAttributesResponse
 *
 * @see BulkUpsertOrderCustomAttributesResponse
 */
class BulkUpsertOrderCustomAttributesResponseBuilder
{
    /**
     * @var BulkUpsertOrderCustomAttributesResponse
     */
    private $instance;

    private function __construct(BulkUpsertOrderCustomAttributesResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new bulk upsert order custom attributes response Builder object.
     */
    public static function init(array $values): self
    {
        return new self(new BulkUpsertOrderCustomAttributesResponse($values));
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
     * Initializes a new bulk upsert order custom attributes response object.
     */
    public function build(): BulkUpsertOrderCustomAttributesResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
