<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CreateDisputeEvidenceTextResponse;
use Square\Models\DisputeEvidence;

/**
 * Builder for model CreateDisputeEvidenceTextResponse
 *
 * @see CreateDisputeEvidenceTextResponse
 */
class CreateDisputeEvidenceTextResponseBuilder
{
    /**
     * @var CreateDisputeEvidenceTextResponse
     */
    private $instance;

    private function __construct(CreateDisputeEvidenceTextResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new create dispute evidence text response Builder object.
     */
    public static function init(): self
    {
        return new self(new CreateDisputeEvidenceTextResponse());
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
     * Sets evidence field.
     */
    public function evidence(?DisputeEvidence $value): self
    {
        $this->instance->setEvidence($value);
        return $this;
    }

    /**
     * Initializes a new create dispute evidence text response object.
     */
    public function build(): CreateDisputeEvidenceTextResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
