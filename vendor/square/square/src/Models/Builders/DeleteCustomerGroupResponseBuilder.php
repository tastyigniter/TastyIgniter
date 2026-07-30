<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\DeleteCustomerGroupResponse;

/**
 * Builder for model DeleteCustomerGroupResponse
 *
 * @see DeleteCustomerGroupResponse
 */
class DeleteCustomerGroupResponseBuilder
{
    /**
     * @var DeleteCustomerGroupResponse
     */
    private $instance;

    private function __construct(DeleteCustomerGroupResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new delete customer group response Builder object.
     */
    public static function init(): self
    {
        return new self(new DeleteCustomerGroupResponse());
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
     * Initializes a new delete customer group response object.
     */
    public function build(): DeleteCustomerGroupResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
