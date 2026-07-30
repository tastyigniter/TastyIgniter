<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\DeleteCustomerCustomAttributeDefinitionResponse;

/**
 * Builder for model DeleteCustomerCustomAttributeDefinitionResponse
 *
 * @see DeleteCustomerCustomAttributeDefinitionResponse
 */
class DeleteCustomerCustomAttributeDefinitionResponseBuilder
{
    /**
     * @var DeleteCustomerCustomAttributeDefinitionResponse
     */
    private $instance;

    private function __construct(DeleteCustomerCustomAttributeDefinitionResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new delete customer custom attribute definition response Builder object.
     */
    public static function init(): self
    {
        return new self(new DeleteCustomerCustomAttributeDefinitionResponse());
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
     * Initializes a new delete customer custom attribute definition response object.
     */
    public function build(): DeleteCustomerCustomAttributeDefinitionResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
