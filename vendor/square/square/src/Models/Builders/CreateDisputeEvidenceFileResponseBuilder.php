<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CreateDisputeEvidenceFileResponse;
use Square\Models\DisputeEvidence;

/**
 * Builder for model CreateDisputeEvidenceFileResponse
 *
 * @see CreateDisputeEvidenceFileResponse
 */
class CreateDisputeEvidenceFileResponseBuilder
{
    /**
     * @var CreateDisputeEvidenceFileResponse
     */
    private $instance;

    private function __construct(CreateDisputeEvidenceFileResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new create dispute evidence file response Builder object.
     */
    public static function init(): self
    {
        return new self(new CreateDisputeEvidenceFileResponse());
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
     * Initializes a new create dispute evidence file response object.
     */
    public function build(): CreateDisputeEvidenceFileResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
