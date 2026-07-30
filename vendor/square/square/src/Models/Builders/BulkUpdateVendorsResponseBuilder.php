<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\BulkUpdateVendorsResponse;

/**
 * Builder for model BulkUpdateVendorsResponse
 *
 * @see BulkUpdateVendorsResponse
 */
class BulkUpdateVendorsResponseBuilder
{
    /**
     * @var BulkUpdateVendorsResponse
     */
    private $instance;

    private function __construct(BulkUpdateVendorsResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new bulk update vendors response Builder object.
     */
    public static function init(): self
    {
        return new self(new BulkUpdateVendorsResponse());
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
     * Initializes a new bulk update vendors response object.
     */
    public function build(): BulkUpdateVendorsResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
