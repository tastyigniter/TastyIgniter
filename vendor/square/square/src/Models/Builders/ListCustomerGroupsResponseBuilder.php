<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\ListCustomerGroupsResponse;

/**
 * Builder for model ListCustomerGroupsResponse
 *
 * @see ListCustomerGroupsResponse
 */
class ListCustomerGroupsResponseBuilder
{
    /**
     * @var ListCustomerGroupsResponse
     */
    private $instance;

    private function __construct(ListCustomerGroupsResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new list customer groups response Builder object.
     */
    public static function init(): self
    {
        return new self(new ListCustomerGroupsResponse());
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
     * Sets groups field.
     */
    public function groups(?array $value): self
    {
        $this->instance->setGroups($value);
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
     * Initializes a new list customer groups response object.
     */
    public function build(): ListCustomerGroupsResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
