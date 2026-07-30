<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\RetrieveCustomerCustomAttributeDefinitionRequest;

/**
 * Builder for model RetrieveCustomerCustomAttributeDefinitionRequest
 *
 * @see RetrieveCustomerCustomAttributeDefinitionRequest
 */
class RetrieveCustomerCustomAttributeDefinitionRequestBuilder
{
    /**
     * @var RetrieveCustomerCustomAttributeDefinitionRequest
     */
    private $instance;

    private function __construct(RetrieveCustomerCustomAttributeDefinitionRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new retrieve customer custom attribute definition request Builder object.
     */
    public static function init(): self
    {
        return new self(new RetrieveCustomerCustomAttributeDefinitionRequest());
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
     * Initializes a new retrieve customer custom attribute definition request object.
     */
    public function build(): RetrieveCustomerCustomAttributeDefinitionRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
