<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\ListCustomerCustomAttributeDefinitionsRequest;

/**
 * Builder for model ListCustomerCustomAttributeDefinitionsRequest
 *
 * @see ListCustomerCustomAttributeDefinitionsRequest
 */
class ListCustomerCustomAttributeDefinitionsRequestBuilder
{
    /**
     * @var ListCustomerCustomAttributeDefinitionsRequest
     */
    private $instance;

    private function __construct(ListCustomerCustomAttributeDefinitionsRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new list customer custom attribute definitions request Builder object.
     */
    public static function init(): self
    {
        return new self(new ListCustomerCustomAttributeDefinitionsRequest());
    }

    /**
     * Sets limit field.
     */
    public function limit(?int $value): self
    {
        $this->instance->setLimit($value);
        return $this;
    }

    /**
     * Unsets limit field.
     */
    public function unsetLimit(): self
    {
        $this->instance->unsetLimit();
        return $this;
    }

    /**
     * Sets cursor field.
     */
    public function cursor(?string $value): self
    {
        $this->instance->setCursor($value);
        return $this;
    }

    /**
     * Unsets cursor field.
     */
    public function unsetCursor(): self
    {
        $this->instance->unsetCursor();
        return $this;
    }

    /**
     * Initializes a new list customer custom attribute definitions request object.
     */
    public function build(): ListCustomerCustomAttributeDefinitionsRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
