<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CreateCustomerGroupRequest;
use Square\Models\CustomerGroup;

/**
 * Builder for model CreateCustomerGroupRequest
 *
 * @see CreateCustomerGroupRequest
 */
class CreateCustomerGroupRequestBuilder
{
    /**
     * @var CreateCustomerGroupRequest
     */
    private $instance;

    private function __construct(CreateCustomerGroupRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new create customer group request Builder object.
     */
    public static function init(CustomerGroup $group): self
    {
        return new self(new CreateCustomerGroupRequest($group));
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
     * Initializes a new create customer group request object.
     */
    public function build(): CreateCustomerGroupRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
