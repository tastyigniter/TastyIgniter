<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CustomerGroup;
use Square\Models\UpdateCustomerGroupRequest;

/**
 * Builder for model UpdateCustomerGroupRequest
 *
 * @see UpdateCustomerGroupRequest
 */
class UpdateCustomerGroupRequestBuilder
{
    /**
     * @var UpdateCustomerGroupRequest
     */
    private $instance;

    private function __construct(UpdateCustomerGroupRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new update customer group request Builder object.
     */
    public static function init(CustomerGroup $group): self
    {
        return new self(new UpdateCustomerGroupRequest($group));
    }

    /**
     * Initializes a new update customer group request object.
     */
    public function build(): UpdateCustomerGroupRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
