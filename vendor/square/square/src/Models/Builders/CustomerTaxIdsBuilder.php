<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CustomerTaxIds;

/**
 * Builder for model CustomerTaxIds
 *
 * @see CustomerTaxIds
 */
class CustomerTaxIdsBuilder
{
    /**
     * @var CustomerTaxIds
     */
    private $instance;

    private function __construct(CustomerTaxIds $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new customer tax ids Builder object.
     */
    public static function init(): self
    {
        return new self(new CustomerTaxIds());
    }

    /**
     * Sets eu vat field.
     */
    public function euVat(?string $value): self
    {
        $this->instance->setEuVat($value);
        return $this;
    }

    /**
     * Unsets eu vat field.
     */
    public function unsetEuVat(): self
    {
        $this->instance->unsetEuVat();
        return $this;
    }

    /**
     * Initializes a new customer tax ids object.
     */
    public function build(): CustomerTaxIds
    {
        return CoreHelper::clone($this->instance);
    }
}
