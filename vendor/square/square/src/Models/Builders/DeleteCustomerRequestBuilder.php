<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\DeleteCustomerRequest;

/**
 * Builder for model DeleteCustomerRequest
 *
 * @see DeleteCustomerRequest
 */
class DeleteCustomerRequestBuilder
{
    /**
     * @var DeleteCustomerRequest
     */
    private $instance;

    private function __construct(DeleteCustomerRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new delete customer request Builder object.
     */
    public static function init(): self
    {
        return new self(new DeleteCustomerRequest());
    }

    /**
     * Sets version field.
     */
    public function version(?int $value): self
    {
        $this->instance->setVersion($value);
        return $this;
    }

    /**
     * Initializes a new delete customer request object.
     */
    public function build(): DeleteCustomerRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
