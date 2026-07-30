<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CreateCustomerResponse;
use Square\Models\Customer;

/**
 * Builder for model CreateCustomerResponse
 *
 * @see CreateCustomerResponse
 */
class CreateCustomerResponseBuilder
{
    /**
     * @var CreateCustomerResponse
     */
    private $instance;

    private function __construct(CreateCustomerResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new create customer response Builder object.
     */
    public static function init(): self
    {
        return new self(new CreateCustomerResponse());
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
     * Sets customer field.
     */
    public function customer(?Customer $value): self
    {
        $this->instance->setCustomer($value);
        return $this;
    }

    /**
     * Initializes a new create customer response object.
     */
    public function build(): CreateCustomerResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
