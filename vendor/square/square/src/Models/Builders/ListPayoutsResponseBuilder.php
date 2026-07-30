<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\ListPayoutsResponse;

/**
 * Builder for model ListPayoutsResponse
 *
 * @see ListPayoutsResponse
 */
class ListPayoutsResponseBuilder
{
    /**
     * @var ListPayoutsResponse
     */
    private $instance;

    private function __construct(ListPayoutsResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new list payouts response Builder object.
     */
    public static function init(): self
    {
        return new self(new ListPayoutsResponse());
    }

    /**
     * Sets payouts field.
     */
    public function payouts(?array $value): self
    {
        $this->instance->setPayouts($value);
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
     * Sets errors field.
     */
    public function errors(?array $value): self
    {
        $this->instance->setErrors($value);
        return $this;
    }

    /**
     * Initializes a new list payouts response object.
     */
    public function build(): ListPayoutsResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
