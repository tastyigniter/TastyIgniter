<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\UpdateVendorResponse;
use Square\Models\Vendor;

/**
 * Builder for model UpdateVendorResponse
 *
 * @see UpdateVendorResponse
 */
class UpdateVendorResponseBuilder
{
    /**
     * @var UpdateVendorResponse
     */
    private $instance;

    private function __construct(UpdateVendorResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new update vendor response Builder object.
     */
    public static function init(): self
    {
        return new self(new UpdateVendorResponse());
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
     * Initializes a new update vendor response object.
     */
    public function build(): UpdateVendorResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
