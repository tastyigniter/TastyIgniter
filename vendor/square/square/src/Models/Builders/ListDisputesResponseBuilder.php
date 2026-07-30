<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\ListDisputesResponse;

/**
 * Builder for model ListDisputesResponse
 *
 * @see ListDisputesResponse
 */
class ListDisputesResponseBuilder
{
    /**
     * @var ListDisputesResponse
     */
    private $instance;

    private function __construct(ListDisputesResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new list disputes response Builder object.
     */
    public static function init(): self
    {
        return new self(new ListDisputesResponse());
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
     * Sets disputes field.
     */
    public function disputes(?array $value): self
    {
        $this->instance->setDisputes($value);
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
     * Initializes a new list disputes response object.
     */
    public function build(): ListDisputesResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
