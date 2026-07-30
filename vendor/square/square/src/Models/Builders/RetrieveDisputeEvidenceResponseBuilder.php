<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\DisputeEvidence;
use Square\Models\RetrieveDisputeEvidenceResponse;

/**
 * Builder for model RetrieveDisputeEvidenceResponse
 *
 * @see RetrieveDisputeEvidenceResponse
 */
class RetrieveDisputeEvidenceResponseBuilder
{
    /**
     * @var RetrieveDisputeEvidenceResponse
     */
    private $instance;

    private function __construct(RetrieveDisputeEvidenceResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new retrieve dispute evidence response Builder object.
     */
    public static function init(): self
    {
        return new self(new RetrieveDisputeEvidenceResponse());
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
     * Initializes a new retrieve dispute evidence response object.
     */
    public function build(): RetrieveDisputeEvidenceResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
