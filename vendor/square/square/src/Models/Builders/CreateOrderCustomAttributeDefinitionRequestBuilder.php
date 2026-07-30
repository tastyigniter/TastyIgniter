<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CreateOrderCustomAttributeDefinitionRequest;
use Square\Models\CustomAttributeDefinition;

/**
 * Builder for model CreateOrderCustomAttributeDefinitionRequest
 *
 * @see CreateOrderCustomAttributeDefinitionRequest
 */
class CreateOrderCustomAttributeDefinitionRequestBuilder
{
    /**
     * @var CreateOrderCustomAttributeDefinitionRequest
     */
    private $instance;

    private function __construct(CreateOrderCustomAttributeDefinitionRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new create order custom attribute definition request Builder object.
     */
    public static function init(CustomAttributeDefinition $customAttributeDefinition): self
    {
        return new self(new CreateOrderCustomAttributeDefinitionRequest($customAttributeDefinition));
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
     * Initializes a new create order custom attribute definition request object.
     */
    public function build(): CreateOrderCustomAttributeDefinitionRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
