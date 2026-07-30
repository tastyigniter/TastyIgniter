<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\Customer;
use Square\Models\UpdateCustomerResponse;

/**
 * Builder for model UpdateCustomerResponse
 *
 * @see UpdateCustomerResponse
 */
class UpdateCustomerResponseBuilder
{
    /**
     * @var UpdateCustomerResponse
     */
    private $instance;

    private function __construct(UpdateCustomerResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new update customer response Builder object.
     */
    public static function init(): self
    {
        return new self(new UpdateCustomerResponse());
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
     * Initializes a new update customer response object.
     */
    public function build(): UpdateCustomerResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
