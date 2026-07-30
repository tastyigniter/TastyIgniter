<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CustomAttributeDefinition;
use Square\Models\UpdateCustomerCustomAttributeDefinitionRequest;

/**
 * Builder for model UpdateCustomerCustomAttributeDefinitionRequest
 *
 * @see UpdateCustomerCustomAttributeDefinitionRequest
 */
class UpdateCustomerCustomAttributeDefinitionRequestBuilder
{
    /**
     * @var UpdateCustomerCustomAttributeDefinitionRequest
     */
    private $instance;

    private function __construct(UpdateCustomerCustomAttributeDefinitionRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new update customer custom attribute definition request Builder object.
     */
    public static function init(CustomAttributeDefinition $customAttributeDefinition): self
    {
        return new self(new UpdateCustomerCustomAttributeDefinitionRequest($customAttributeDefinition));
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
     * Unsets idempotency key field.
     */
    public function unsetIdempotencyKey(): self
    {
        $this->instance->unsetIdempotencyKey();
        return $this;
    }

    /**
     * Initializes a new update customer custom attribute definition request object.
     */
    public function build(): UpdateCustomerCustomAttributeDefinitionRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
