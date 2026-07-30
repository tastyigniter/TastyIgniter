<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CreateCustomerGroupResponse;
use Square\Models\CustomerGroup;

/**
 * Builder for model CreateCustomerGroupResponse
 *
 * @see CreateCustomerGroupResponse
 */
class CreateCustomerGroupResponseBuilder
{
    /**
     * @var CreateCustomerGroupResponse
     */
    private $instance;

    private function __construct(CreateCustomerGroupResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new create customer group response Builder object.
     */
    public static function init(): self
    {
        return new self(new CreateCustomerGroupResponse());
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
     * Sets group field.
     */
    public function group(?CustomerGroup $value): self
    {
        $this->instance->setGroup($value);
        return $this;
    }

    /**
     * Initializes a new create customer group response object.
     */
    public function build(): CreateCustomerGroupResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
