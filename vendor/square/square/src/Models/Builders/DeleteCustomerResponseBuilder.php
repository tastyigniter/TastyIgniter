<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\DeleteCustomerResponse;

/**
 * Builder for model DeleteCustomerResponse
 *
 * @see DeleteCustomerResponse
 */
class DeleteCustomerResponseBuilder
{
    /**
     * @var DeleteCustomerResponse
     */
    private $instance;

    private function __construct(DeleteCustomerResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new delete customer response Builder object.
     */
    public static function init(): self
    {
        return new self(new DeleteCustomerResponse());
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
     * Initializes a new delete customer response object.
     */
    public function build(): DeleteCustomerResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
