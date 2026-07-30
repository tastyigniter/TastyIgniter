<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\ListCustomerSegmentsResponse;

/**
 * Builder for model ListCustomerSegmentsResponse
 *
 * @see ListCustomerSegmentsResponse
 */
class ListCustomerSegmentsResponseBuilder
{
    /**
     * @var ListCustomerSegmentsResponse
     */
    private $instance;

    private function __construct(ListCustomerSegmentsResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new list customer segments response Builder object.
     */
    public static function init(): self
    {
        return new self(new ListCustomerSegmentsResponse());
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
     * Sets segments field.
     */
    public function segments(?array $value): self
    {
        $this->instance->setSegments($value);
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
     * Initializes a new list customer segments response object.
     */
    public function build(): ListCustomerSegmentsResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
