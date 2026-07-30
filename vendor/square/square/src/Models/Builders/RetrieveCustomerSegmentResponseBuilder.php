<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CustomerSegment;
use Square\Models\RetrieveCustomerSegmentResponse;

/**
 * Builder for model RetrieveCustomerSegmentResponse
 *
 * @see RetrieveCustomerSegmentResponse
 */
class RetrieveCustomerSegmentResponseBuilder
{
    /**
     * @var RetrieveCustomerSegmentResponse
     */
    private $instance;

    private function __construct(RetrieveCustomerSegmentResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new retrieve customer segment response Builder object.
     */
    public static function init(): self
    {
        return new self(new RetrieveCustomerSegmentResponse());
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
     * Sets segment field.
     */
    public function segment(?CustomerSegment $value): self
    {
        $this->instance->setSegment($value);
        return $this;
    }

    /**
     * Initializes a new retrieve customer segment response object.
     */
    public function build(): RetrieveCustomerSegmentResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
