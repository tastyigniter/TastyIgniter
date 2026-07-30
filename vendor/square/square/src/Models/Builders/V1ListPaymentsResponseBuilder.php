<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\V1ListPaymentsResponse;

/**
 * Builder for model V1ListPaymentsResponse
 *
 * @see V1ListPaymentsResponse
 */
class V1ListPaymentsResponseBuilder
{
    /**
     * @var V1ListPaymentsResponse
     */
    private $instance;

    private function __construct(V1ListPaymentsResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new v1 list payments response Builder object.
     */
    public static function init(): self
    {
        return new self(new V1ListPaymentsResponse());
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
     * Initializes a new v1 list payments response object.
     */
    public function build(): V1ListPaymentsResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
