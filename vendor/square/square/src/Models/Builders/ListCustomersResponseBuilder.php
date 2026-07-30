<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\ListCustomersResponse;

/**
 * Builder for model ListCustomersResponse
 *
 * @see ListCustomersResponse
 */
class ListCustomersResponseBuilder
{
    /**
     * @var ListCustomersResponse
     */
    private $instance;

    private function __construct(ListCustomersResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new list customers response Builder object.
     */
    public static function init(): self
    {
        return new self(new ListCustomersResponse());
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
     * Sets customers field.
     */
    public function customers(?array $value): self
    {
        $this->instance->setCustomers($value);
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
     * Initializes a new list customers response object.
     */
    public function build(): ListCustomersResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
