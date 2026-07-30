<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\Dispute;
use Square\Models\RetrieveDisputeResponse;

/**
 * Builder for model RetrieveDisputeResponse
 *
 * @see RetrieveDisputeResponse
 */
class RetrieveDisputeResponseBuilder
{
    /**
     * @var RetrieveDisputeResponse
     */
    private $instance;

    private function __construct(RetrieveDisputeResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new retrieve dispute response Builder object.
     */
    public static function init(): self
    {
        return new self(new RetrieveDisputeResponse());
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
     * Sets dispute field.
     */
    public function dispute(?Dispute $value): self
    {
        $this->instance->setDispute($value);
        return $this;
    }

    /**
     * Initializes a new retrieve dispute response object.
     */
    public function build(): RetrieveDisputeResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
