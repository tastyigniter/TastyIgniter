<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\DeleteCustomerCustomAttributeResponse;

/**
 * Builder for model DeleteCustomerCustomAttributeResponse
 *
 * @see DeleteCustomerCustomAttributeResponse
 */
class DeleteCustomerCustomAttributeResponseBuilder
{
    /**
     * @var DeleteCustomerCustomAttributeResponse
     */
    private $instance;

    private function __construct(DeleteCustomerCustomAttributeResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new delete customer custom attribute response Builder object.
     */
    public static function init(): self
    {
        return new self(new DeleteCustomerCustomAttributeResponse());
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
     * Initializes a new delete customer custom attribute response object.
     */
    public function build(): DeleteCustomerCustomAttributeResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
