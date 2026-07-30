<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CreateLocationCustomAttributeDefinitionRequest;
use Square\Models\CustomAttributeDefinition;

/**
 * Builder for model CreateLocationCustomAttributeDefinitionRequest
 *
 * @see CreateLocationCustomAttributeDefinitionRequest
 */
class CreateLocationCustomAttributeDefinitionRequestBuilder
{
    /**
     * @var CreateLocationCustomAttributeDefinitionRequest
     */
    private $instance;

    private function __construct(CreateLocationCustomAttributeDefinitionRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new create location custom attribute definition request Builder object.
     */
    public static function init(CustomAttributeDefinition $customAttributeDefinition): self
    {
        return new self(new CreateLocationCustomAttributeDefinitionRequest($customAttributeDefinition));
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
     * Initializes a new create location custom attribute definition request object.
     */
    public function build(): CreateLocationCustomAttributeDefinitionRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
