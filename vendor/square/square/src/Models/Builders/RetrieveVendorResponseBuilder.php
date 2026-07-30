<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\RetrieveVendorResponse;
use Square\Models\Vendor;

/**
 * Builder for model RetrieveVendorResponse
 *
 * @see RetrieveVendorResponse
 */
class RetrieveVendorResponseBuilder
{
    /**
     * @var RetrieveVendorResponse
     */
    private $instance;

    private function __construct(RetrieveVendorResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new retrieve vendor response Builder object.
     */
    public static function init(): self
    {
        return new self(new RetrieveVendorResponse());
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
     * Initializes a new retrieve vendor response object.
     */
    public function build(): RetrieveVendorResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
