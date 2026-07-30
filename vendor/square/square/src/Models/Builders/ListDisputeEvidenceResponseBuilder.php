<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\ListDisputeEvidenceResponse;

/**
 * Builder for model ListDisputeEvidenceResponse
 *
 * @see ListDisputeEvidenceResponse
 */
class ListDisputeEvidenceResponseBuilder
{
    /**
     * @var ListDisputeEvidenceResponse
     */
    private $instance;

    private function __construct(ListDisputeEvidenceResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new list dispute evidence response Builder object.
     */
    public static function init(): self
    {
        return new self(new ListDisputeEvidenceResponse());
    }

    /**
     * Sets evidence field.
     */
    public function evidence(?array $value): self
    {
        $this->instance->setEvidence($value);
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
     * Sets cursor field.
     */
    public function cursor(?string $value): self
    {
        $this->instance->setCursor($value);
        return $this;
    }

    /**
     * Initializes a new list dispute evidence response object.
     */
    public function build(): ListDisputeEvidenceResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
