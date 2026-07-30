<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\Customer;
use Square\Models\RetrieveCustomerResponse;

/**
 * Builder for model RetrieveCustomerResponse
 *
 * @see RetrieveCustomerResponse
 */
class RetrieveCustomerResponseBuilder
{
    /**
     * @var RetrieveCustomerResponse
     */
    private $instance;

    private function __construct(RetrieveCustomerResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new retrieve customer response Builder object.
     */
    public static function init(): self
    {
        return new self(new RetrieveCustomerResponse());
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
     * Initializes a new retrieve customer response object.
     */
    public function build(): RetrieveCustomerResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
