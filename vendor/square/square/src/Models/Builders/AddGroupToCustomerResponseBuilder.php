<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\AddGroupToCustomerResponse;

/**
 * Builder for model AddGroupToCustomerResponse
 *
 * @see AddGroupToCustomerResponse
 */
class AddGroupToCustomerResponseBuilder
{
    /**
     * @var AddGroupToCustomerResponse
     */
    private $instance;

    private function __construct(AddGroupToCustomerResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new add group to customer response Builder object.
     */
    public static function init(): self
    {
        return new self(new AddGroupToCustomerResponse());
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
     * Initializes a new add group to customer response object.
     */
    public function build(): AddGroupToCustomerResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
