<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\DeleteCustomerCardResponse;

/**
 * Builder for model DeleteCustomerCardResponse
 *
 * @see DeleteCustomerCardResponse
 */
class DeleteCustomerCardResponseBuilder
{
    /**
     * @var DeleteCustomerCardResponse
     */
    private $instance;

    private function __construct(DeleteCustomerCardResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new delete customer card response Builder object.
     */
    public static function init(): self
    {
        return new self(new DeleteCustomerCardResponse());
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
     * Initializes a new delete customer card response object.
     */
    public function build(): DeleteCustomerCardResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
