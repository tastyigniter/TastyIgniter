<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\V1ListRefundsResponse;

/**
 * Builder for model V1ListRefundsResponse
 *
 * @see V1ListRefundsResponse
 */
class V1ListRefundsResponseBuilder
{
    /**
     * @var V1ListRefundsResponse
     */
    private $instance;

    private function __construct(V1ListRefundsResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new v1 list refunds response Builder object.
     */
    public static function init(): self
    {
        return new self(new V1ListRefundsResponse());
    }

    /**
     * Sets items field.
     */
    public function items(?array $value): self
    {
        $this->instance->setItems($value);
        return $this;
    }

    /**
     * Initializes a new v1 list refunds response object.
     */
    public function build(): V1ListRefundsResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
