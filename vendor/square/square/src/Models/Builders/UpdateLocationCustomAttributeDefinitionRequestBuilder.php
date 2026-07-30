<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CustomAttributeDefinition;
use Square\Models\UpdateLocationCustomAttributeDefinitionRequest;

/**
 * Builder for model UpdateLocationCustomAttributeDefinitionRequest
 *
 * @see UpdateLocationCustomAttributeDefinitionRequest
 */
class UpdateLocationCustomAttributeDefinitionRequestBuilder
{
    /**
     * @var UpdateLocationCustomAttributeDefinitionRequest
     */
    private $instance;

    private function __construct(UpdateLocationCustomAttributeDefinitionRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new update location custom attribute definition request Builder object.
     */
    public static function init(CustomAttributeDefinition $customAttributeDefinition): self
    {
        return new self(new UpdateLocationCustomAttributeDefinitionRequest($customAttributeDefinition));
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
     * Initializes a new update location custom attribute definition request object.
     */
    public function build(): UpdateLocationCustomAttributeDefinitionRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
