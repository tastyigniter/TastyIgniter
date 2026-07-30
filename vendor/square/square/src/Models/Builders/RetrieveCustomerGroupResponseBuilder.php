<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CustomerGroup;
use Square\Models\RetrieveCustomerGroupResponse;

/**
 * Builder for model RetrieveCustomerGroupResponse
 *
 * @see RetrieveCustomerGroupResponse
 */
class RetrieveCustomerGroupResponseBuilder
{
    /**
     * @var RetrieveCustomerGroupResponse
     */
    private $instance;

    private function __construct(RetrieveCustomerGroupResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new retrieve customer group response Builder object.
     */
    public static function init(): self
    {
        return new self(new RetrieveCustomerGroupResponse());
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
     * Initializes a new retrieve customer group response object.
     */
    public function build(): RetrieveCustomerGroupResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
