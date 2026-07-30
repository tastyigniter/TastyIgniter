<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CreateCustomerCustomAttributeDefinitionRequest;
use Square\Models\CustomAttributeDefinition;

/**
 * Builder for model CreateCustomerCustomAttributeDefinitionRequest
 *
 * @see CreateCustomerCustomAttributeDefinitionRequest
 */
class CreateCustomerCustomAttributeDefinitionRequestBuilder
{
    /**
     * @var CreateCustomerCustomAttributeDefinitionRequest
     */
    private $instance;

    private function __construct(CreateCustomerCustomAttributeDefinitionRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new create customer custom attribute definition request Builder object.
     */
    public static function init(CustomAttributeDefinition $customAttributeDefinition): self
    {
        return new self(new CreateCustomerCustomAttributeDefinitionRequest($customAttributeDefinition));
    }

    /**
     * Sets idempotency key field.
     */
    public function idempotencyKey(?string $value): self
    {
        $this->instance->setIdempotencyKey($value);
        return $this;
    }

    /**
     * Initializes a new create customer custom attribute definition request object.
     */
    public function build(): CreateCustomerCustomAttributeDefinitionRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
