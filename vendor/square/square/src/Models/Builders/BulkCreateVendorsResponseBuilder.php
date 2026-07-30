<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\BulkCreateVendorsResponse;

/**
 * Builder for model BulkCreateVendorsResponse
 *
 * @see BulkCreateVendorsResponse
 */
class BulkCreateVendorsResponseBuilder
{
    /**
     * @var BulkCreateVendorsResponse
     */
    private $instance;

    private function __construct(BulkCreateVendorsResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new bulk create vendors response Builder object.
     */
    public static function init(): self
    {
        return new self(new BulkCreateVendorsResponse());
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
     * Sets responses field.
     */
    public function responses(?array $value): self
    {
        $this->instance->setResponses($value);
        return $this;
    }

    /**
     * Initializes a new bulk create vendors response object.
     */
    public function build(): BulkCreateVendorsResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
