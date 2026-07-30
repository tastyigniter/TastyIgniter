<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CreateVendorResponse;
use Square\Models\Vendor;

/**
 * Builder for model CreateVendorResponse
 *
 * @see CreateVendorResponse
 */
class CreateVendorResponseBuilder
{
    /**
     * @var CreateVendorResponse
     */
    private $instance;

    private function __construct(CreateVendorResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new create vendor response Builder object.
     */
    public static function init(): self
    {
        return new self(new CreateVendorResponse());
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
     * Sets vendor field.
     */
    public function vendor(?Vendor $value): self
    {
        $this->instance->setVendor($value);
        return $this;
    }

    /**
     * Initializes a new create vendor response object.
     */
    public function build(): CreateVendorResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
