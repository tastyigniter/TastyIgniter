<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\RemoveGroupFromCustomerResponse;

/**
 * Builder for model RemoveGroupFromCustomerResponse
 *
 * @see RemoveGroupFromCustomerResponse
 */
class RemoveGroupFromCustomerResponseBuilder
{
    /**
     * @var RemoveGroupFromCustomerResponse
     */
    private $instance;

    private function __construct(RemoveGroupFromCustomerResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new remove group from customer response Builder object.
     */
    public static function init(): self
    {
        return new self(new RemoveGroupFromCustomerResponse());
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
     * Initializes a new remove group from customer response object.
     */
    public function build(): RemoveGroupFromCustomerResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
