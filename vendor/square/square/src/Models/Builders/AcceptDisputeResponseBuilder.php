<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\AcceptDisputeResponse;
use Square\Models\Dispute;

/**
 * Builder for model AcceptDisputeResponse
 *
 * @see AcceptDisputeResponse
 */
class AcceptDisputeResponseBuilder
{
    /**
     * @var AcceptDisputeResponse
     */
    private $instance;

    private function __construct(AcceptDisputeResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new accept dispute response Builder object.
     */
    public static function init(): self
    {
        return new self(new AcceptDisputeResponse());
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
     * Initializes a new accept dispute response object.
     */
    public function build(): AcceptDisputeResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
