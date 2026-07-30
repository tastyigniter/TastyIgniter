<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\ListCustomerGroupsRequest;

/**
 * Builder for model ListCustomerGroupsRequest
 *
 * @see ListCustomerGroupsRequest
 */
class ListCustomerGroupsRequestBuilder
{
    /**
     * @var ListCustomerGroupsRequest
     */
    private $instance;

    private function __construct(ListCustomerGroupsRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new list customer groups request Builder object.
     */
    public static function init(): self
    {
        return new self(new ListCustomerGroupsRequest());
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
     * Initializes a new list customer groups request object.
     */
    public function build(): ListCustomerGroupsRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
