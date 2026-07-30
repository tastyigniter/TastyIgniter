<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CustomerAddressFilter;
use Square\Models\CustomerTextFilter;

/**
 * Builder for model CustomerAddressFilter
 *
 * @see CustomerAddressFilter
 */
class CustomerAddressFilterBuilder
{
    /**
     * @var CustomerAddressFilter
     */
    private $instance;

    private function __construct(CustomerAddressFilter $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new customer address filter Builder object.
     */
    public static function init(): self
    {
        return new self(new CustomerAddressFilter());
    }

    /**
     * Sets postal code field.
     */
    public function postalCode(?CustomerTextFilter $value): self
    {
        $this->instance->setPostalCode($value);
        return $this;
    }

    /**
     * Sets country field.
     */
    public function country(?string $value): self
    {
        $this->instance->setCountry($value);
        return $this;
    }

    /**
     * Initializes a new customer address filter object.
     */
    public function build(): CustomerAddressFilter
    {
        return CoreHelper::clone($this->instance);
    }
}
